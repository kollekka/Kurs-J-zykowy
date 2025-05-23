<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreOpinionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'opinion' => 'required|string|max:1000', 
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
            'rating.required' => 'Ocena jest wymagana.',
            'rating.integer' => 'Ocena musi być liczbą całkowitą.',
            'rating.min' => 'Minimalna ocena to 1.',
            'rating.max' => 'Maksymalna ocena to 5.',
            'comment.required' => 'Komentarz jest wymagany.',
            'comment.max' => 'Komentarz nie może przekraczać 1000 znaków.',
        ];
    }
}