<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateInstructorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Zakładamy, że tylko administrator może modyfikować instruktorów
        return Auth::check() && Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $instructorId = $this->route('instructor')->id; // Pobieramy ID instruktora z trasy

        return [
            'full_name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('instructors', 'email')->ignore($instructorId),
            ],
            'bio' => 'sometimes|required|string|max:2000',
            'specialization' => 'nullable|string|max:255',
            // 'profile_image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Jeśli dodajesz obsługę obrazków
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Imię i nazwisko instruktora jest wymagane.',
            'email.required' => 'Adres email jest wymagany.',
            'bio.required' => 'Biografia instruktora jest wymagana.',
        ];
    }
}