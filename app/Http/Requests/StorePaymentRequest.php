<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'enrollment_id' => 'nullable|exists:enrollments,id', 
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|max:50',
            'status' => 'required|string|in:paid,pending,failed',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'amount.min' => 'The payment amount must be greater than 0.',
            'status.in' => 'An invalid payment status was selected.',
        ];
    }
}