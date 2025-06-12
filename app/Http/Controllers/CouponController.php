<?php

namespace App\Http\Controllers;

use App\Http\Resources\Coupon\ListCouponResource;
use App\Models\Coupon;
use App\Services\CouponService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct(
        protected CouponService $service
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.coupon.index');
    }

    public function getListOrder(Request $request): JsonResponse
    {
        $filters = $request->query('filters', []);

        $has = $request->query('has', []);
        $search = $request->query('search', []);
        $sorts = $request->query('sorts', []);
        $from = $request->query('from', []);
        $to = $request->query('to', []);
        $limit = $request->query('limit', static::LIMIT);
        $freeSearch = $request->query('q', '');
        $data = $this->service->getByConditions($filters, $has, $sorts, $search, $freeSearch, [$from, $to], $limit);
        return $this->success(
            ListCouponResource::collection($data->items()),
            [
                'current_page' => $data->currentPage(),
                'total' => $data->total(),
                'per_page' => $data->perPage(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
