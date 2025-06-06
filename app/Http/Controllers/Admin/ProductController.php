<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Http\Requests\CreateProductVariantRequest;
use App\Http\Resources\Product\Variant\ListProductVariantResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $service,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::orderBy('id', 'DESC')->paginate(50);

        return view('admin.product.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cats = Category::orderBy('name', 'ASC')->select('id', 'name')->get();
        return view('admin.product.create', compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $data = $request->validated();

        $img_name = $request->img?->hashName();

        $request->img?->move(public_path('uploads/product'), $img_name);

        $data['image'] = $img_name;

        if (!empty($data['variants'])) {
            $totalQuantity = collect($data['variants'])->sum(function ($variant) {
                return (int) $variant['stock_quantity']; 
            });
            $data['quantity'] = $totalQuantity;
        }

        if ($product = Product::create($data)) {
            if ($request->has('other_img')) {
                foreach($request->other_img as $img) {
                    $other_name = $img->hashName();

                    $img->move(public_path('uploads/product'), $other_name);
                    
                    ProductImage::create([
                        'image' => $other_name,
                        'product_id' => $product->id
                    ]);
                }
            }
            if (isset($data['variants'])) {
                $this->service->saveVariants($product, $data);
            }
            return redirect()->route('product.index')->with('ok', 'Tạo mới sản phẩm thành công');
        }
        return redirect()->back()->with('no', 'Có lỗi xảy ra, vui lòng kiểm tra lại');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $cats = Category::orderBy('name', 'ASC')->select('id', 'name')->get();
        return view('admin.product.edit', compact('cats', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->has('img')) {
            $img_name = $product->image;
            $image_path = public_path('uploads/product').'/'.$img_name;
            if (file_exists($image_path) && isset($img_name)) {
                unlink($image_path);
            }
            $img_name = $request->img->hashName();

            $request->img->move(public_path('uploads/product'), $img_name);

            $data['image'] = $img_name;
        }

        // if ($product->variants) {
        //     $data['quantity'] = 0;
        //     foreach ($product->variants as $variant) {
        //         $data['quantity'] += $variant->stock_quantity;
        //     }
        // }


        if ($product->update($data)) {
            if ($request->has('other_img')) {
                if ($product->images->count() > 0) {
                    foreach ($product->images as $img) {
                        $other_image = $img->image;
                        $other_path = public_path('uploads/product').'/'.$other_image;
                        if (file_exists($other_path)) {
                            unlink($other_path);
                        }
                    }
                    ProductImage::where('product_id', $product->id)->delete();
                }

                foreach($request->other_img as $img) {
                    $other_name = $img->hashName();

                    $img->move(public_path('uploads/product'), $other_name);
                    
                    ProductImage::create([
                        'image' => $other_name,
                        'product_id' => $product->id
                    ]);
                }
            }
            return redirect()->route('product.index')->with('ok', 'Cập nhật sản phẩm thành công');
        }
        return redirect()->back()->with('no', 'Có lỗi xảy ra, vui lòng kiểm tra lại');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $img_name = $product->image;
        $image_path = public_path('uploads/product').'/'.$img_name;
        if ($product->images->count() > 0) {
            foreach ($product->images as $img) {
                $other_image = $img->image;
                $other_path = public_path('uploads/product').'/'.$other_image;
                if (file_exists($other_path)) {
                    unlink($other_path);
                }
            }

            ProductImage::where('product_id', $product->id)->delete();

            if ($product->delete()) {
                if (file_exists($image_path) && isset($img_name)) {
                    unlink($image_path);
                }
                return redirect()->route('product.index')->with('ok', 'Xóa sản phẩm thành công');
            }
        } else {
            if ($product->delete()) {
                if (file_exists($image_path) && isset($img_name)) {
                    unlink($image_path);
                }
                return redirect()->route('product.index')->with('ok', 'Xóa sản phẩm thành công');
            }
        }
        
        return redirect()->back()->with('no', 'Có lỗi xảy ra, vui lòng kiểm tra lại');
    }

    public function destroyImage(ProductImage $image)
    {
        $img_name = $image->image;
        if ($image->delete()) {
            $image_path = public_path('uploads/product').'/'.$img_name;
            if (file_exists($image_path) && isset($img_name)) {
                unlink($image_path);
            }
            return redirect()->back()->with('ok', 'Xóa ảnh thành công');
        }
        return redirect()->back()->with('no', 'Có lỗi xảy ra, vui lòng kiểm tra lại');
    }

    public function getVariants(Request $request): JsonResponse
    {
        $data = $this->service->getVariants($request->id);
        return $this->success(
            ListProductVariantResource::collection($data)
        );
    }

    public function saveVariants(CreateProductVariantRequest $request): JsonResponse
    {
        $data = $request->validated();
        $product = Product::find($data['product_id']);
        $result = $this->service->saveVariants($product, $data);
        if (!$result) {
            return $this->failure();
        }

        return $this->success(
            ListProductVariantResource::collection($result));
    }
}
