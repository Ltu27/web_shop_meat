<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(
        protected Product $product,
        protected Coupon $coupon
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
        return $this->product
            ->search(Product::SEARCH_FIELDS, $freeSearch)
            ->from($from, Product::FROM_FIELDS)
            ->to($to, Product::TO_FIELDS)
            ->hasBy($has, Product::HAS_FIELDS)
            ->sortBy($sorts, Product::SORT_FIELDS)
            ->findInSet($filters, Product::IN_SET_FIELDS)
            ->searchBy($search, Product::SEARCH_FIELDS)
            ->filterBy($filters, Product::FILTER_FIELDS)
            ->with($relation)
            ->paginate($limit);
    }

    public function getListCoupon()
    {
        return $this->coupon->orderBy('id', 'DESC')->get();
    }

    public function getVariants(int $id) {
        return $this->product->with('variants')->find($id)->variants;
    }

    public function saveVariants(Product $product, array $variants)
{
    try {
        DB::beginTransaction();

        $product->variants()->delete();

        foreach ($variants['variants'] as $variant) {
            $product->variants()->create($variant);
        }

        DB::commit();

        return $product->variants()->get();

    } catch (\Exception $e) {
        DB::rollBack();
        report($e);
        return null;
    }
}

    public function getDetailProduct(int $id, bool $withRelation = true): ?Product
    {
        $relations = [
            'cat',
            'images',
            'variants',
            'comment',
            'coupon',
        ];
        if (!$withRelation) {
            $relations = [];
        }
        return $this->product->where('id', $id)
            ->with($relations)->first();
    }
}