<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $status = request('status', 1);
        $orders = Order::orderby('id', 'DESC')->where('status', $status)->paginate();
        return view('admin.order.index', compact('orders'));
    }

    public function show(Order $order) {
        $auth = $order->customer;
        return view('admin.order.detail', compact('order', 'auth'));
    }

    public function update(Order $order) {
        $status = request('status', 1);
        if ($order->status != 2) {
            $order->update(['status' => $status]);
            return redirect()->route('order.index')->with('ok', 'Update status successfully');
        }
        return redirect()->route('order.index')->with('no', 'Can not update delivered orders');
        
    }

    public function cancel(Order $order) 
    {
        if ($order->status == 0) {
            $order->load('details');

            $order->details()->delete();

            $order->delete();

            return redirect()->back()->with('ok', 'Hủy đơn hàng thành công');
        }

        return redirect()->back()->with('no', 'Không thể hủy đơn hàng đã giao hoặc đang giao');
    }

}
