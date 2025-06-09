<?php

namespace App\Http\Controllers;

use App\Http\Resources\Order\ListOrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $service
    ) {
    }

    public function index() {
        return view('admin.order.index');
    }

    public function getListOrder(Request $request): JsonResponse
    {
        $filters = $request->query('filters', []);
        // dd($filters);

        $has = $request->query('has', []);
        $search = $request->query('search', []);
        $sorts = ['id' => 'desc'];
        $from = $request->query('from', []);
        $to = $request->query('to', []);
        $limit = $request->query('limit', static::LIMIT);
        $freeSearch = $request->query('q', '');
        $data = $this->service->getByConditions($filters, $has, $sorts, $search, $freeSearch, [$from, $to], $limit);
        return $this->success(
            ListOrderResource::collection($data->items()),
            [
                'current_page' => $data->currentPage(),
                'total' => $data->total(),
                'per_page' => $data->perPage(),
            ]
        );
    }

    public function show(Order $order) {
        $auth = $order->customer;
        return view('admin.order.detail', compact('order', 'auth'));
    }

    public function update(Order $order) {
        try {
            $status = request('status', 1);
            $order->update(['status' => $status]);
            if($order->status == 1) {
                $order->details()->each(function ($detail) {
                    if ($detail->productVariant) {
                        $detail->productVariant->decrement('stock_quantity', $detail->quantity);
                    }
                });
            }
            return redirect()->route('order.index')->with('ok', 'Cập nhật trạng thái đơn hàng thành công');
        } catch (\Exception $e) {
            return redirect()->route('order.index')->with('no', 'Có lỗi xảy ra, vui lòng kiểm tra lại');
        }
        
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
