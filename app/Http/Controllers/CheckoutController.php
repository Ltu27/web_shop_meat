<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
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

    public function post_checkout(Request $req) {
        $auth = auth('cus')->user();

        $req->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ], [
            'name.required' => 'Họ tên không được để trống',
            'email.required' => 'Email không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'address.required' => 'Địa chỉ không được để trống',
        ]);

        $data = $req->only('name', 'email', 'phone', 'address');
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

            $order->token = $token;
            $order->save();
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
}
