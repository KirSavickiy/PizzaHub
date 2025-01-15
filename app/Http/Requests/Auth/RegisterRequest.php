<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string|min:1|max:50',
            'last_name' => 'nullable|string|min:1|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|min:1|max:50|unique:users',
            'birth_date' => 'nullable|date',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email already exists',
            'phone.required' => 'Phone number is required',
            'phone.unique' => 'Phone number already exists',
            'phone.numeric' => 'Phone number is invalid',
            'phone.min' => 'Phone number is invalid',
            'phone.max' => 'Phone number is invalid',
            'password.required' => 'Password is required',
            'password.min' => 'Password is invalid',
            'password.confirmed' => 'Password does not match',
        ];
    }
    public  function loginData(): array
    {
        return $this->only(['email', 'password']);
    }
}
