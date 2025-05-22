<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreInstructorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Zakładamy, że tylko administrator może dodawać instruktorów
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
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'bio' => 'required|string|max:2000',
            'specialization' => 'nullable|string|max:255',
            // 'profile_image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Jeśli dodajesz obsługę obrazków
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
            'full_name.required' => 'Imię i nazwisko instruktora jest wymagane.',
            'email.required' => 'Adres email jest wymagany.',
            'email.unique' => 'Ten adres email jest już zajęty.',
            'bio.required' => 'Biografia instruktora jest wymagana.',
        ];
    }
}