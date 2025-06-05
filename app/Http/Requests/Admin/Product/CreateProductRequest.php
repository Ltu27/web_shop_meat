<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
        return [
            'name' => 'required|max:150|unique:products',
            'description' => 'nullable',
            'price' => 'nullable|numeric',
            'quantity' => 'nullable|integer',
            'status' => 'nullable',
            // 'sale_price' => 'required|numeric|lte:price',
            'img' => 'nullable|file|mimes:jpg,jpeg,png,webp',
            'category_id' => 'required|exists:categories,id',
            'variants' => 'nullable|array',
            'variants.*.variant_color' => 'nullable|string',
            'variants.*.variant_price' => 'nullable|string',
            'variants.*.stock_quantity' => 'nullable|string',
            'variants.*.production_date' => 'nullable|date',
            'variants.*.expiration_date' => 'nullable|date',
        ];
    }
}
