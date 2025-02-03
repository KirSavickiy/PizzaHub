<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductItemRequest extends FormRequest
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
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'stock' => 'required|integer|between:1,1000000',
            'size' => 'nullable|integer:min:1|max:65535',
            'dough_type' => 'nullable|string:min:1|max:255',
        ];
    }
}
