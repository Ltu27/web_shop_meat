<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\CreatePaymentRequest;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function checkout() {
        $auth = auth('cus')->user();
        return view('home.checkout', compact('auth'));
    }

    public function history() {
        $auth = auth('cus')->user();
        return view('home.history', compact('auth'));
    }

    public function detail(Order $order) {
        $auth = auth('cus')->user();
        return view('home.detail', compact('auth', 'order'));
    }

    public function post_checkout(CreatePaymentRequest $req) {
        $auth = auth('cus')->user();

        $data = $req->validated();

        $data['customer_id'] = $auth->id;
        
        if ($order = Order::create($data)) {
            $token = Str::random(40);
            foreach($auth->carts as $cart) {
                $data1 = [
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'price' => $cart->price,
                    'quantity' => $cart->quantity
                ];
                
                OrderDetail::create($data1);
            }
        }
            
        $order->token = $token;
        $order->save();

        if(isset($data['payment']) == 2) {
            $totalPrice = $this->checkoutService->getToltalPrice($order);
            session(['inforCustomer' => $data]);
            return view('home.vnpay.index', compact('totalPrice'));
        } else {
            Mail::to($auth->email)->send(new OrderMail($order, $token));
            return redirect()->route('home.index')->with('ok', 'Order checkout successfully, please check your email to verify');
        }
        return redirect()->route('home.index')->with('no', 'Something error, please check again');
    }

    public function verify($token) {
        $order = Order::where('token', $token)->first();
        if ($order) {
            $order->token = null;
            $order->status = 1;
            $order->save();
            return redirect()->route('home.index')->with('ok', 'Order verify successfully');
        }
        return redirect()->route('home.index')->with('no', 'Something error, please check again');
    }

    public function createPayment(Request $request) 
    {
        try{
            $data = $request->all();
            $code_cart = rand(00, 9999);
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = env('APP_URL') . '/order/checkout';
            $vnp_TmnCode = env('vnp_TmnCode');
            $vnp_HashSecret = env('vnp_HashSecret');
    
            $vnp_TxnRef = $code_cart; 
            $vnp_OrderInfo = 'Thanh toán đơn hàng test';
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $data['total_vnpay'] * 100;
            $vnp_Locale = 'vn';
            // $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            );
    
            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }
    
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }
    
            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array(
                'code' => '00',
                'message' => 'success',
                'data' => $vnp_Url
            );
            if ($request->has('redirect')) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                return response()->json($returnData);
            }
        } catch (\Exception $e) {
            Log::error('VNPAY Payment Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);
        
            return response()->json(['error' => 'Payment creation failed: ' . $e->getMessage()], 500);
        }
        
    }
}
