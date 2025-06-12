<?php

namespace App\Services;

use App\Models\Coupon;
use Illuminate\Pagination\LengthAwarePaginator;

class CouponService
{
    public function __construct(
        protected Coupon $coupon,
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
        int $limit
    ): LengthAwarePaginator {
        $relation = [
        ];

        [$from, $to] = $range;
        return $this->coupon
            ->search(Coupon::SEARCH_FIELDS, $freeSearch)
            ->from($from, Coupon::FROM_FIELDS)
            ->to($to, Coupon::TO_FIELDS)
            ->hasBy($has, Coupon::HAS_FIELDS)
            ->sortBy($sorts, Coupon::SORT_FIELDS)
            ->findInSet($filters, Coupon::IN_SET_FIELDS)
            ->searchBy($search, Coupon::SEARCH_FIELDS)
            ->filterBy($filters, Coupon::FILTER_FIELDS)
            ->with($relation)
            ->paginate($limit);
    }

    public function create(array $data): Coupon
    {
        return $this->coupon->create($data);
    }

    public function find(string $id): ?Coupon
    {
        return $this->coupon->find($id);
    }

    public function update(Coupon $coupon, array $data): Coupon
    {
        $coupon->update($data);
        return $coupon;
    }

    public function delete(string $id): bool
    {
        return $this->coupon->destroy($id);
    }

    public function getCoupons() {
        return $this->coupon->where('status', 1)
            ->whereDate('end_date', '>=', now())
            ->get();
    }

    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json(['error' => 'Mã không hợp lệ'], 400);
        }

        $orderTotal = $request->order_total;

        if (!$coupon->isValid($orderTotal)) {
            return response()->json(['error' => 'Mã không còn hiệu lực hoặc không đủ điều kiện'], 400);
        }

        $discount = $coupon->calculateDiscount($orderTotal);

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'new_total' => $orderTotal - $discount,
        ]);
    }

}