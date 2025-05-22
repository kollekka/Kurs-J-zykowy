<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEnrollmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Tylko administrator może modyfikować status zapisu
        // Można rozbudować o inne uprawnienia, np. użytkownik może anulować swój zapis
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
            'status' => 'required|string|in:pending,active,completed,cancelled,refunded', // Przykładowe statusy
            // Można dodać inne pola do aktualizacji, np. payment_id
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Wybrano nieprawidłowy status zapisu.',
        ];
    }
}