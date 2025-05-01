<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function store(Request $request)
    {

        $lastLesson = Lesson::where('course_id', $request->course_id)
                            ->orderBy('date', 'desc')
                            ->orderBy('time', 'desc')
                            ->first();

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'duration' => 'required|date_format:H:i',
            'date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($lastLesson) {
                    if ($lastLesson && $value <= $lastLesson->date) {
                        $fail('Data lekcji musi być późniejsza niż data ostatniej lekcji (' . $lastLesson->date . ').');
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
        ]);

        // Tworzenie lekcji
        Lesson::create($request->all());

        return redirect()->back();
    }

        public function edit($id)
        {
            $lesson = Lesson::findOrFail($id);
            return view('edit', compact('lesson'));
        }

    public function update(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'order' => 'required|integer|min:1|unique:lessons,order,' . $lesson->id . ',id,course_id,' . $lesson->course_id,
            'duration' => 'required|date_format:H:i|max:02:00|min:00:30',
            'date' => 'required|date|after:' . $lesson->date , 
            'time' => 'required|date_format:H:i|max:20:00|min:08:00',
        ]);

        $lesson->update($request->all());

        return redirect()->route('admin.editCourse')->with('success', 'Lekcja została zaktualizowana.');
    }
}
