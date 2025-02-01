<?php

namespace App\Http\Requests\User\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'delivery_method' => 'required|in:pickup,delivery',
            'payment_method' => 'required|in:cash,card, online',
            'delivery_time' => 'required|date_format:Y-m-d H:i:s',
            'address_id' => 'nullable|exists:addresses,id',
        ];
    }
}
