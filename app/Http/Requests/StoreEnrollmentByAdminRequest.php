<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEnrollmentByAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Tylko zalogowany administrator może utworzyć zapis w ten sposób
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
            'course_id' => 'required|exists:courses,id',
            'enrollment_date' => 'required|date',
            'status' => 'required|string|in:pending,active,completed,cancelled,refunded', // Dostosuj statusy
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Wybór użytkownika jest wymagany.',
            'course_id.required' => 'Wybór kursu jest wymagany.',
        ];
    }
}