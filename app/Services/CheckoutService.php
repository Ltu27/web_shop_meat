<?php

namespace App\Services;

class CheckoutService
{
    public function __construct()
    {
        
    }

    public function getToltalPrice($order)
    {
        $total = 0;
        foreach ($order->details as $detail) {
            $total += $detail->price * $detail->quantity;
        }
        $total = number_format($total);
        return $total;
    }
}