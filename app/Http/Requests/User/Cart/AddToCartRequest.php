<?php

namespace App\Http\Requests\User\Cart;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
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
            'product_item_id' => 'bail|required|int|exists:product_items,id',
            'cart_id' => 'bail|nullable|exists:carts,session_id',
        ];
    }
    public function messages(): array
    {
        return [
            'product_item_id.required' => 'The product ID is required to add an item to the cart.',
            'product_item_id.numeric' => 'The product ID must be a valid number.',
            'product_item_id.exists' => 'The product with the given ID does not exist in our records.',
        ];
    }
}
