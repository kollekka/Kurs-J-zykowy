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
            'currency' => 'required|string|max:3', 
            'payment_method' => 'required|string|max:50',
            'status' => 'required|string|in:pending,completed,failed,refunded',
            'transaction_id' => 'nullable|string|max:255',
            'paid_at' => 'nullable|date',
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
            'amount.min' => 'Kwota płatności musi być większa niż 0.',
            'status.in' => 'Wybrano nieprawidłowy status płatności.',
        ];
    }
}