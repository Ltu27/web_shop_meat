<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductVariantRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'variants' => 'nullable|array',
            'variants.*.production_date' => 'nullable|string',
            'variants.*.stock_quantity' => 'required|string',
            'variants.*.variant_color' => 'nullable|string', 
            'variants.*.variant_price' => 'nullable|string', 
            'variants.*.expiration_date' => 'nullable|string',
        ];
    }
}
