<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $topBanner = Banner::getBanner()->first();
        $galleries = Banner::getBanner('gallery')->get();

        $new_products = Product::orderBy('created_at', 'DESC')->limit(2)->get();
        $feature_products = Product::inRandomOrder()->limit(4)->get();

        return view('home.index', compact('topBanner', 'galleries', 'new_products', 'feature_products'));
    }
    
    public function about() {
        return view('home.about');
    }

    public function category(Category $cat) {
        $products = $cat->products()->paginate(9);
        $new_products = Product::orderBy('created_at', 'DESC')->limit(3)->get();
        return view('home.category', compact('cat', 'products', 'new_products'));
    }

    public function product(Product $product) {
        $products = Product::where('category_id', $product->category_id)->limit(12)->get();
        return view('home.product', compact(
            'product', 
            'products',
        ));
    }

    public function favorite($product_id) {
        $data = [
            'product_id' => $product_id,
            'customer_id' => auth('cus')->id()
        ];

        $favorited = Favorite::where(['product_id' => $product_id, 'customer_id' => auth('cus')->id()])->first();

        if($favorited) {
            $favorited->delete();
            return redirect()->back()->with('ok', 'Bạn đã bỏ yêu thích sản phẩm');
        } else {
            Favorite::create($data);
            return redirect()->back()->with('ok', 'Bạn đã yêu thích sản phẩm');
        }
    }

    public function searchProduct(Request $request)
    {
        $products = Product::where('name', 'LIKE', '%'.$request['searchProduct'].'%')->get();
        if(count($products) > 0) {
            return view('home.product.search-product', [
                'products' => $products
                ]);
        } else {
            return view('trangchu', [
                'products' => DB::table('sanpham')->paginate(16)
            ]);
        }
    }
}
