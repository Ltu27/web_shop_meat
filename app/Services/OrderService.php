<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderService
{
    public function __construct(
        protected Order $order,
    )
    {
    }

    public function getByConditions(
        array $filters = [],
        array $has = [],
        array $sorts = [],
        array $search = [],
        string $freeSearch = '',
        array $range = [[], []],
        int $limit = 10,
        int $page = 1
    ): LengthAwarePaginator {
        [$from, $to] = $range;    
        return $this->order
            ->search(Order::SEARCH_FIELDS, $freeSearch)
            ->from($from, Order::FROM_FIELDS)
            ->to($to, Order::TO_FIELDS)
            ->hasBy($has, Order::HAS_FIELDS)
            ->sortBy($sorts, Order::SORT_FIELDS)
            ->findInSet($filters, Order::IN_SET_FIELDS)
            ->searchBy($search, Order::SEARCH_FIELDS)
            ->filterBy($filters, Order::FILTER_FIELDS)
            ->paginate($limit, ['*'], 'page', $page); 
    }

    
}