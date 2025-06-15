<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

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

    public function getTopStockProducts($limit = 10)
    {
        return DB::table('products')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->select('products.id', 'products.name', DB::raw('SUM(product_variants.stock_quantity) as total_stock'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_stock')
            ->limit($limit)
            ->get();
    }

    public function getTopSellingProducts($month = null, $year = null, $limit = 10)
    {
        $query = Order::whereIn('status', [3, 4]);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        return $query->with('details.product')
            ->get()
            ->flatMap->details
            ->groupBy('product_id')
            ->map(function ($details) {
                return [
                    'name' => $details->first()->product->name ?? 'N/A',
                    'total' => $details->sum('quantity'),
                ];
            })
            ->sortByDesc('total')
            ->take($limit)
            ->values();
    }

}