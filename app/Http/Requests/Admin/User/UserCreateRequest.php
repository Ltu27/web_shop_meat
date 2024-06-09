<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => 'required|min:4|max:150',
            'phone' => 'max:20',
            'address' => 'min:4',
            'description' => 'min:4',
            'email' => 'unique:users',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name can not empty!',
            'name.min' => 'Name must have at least 4 characters',
            'name.max' => 'Name must have at most 4 characters',
            'phone.max' => 'Phone must have at most 20 characters',
            'address.min' => 'Address must have at least 4 characters',
            'description.min' => 'Description must have at least 4 characters',
            'email.unique' => 'Email already exist',
        ];
    }
}
