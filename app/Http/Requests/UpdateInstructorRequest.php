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
        return Auth::check() && Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $instructorId = $this->route('instructor')->id; 

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
            
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Instructor full name is required.',
            'email.required' => 'Email address is required.',
            'bio.required' => 'Instructor biography is required.',
        ];
    }
}