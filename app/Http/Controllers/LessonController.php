<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Instructor;
use App\Models\Course; 
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use Illuminate\Support\Facades\Auth; 

class LessonController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('course_id')) {
            $lessons = Lesson::where('course_id', $request->course_id)
                ->orderBy('date')
                ->orderBy('time')
                ->paginate(15);
            $course = Course::find($request->course_id); // Opcjonalnie, aby przekazać dane kursu do widoku
            return view('admin.lessons.index', compact('lessons', 'course'));
        }
        
        $lessons = Lesson::with('course')
            ->orderBy('date')
            ->orderBy('time')
            ->paginate(15);
        return view('admin.lessons.index', compact('lessons'));
    }

    public function create(Request $request)
{
    $course_id_from_query = $request->query('course_id');
    $selectedCourse = null;

    if ($course_id_from_query) {
        $selectedCourse = Course::find($course_id_from_query);
    }

    $availableCourses = Course::orderBy('name')->get(); 
    $instructors = Instructor::orderBy('full_name')->get(); 

   
    return view('admin.lessons.create', compact('availableCourses', 'instructors', 'selectedCourse'));
}

    public function store(StoreLessonRequest $request)
    {
        $lesson = Lesson::create($request->validated());

        return redirect()->route('admin.lessons.index', $lesson->course_id)->with('success', 'Lekcja została pomyślnie dodana.');
    }

    // public function show(Lesson $lesson)
    // {
    //     if (!Auth::check()) {
    //         return redirect()->route('login')->with('error', 'Musisz być zalogowany, aby zobaczyć tę lekcję.');
    //     }

    //     $user = Auth::user();
    //     if (!$user->is_admin && !$user->enrollments()->where('course_id', $lesson->course_id)->exists()) {
    //         return redirect()->route('courses.index')->with('error', 'Nie masz dostępu do tej lekcji.');
    //     }

    //     return view('lessons.show', compact('lesson')); 
    // }

    public function edit(Lesson $lesson) // Route Model Binding
    {
        $availableCourses = Course::orderBy('name')->get();
        $instructors = Instructor::orderBy('full_name')->get();

        return view('admin.lessons.edit', compact('lesson', 'availableCourses', 'instructors'));
    }

    public function update(UpdateLessonRequest $request, Lesson $lesson) // Używamy Route Model Binding
    {
        // Walidacja jest teraz obsługiwana przez UpdateLessonRequest
        $lesson->update($request->validated());

        return redirect()->route('admin.lessons.index', $lesson->course_id)->with('success', 'Lekcja została zaktualizowana.');
    }

    public function destroy(Lesson $lesson) 
    {
        $courseId = $lesson->course_id; 
        $lesson->delete();

        return redirect()->route('admin.lessons.index', $courseId)->with('success', 'Lekcja została usunięta.');
    }
}
