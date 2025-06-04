<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Coupon;
use App\Rules\PriceGreaterThanValueFixed;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $coupon = null;

        // if ($this->filled('coupon_id')) {
        //     $coupon = Coupon::find($this->coupon_id);
        // }
        
        return [
            'name' => 'required|min:4|max:150|unique:products,name,'.$this->product->id,
            'description' => 'nullable|min:4',
            'price' => [
                'nullable', 
                'numeric',
                // new PriceGreaterThanValueFixed($coupon),
            ],
            // 'sale_price' => 'required|numeric|lte:price',
            // 'coupon_id' => 'nullable|exists:coupons,id',
            'img' => 'nullable|file|mimes:jpg,jpeg,png,gif',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required',
            // 'quantity' => 'nullable|numeric|min:1'
        ];
    }
}
