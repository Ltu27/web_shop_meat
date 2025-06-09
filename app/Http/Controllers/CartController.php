<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddToCartRequest;
use App\Models\Product;
use App\Models\Cart;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function addToCard(Product $product, AddToCartRequest $request) {
        try {
            $product->load('variants');
            $data = $request->validated();

            $cus_id = auth('cus')->id();

            $variant = ProductVariant::find($data['variant_id']);
            $checkQuantity = $this->checkQuantity($variant, $data['quantity']);
            if (!$checkQuantity) {
                return response()->json([
                    'status' => 'no',
                    'message' => 'Số lượng sản phẩm không đủ'
                ], 400);
            }
            $cartExist = Cart::where([
                'customer_id' => $cus_id, 
                'product_id' => $product->id,
                'variant_id' => $data['variant_id']
            ])->first();
        
            if ($cartExist) {
                if(($cartExist->quantity + $data['quantity']) > $variant->stock_quantity) {
                    return response()->json([
                        'status' => 'no',
                        'message' => 'Số lượng sản phẩm không đủ'
                    ], 400);
                }
                Cart::where('customer_id', $cus_id)
                    ->where('product_id', $product->id)
                    ->where('variant_id', $data['variant_id'])
                    ->update(['quantity' => DB::raw("quantity + {$data['quantity']}")]);

                return response()->json([
                    'status' => 'ok',
                    'message' => 'Thêm sản phẩm vào giỏ hàng thành công',
                ]);
            } else {
                $data['customer_id'] = $cus_id;
                $data['product_id'] = $product->id;
                $data['price'] = $variant->variant_price;
                
                if (Cart::create($data)) {
                    return response()->json([
                        'status' => 'ok',
                        'message' => 'Thêm sản phẩm vào giỏ hàng thành công',
                    ]);
                }
            }        
        } catch (\Exception $e) {
            Log::error('Error adding product to cart: ' . $e->getMessage());
            return response()->json([
                'status' => 'no',
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'
            ], 500);
        }
        
    }    

    public function checkQuantity(ProductVariant $variant, int $quantity) 
    {
        $availableQuantity = $variant->stock_quantity;
        if ($quantity > $availableQuantity) {
            return false;
        }
        return true;
    }

    public function updateQuantity(Product $product, Request $request) {
        try {
            $data = $request->validate([
                'quantity' => 'required|integer|min:1',
                'variant_id' => 'required|exists:product_variants,id'
            ]);

            $cus_id = auth('cus')->id();
            $cart = Cart::where([
                'customer_id' => $cus_id,
                'product_id' => $product->id,
                'variant_id' => $data['variant_id']
            ])->first();

            if ($cart) {
                if ($this->checkQuantity(ProductVariant::find($data['variant_id']), $data['quantity'])) {
                    $cart->update(['quantity' => $data['quantity']]);
                    return response()->json(['status' => 'ok', 'message' => 'Cập nhật số lượng thành công']);
                } else {
                    return response()->json(['status' => 'no', 'message' => 'Số lượng không đủ']);
                }
            } else {
                return response()->json(['status' => 'no', 'message' => 'Sản phẩm không có trong giỏ hàng']);
            }
        } catch (\Exception $e) {
            Log::error('Error updating cart quantity: ' . $e->getMessage());
            return response()->json(['status' => 'no', 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'], 500);
        }
    }
}
