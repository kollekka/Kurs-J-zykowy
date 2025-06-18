<?php

namespace App\Http\Requests;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEnrollmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Użytkownik musi być zalogowany, aby się zapisać
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
            'course_id' => [
                'required',
                'exists:courses,id',
                function ($attribute, $value, $fail) {
                    
                    $existingEnrollment = Enrollment::where('user_id', Auth::id())
                        ->where('course_id', $value)
                        ->whereIn('status', ['pending', 'active']) 
                        ->exists();
                    if ($existingEnrollment) {
                        $fail('You are already enrolled.');
                    }
                    $course = Course::find($value);
                    if ($course && $course->start_date < now()->toDateString() && $course->end_date < now()->toDateString()) {
                        $fail('Course has already ended.');
                    }
                }
            ],
            'payment_method' => 'required|string|in:card,bank_transfer,paypal', 
        ];
    }
}