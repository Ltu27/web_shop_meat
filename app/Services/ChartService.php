<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class ChartService
{
    public function __construct(
        protected Product $product,
        protected Order $order,
    )
    {
    }

    public function getTotalProducts()
    {
        return $this->product->count();
    }

    public function getTotalOrderWithStatus($status)
    {
        return $this->order->where('status', $status)->count();
    }
}