<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StoreCourseRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'language' => 'required|string|max:50', 
            'level' => 'required|string|in:A1,A2,B1,B2,C1,C2',
            'description' => 'nullable|string|max:5000',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
                function ($attribute, $value, $fail) {
                    $startDate = Carbon::parse($this->input('start_date'));
                    $endDate = Carbon::parse($value);
                    if ($endDate->lt($startDate->copy()->addDays(7))) {
                        $fail('Data zakończenia musi być co najmniej 7 dni po dacie rozpoczęcia.');
                    }
                },
            ],
            'price' => 'required|numeric|min:0|max:9999.99',
            'group_size' => 'required|integer|min:1|max:50', 
            'instructor_id' => 'required|exists:instructors,id',
           
        ];
    }
}