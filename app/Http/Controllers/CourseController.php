<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Opinion;


class CourseController extends Controller
{
    public function show($id)
    {

       
        $course = Course::with('lessons')->withCount('enrollments')->findOrFail($id);
        $opinions =  Opinion::where('course_id', $id)->with('user')->get();
        $rating = $opinions->avg('rating');

        
        return view('course', compact('course','opinions','rating'));
        
    }

    public function index(Request $request)
    {
        $query = Course::query();

        // Filtruj według poziomu zaawansowania
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }
    
        // Filtruj według języka
        if ($request->filled('language')) {
            $query->where('language', 'like', '%' . $request->language . '%');
        }
    
        // Filtruj według maksymalnej ceny
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
    
        $languages = Course::select('language')->distinct()->pluck('language');
        // Paginacja
        $courses = $query->paginate(16);
    
        return view('courses', compact('courses','languages'));
    
    }

    public function enroll(Request $request, $courseId)
    {
        $user = auth()->user();


        $newCourseDates = Lesson::where('course_id', $courseId)->pluck('date')->unique();

        $userCourses = $user->enrollments->pluck('course_id');
        $userCourseDates = Lesson::whereIn('course_id', $userCourses)->pluck('date')->unique();

        $conflictingDates = $newCourseDates->intersect($userCourseDates);

        if ($conflictingDates->isNotEmpty()) {
            return redirect()->back()->withErrors([
                'error' => 'Nie możesz zapisać się na ten kurs, ponieważ lekcje kolidują z innymi kursami w dniach: ' . $conflictingDates->implode(', '),
            ]);
        }

        $user->enrollments()->attach($courseId);

        return redirect()->back()->with('success', 'Zostałeś zapisany na kurs.');
    }
}