<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index() {
        $topBanner = Banner::getBanner()->first();
        $galleries = Banner::getBanner('gallery')->get();

        $new_products = Product::where('status', 1)->orderBy('created_at', 'DESC')->limit(2)->get();
        $feature_products = Product::where('status', 1)->inRandomOrder()->limit(4)->get();

        return view('home.index', compact('topBanner', 'galleries', 'new_products', 'feature_products'));
    }
    
    public function about() {
        return view('home.about');
    }

    public function category(Category $cat) {
        $products = $cat->products()->where('status', 1)->paginate(9);
        $new_products = Product::where('status', 1)->orderBy('created_at', 'DESC')->limit(3)->get();
        return view('home.category', compact('cat', 'products', 'new_products'));
    }

    public function product(Product $product) {
        $products = Product::where(['category_id' => $product->category_id, 'status' => 1])->limit(12)->get();
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
        $keyword = trim($request->input('searchProduct'));

        if (empty($keyword)) {
            return redirect()->back()->with('no', 'Vui lòng nhập từ khóa tìm kiếm.');
        }

        $products = Product::where('status', 1)->where('name', 'LIKE', '%' . $keyword . '%')->get();

        if ($products->isNotEmpty()) {
            return view('home.product.search-product', compact('products'));
        } else {
            return redirect()->back()->with('no', 'Không có kết quả phù hợp!');
        }
    }

    public function blog() {
        $blogs = Blog::orderBy('id', 'DESC')->paginate(4);
        return view('home.blog', compact('blogs'));
    }
}
