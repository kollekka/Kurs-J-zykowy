<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Instructor;
use App\Models\Course; 
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use Carbon\Carbon;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('course_id')) {
            $lessons = Lesson::where('course_id', $request->course_id)
                ->orderBy('date')
                ->orderBy('time')
                ->paginate(15);
            $course = Course::find($request->course_id); 
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

 
    public function edit(Lesson $lesson) 
    {
        $availableCourses = Course::orderBy('name')->get();
        $instructors = Instructor::orderBy('full_name')->get();

        return view('admin.lessons.edit', compact('lesson', 'availableCourses', 'instructors'));
    }

    public function update(UpdateLessonRequest $request, Lesson $lesson) 
    {
       
        $lesson->update($request->validated());

        return redirect()->route('admin.lessons.index', $lesson->course_id)->with('success', 'Lekcja została zaktualizowana.');
    }

    public function destroy(Lesson $lesson) 
    {
        $courseId = $lesson->course_id; 
        $lesson->delete();

        return redirect()->route('admin.lessons.index', $courseId)->with('success', 'Lekcja została usunięta.');
    }
   public function calendar()
    {
         $user = auth()->user();
        $enrolledCourseIds = $user->enrollments()->pluck('course_id');

        
        $activeEnrollments = $user->enrollments()
            ->where('status', 'active')
            ->pluck('course_id');

        $lessons = Lesson::whereIn('course_id', $activeEnrollments)
            ->with('course') 
            ->get();

        $events = $lessons->map(function($lesson) {
             return [
                'title' => ($lesson->course->name ?? 'Course') . ' — ' . $lesson->title,
                'start' => $lesson->date . 'T' . $lesson->time,
                'lessonTitle' => $lesson->title,
                'courseName' => $lesson->course->name,
                'instructorName' => $lesson->instructor->full_name ?? null,
                'lessonDescription' => $lesson->description,
                'duration' => $lesson->duration,
            ];
        });

        $userCourses = Course::whereIn('id', $activeEnrollments)->orderBy('name')->get();
        $now = Carbon::now();
        $upcomingLessons = $lessons->filter(function ($lesson) use ($now) {
            return Carbon::parse($lesson->date . ' ' . $lesson->time)->gte($now);
        })->sortBy(function ($lesson) {
            return Carbon::parse($lesson->date . ' ' . $lesson->time);
        });
        $nextLessonDate = $upcomingLessons->first() ? Carbon::parse($upcomingLessons->first()->date)->toDateString() : null;


        return view('calendar', compact('events','nextLessonDate','userCourses'));
    }
}
