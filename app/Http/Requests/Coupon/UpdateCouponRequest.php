<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
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
            'code' => 'required|unique:coupons,code,' . ($this->route('coupon')->id ?? $this->route('coupon')),
            'discount' => 'required|string|min:0',
            'end_date' => 'nullable|date',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|boolean',
        ];
    }
}
