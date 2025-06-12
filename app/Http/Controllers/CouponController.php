<?php

namespace App\Http\Controllers;

use App\Http\Requests\Coupon\CreateCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;
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

    public function getListCoupon(Request $request): JsonResponse
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
    public function store(CreateCouponRequest $request)
    {
        try{
            $data = $request->validated();
            $this->service->create($data);
            return redirect()->route('coupon.index')->with('ok', 'Thêm mã giảm giá thành công');
        }catch(\Exception $e){
            return redirect()->back()->with('no', $e->getMessage());
        }
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
        $coupon = $this->service->find($id);
        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, string $id)
    {
        try{
            $data = $request->validated();
            $this->service->update($this->service->find($id), $data);
            return redirect()->route('coupon.index')->with('ok', 'Cập nhật mã giảm giá thành công');
        }catch(\Exception $e){
            return redirect()->back()->with('no', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->delete($id);
        return redirect()->route('coupon.index')->with('ok', 'Xoá mã giảm giá thành công');
    }
}
