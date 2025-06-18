<?php

namespace App\Http\Requests;

use App\Models\Lesson;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreLessonRequest extends FormRequest
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
        $lastLesson = Lesson::where('course_id', $this->input('course_id'))
                            ->orderBy('date', 'desc')
                            ->orderBy('time', 'desc')
                            ->first();

        return [
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'duration' => 'required|date_format:H:i', 
            'date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($lastLesson) {
                    if ($lastLesson && strtotime($value) < strtotime($lastLesson->date)) {
                        $fail('Data lekcji musi być późniejsza lub równa dacie ostatniej lekcji (' . $lastLesson->date . ').');
                    } elseif ($lastLesson && strtotime($value) == strtotime($lastLesson->date) && strtotime($this->input('time')) <= strtotime($lastLesson->time)) {
                        $fail('Godzina lekcji musi być późniejsza niż godzina ostatniej lekcji w tym samym dniu.');
                    }
                },
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
            'duration.date_format' => 'Duration must be in the format HH:MM (e.g. 01:30).',
        ];
    }
}