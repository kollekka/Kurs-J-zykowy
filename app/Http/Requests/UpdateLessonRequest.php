<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Lesson; 

class UpdateLessonRequest extends FormRequest
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
        $lesson = $this->route('lesson'); 

        return [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'duration' => 'required|date_format:H:i', 
            'date' => [
                'required',
                'date',
               
            ],
            'time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $timeInSeconds = strtotime($value);
                    $startTime = strtotime('08:00');
                    $endTime = strtotime('20:00');

                    if ($timeInSeconds < $startTime || $timeInSeconds > $endTime) {
                        $fail('Godzina lekcji musi być między 08:00 a 20:00.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'duration.date_format' => 'Duration must be in the format HH:MM (e.g., 01:30).',
            'time.date_format' => 'Time must be in the format HH:MM.',
        ];
    }
}