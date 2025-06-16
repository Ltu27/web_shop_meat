<?php

namespace App\Http\Controllers;

use App\Constants\OrderConstant;
use App\Http\Requests\Payment\CreatePaymentRequest;
use App\Mail\OrderMail;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use App\Services\CheckoutService;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $checkoutService;

    public function __construct(
        CheckoutService $checkoutService,
        protected CouponService $couponService,
    )
    {
        $this->checkoutService = $checkoutService;
    }

    public function checkout(Request $request) {
        $auth = auth('cus')->user();
    
        $productIds = $request->input('products', []);
        
        $cartsChoosen = Cart::whereIn('id', $productIds)->get();
        $coupons = $this->couponService->getCoupons();
    
        if ($cartsChoosen->isEmpty()) {
            return redirect()->back()->with('no', 'Vui lòng chọn sản phẩm để đặt hàng.');
        }
    
        return view('home.checkout', compact('auth', 'cartsChoosen', 'coupons'));
    }

    public function checkoutResult(Request $request) {
        $auth = auth('cus')->user();
        $coupons = $this->couponService->getCoupons();
        return view('home.checkout', compact(
            'auth',
            'coupons'
        ));
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
        $data['status'] = OrderConstant::STATUS_PENDING; 
        
        $cartIds = $req->input('cart_ids', []);
        $cartsChoosen = Cart::whereIn('id', $cartIds)->get();

        if ($order = Order::create($data)) {
            $token = Str::random(40);
            foreach($cartsChoosen as $cart) {
                $data1 = [
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'price' => $cart->price,
                    'quantity' => $cart->quantity,
                    'variant_id' => $cart->variant_id,
                ];
                
                OrderDetail::create($data1);
            }
        }
            
        $order->total_price = $order->getTotalPriceAttribute();
        $order->token = $token;
        $order->save();

        if (!empty($data['coupon_id'])) {
            $coupon = Coupon::find($data['coupon_id']);
            if ($coupon && $coupon->quantity > 0) {
                $coupon->decrement('quantity');
            }
        }

        if(isset($data['payment']) == 2) {
            $totalPrice = $this->checkoutService->getToltalPrice($order);
            session(['inforCustomer' => $data]);
            return view('home.vnpay.index', compact('totalPrice'));
        } else {
            $auth->carts()->whereIn('id', $cartIds)->delete();
            return redirect()->route('home.index')->with('ok', 'Chọn phương thức thanh toán thành công, vui lòng đợi người quản trị xác nhận đơn hàng');
        }
        return redirect()->route('home.index')->with('no', 'Có lỗi xảy ra, vui lòng kiểm tra lại');
    }

    public function verify($token) {
        $order = Order::where('token', $token)->first();
        if ($order) {
            $order->token = null;
            $order->status = 1;
            $order->save();
            return redirect()->route('home.index')->with('ok', 'Xác thực đơn hàng thành công');
        }
        return redirect()->route('home.index')->with('no', 'Có lỗi xảy ra, vui lòng kiểm tra lại');
    }

    public function createPayment(Request $request) 
    {
        $cartIds = $request->input('cart_ids', []);
        $couponId = $request->input('coupon_id', null);
        try {
            DB::beginTransaction();
            $auth = auth('cus')->user();
            $data = $request->all();

            $order = Order::create([
                'customer_id' => $auth->id,
                'name' => $auth->name,
                'email' => $auth->email,
                'phone' => $auth->phone,
                'address' => $auth->address,
                'status' => OrderConstant::STATUS_PAID, 
                'total_price' => $data['total_vnpay'],
                'payment_type' => 1,
                'coupon_id' => $couponId,
            ]);

            $cartIds = $request->input('cart_ids', []);

            $cartsChoosen = Cart::whereIn('id', $cartIds)->get();
            
            foreach ($cartsChoosen as $cart) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'price' => $cart->price,
                    'quantity' => $cart->quantity,
                    'variant_id' => $cart->variant_id,
                ]);

                $variant = ProductVariant::find($cart->variant_id);
                if ($variant) {
                    if ($variant->stock_quantity < $cart->quantity) {
                        throw new \Exception("Sản phẩm '{$variant->name}' không đủ số lượng tồn kho.");
                    }
                    $variant->stock_quantity -= $cart->quantity;
                    $variant->save();
                }
            }

            $order->total_price = $order->getTotalPriceAttribute();

            $token = Str::random(40);
            $order->token = $token;
            $order->save();

            if ($couponId) {
                $coupon = Coupon::find($couponId);
                if ($coupon && $coupon->quantity > 0) {
                    $coupon->decrement('quantity');
                }
            }

            $auth->carts()->whereIn('id', $cartIds)->delete();

            // Thanh toán VNPAY
            $code_cart = rand(00, 9999);
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = route('order.checkout') . '?success=1';
            $vnp_TmnCode = env('vnp_TmnCode');
            $vnp_HashSecret = env('vnp_HashSecret');

            $vnp_TxnRef = $code_cart; 
            $vnp_OrderInfo = 'Thanh toán đơn hàng #' . $order->id;
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $data['total_vnpay'] * 100;
            $vnp_Locale = 'vn';
            $vnp_IpAddr = $request->ip();

            $inputData = [
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
            ];

            ksort($inputData);
            $query = "";
            $hashdata = "";
            $i = 0;
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
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

            $returnData = [
                'code' => '00',
                'message' => 'success',
                'data' => $vnp_Url
            ];
            DB::commit();

            return response()->json($returnData);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => '99',
                'message' => 'Lỗi thanh toán: ' . $e->getMessage()
            ]);
        }
    }

}
