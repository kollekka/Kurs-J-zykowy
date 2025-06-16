<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateUserByAdminRequest extends FormRequest
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
        $userId = $this->route('user')->id; 

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('users', 'name')->ignore($userId)],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], 
            'current_password' => [ 
                'nullable',
                'required_with:password', 
                'string',
                function ($attribute, $value, $fail) {
                    if ($this->filled('password') && !Hash::check($value, Auth::user()->password)) {
                        $fail('Twoje bieżące hasło administratora jest nieprawidłowe.');
                    }
                },
            ],
            'is_admin' => ['sometimes', 'boolean'], 
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
            'current_password.required_with' => 'Your current (administrator) password is required to change the edited user\'s password.',
        ];
    }
}
