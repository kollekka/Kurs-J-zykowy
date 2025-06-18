<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Instructor; 
use App\Models\Opinion;
use App\Http\Requests\StoreCourseRequest; 
use App\Http\Requests\UpdateCourseRequest; 
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;

class CourseController extends Controller
{
    public function show($id)
    {
        $hasScheduleConflict = false;
        $user = Auth::user();
        $course = Course::with(['lessons', 'instructor']) 
                        ->withCount('enrollments')
                        ->findOrFail($id);
        if ($user) {
            
            $userEnrollments = $user->enrollments()->with('course')->get();
            if ($userEnrollments->count() > 0) {
                $currentCourseStartDate = Carbon::parse($course->start_date);
                $currentCourseEndDate = Carbon::parse($course->end_date);

                foreach ($userEnrollments as $enrollment) {
                    
                    if ($enrollment->course && $enrollment->course_id != $course->id) {
                        $userEnrolledCourseStartDate = Carbon::parse($enrollment->course->start_date);

                        if ($userEnrolledCourseStartDate->gte($currentCourseStartDate) &&
                            $userEnrolledCourseStartDate->lte($currentCourseEndDate)) {
                            $hasScheduleConflict = true;
                            break; 
                        }
                    }
                }
            }
        }

       
        $course = Course::with('lessons')->withCount('enrollments')->findOrFail($id);
        $opinions =  Opinion::where('course_id', $id)->with('user')->get();
        $rating = $opinions->avg('rating');
        $currentDate = now();
        
        return view('course', compact('course','opinions','rating','currentDate','hasScheduleConflict'));
        
    }

    public function index(Request $request)
    {
        $query = Course::query();

    
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }
    
        if ($request->filled('language')) {
            $query->where('language', 'like', '%' . $request->language . '%');
        }
    
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
    
       
        $courses = $query->paginate(6)->appends($request->query());
        $languages = Course::Select('language')->distinct()->pluck('language');
    
        return view('courses', compact('courses','languages'));
    
    }

   
    public function adminIndex()
    {
        $courses = Course::with('instructor')->latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

   
    public function create()
    {
        $instructors = Instructor::orderBy('full_name')->pluck('full_name', 'id');
        return view('admin.courses.create', compact('instructors'));
    }

   
    public function store(StoreCourseRequest $request)
    {
        Course::create($request->validated());

        return redirect()->route('admin.courses.index')->with('success', 'Kurs został pomyślnie dodany.');
    }

    
    public function edit(Course $course) 
    {
        $instructors = Instructor::orderBy('full_name')->get();
        return view('admin.courses.edit', compact('course', 'instructors'));
    }

   
    public function update(UpdateCourseRequest $request, Course $course) 
    {
        $course->update($request->validated());

        return redirect()->route('admin.courses.index')->with('success', 'Kurs został zaktualizowany.');
    }


    public function destroy(Course $course) 
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Kurs został usunięty.');
    }
}