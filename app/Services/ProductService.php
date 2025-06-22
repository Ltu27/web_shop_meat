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
        return $this->product
        ->with(['variants.carts', 'variants.orderDetails'])
        ->find($id)
        ->variants;
    }

    public function saveVariants(Product $product, array $data)
    {
        try {
            DB::beginTransaction();

            $incoming = collect($data['variants']);

            $incomingIds = $incoming->pluck('id')->filter()->map(fn($id) => (int)$id)->toArray();

            $product->variants()->whereNotIn('id', $incomingIds)->each(function ($variant) {
                $used = $variant->carts()->exists() || $variant->orderDetails()->exists();
                if (!$used) {
                    $variant->delete();
                }
            });

            foreach ($incoming as $variantData) {
                if (!empty($variantData['id'])) {
                    $variant = $product->variants()->find($variantData['id']);
                    if ($variant) {
                        $used = $variant->carts()->exists() || $variant->orderDetails()->exists();
                        if (!$used) {
                            $variant->update($variantData);
                        }
                    }
                } else {
                    $product->variants()->create($variantData);
                }
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