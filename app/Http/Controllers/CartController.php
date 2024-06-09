<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() {
        return view('home.cart');
    }

    public function add(Product $product, Request $req) {
        $quantity = $req->quantity ? floor($req->quantity) : 1;
        $cus_id = auth('cus')->id();
        $cartExist = Cart::where([
            'customer_id' => $cus_id, 
            'product_id' => $product->id
        ])->first();

        if ($cartExist) {
            Cart::where([
                'customer_id' => $cus_id,
                'product_id' => $req->id
            ])->increment('quantity', $quantity);
            return redirect()->route('cart.index')->with('ok', __('common.cart.update_quantity_product'));
        } else {
            $data = [
                'customer_id' => auth('cus')->id(),
                'product_id' => $product->id,
                'price' =>$product->sale_price ? $product->sale_price : $product->price,
                'quantity' => $quantity
            ];
    
            if (Cart::create($data)) {
                return redirect()->route('cart.index')->with('ok', __('common.cart.add_product'));
            }
        }
        return redirect()->back()->with('no', __('common.error'));
    }

    public function update(Product $product, Request $req) {
        $quantity = $req->quantity ? floor($req->quantity) : 1;
        $cus_id = auth('cus')->id();
        $cartExist = Cart::where([
            'customer_id' => $cus_id, 
            'product_id' => $product->id
        ])->first();

        if ($cartExist) {
            Cart::where([
                'customer_id' => $cus_id,
                'product_id' => $product->id
            ])->update([
                'quantity' => $quantity
            ]);
            return redirect()->route('cart.index')->with('ok', __('common.cart.update_quantity_product'));
        } 
        return redirect()->back()->with('no', __('common.error'));
    }

    public function delete($product_id) {
        $cus_id = auth('cus')->id();
        Cart::where([
            'customer_id' => $cus_id,
            'product_id' => $product_id
        ])->delete();
        return redirect()->back()->with('ok', __('common.cart.delete_product'));
    }

    public function clear() {
        $cus_id = auth('cus')->id();
        Cart::where([
            'customer_id' => $cus_id
        ])->delete();
        return redirect()->back()->with('ok', __('common.cart.delete_all_product'));
    }
}
