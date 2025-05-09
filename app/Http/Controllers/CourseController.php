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

        $currentDate = now();
        $course = Course::with('lessons')->withCount('enrollments')->findOrFail($id);
        $opinions =  Opinion::where('course_id', $id)->with('user')->get();
        $rating = $opinions->avg('rating');

        
        return view('course', compact('course','opinions','rating','currentDate'));
        
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
    
        // Paginacja
        $courses = $query->paginate(6)->appends($request->query());
        $languages = Course::Select('language')->distinct()->pluck('language');
    
        return view('courses', compact('courses','languages'));
    
    }

    public function enroll(Request $request, $courseId)
    {
        $user = auth()->user();
        $userCourses = $user->courses()->end_date;
        $courseDate = Course::findOrFail($courseId)->start_date;

        foreach ($userCourses as $userCourse) {
            if ($userCourse >= $courseDate) {
                return redirect()->back()->with('error', 'Już jesteś zapisany na ten kurs.');
            }
        }
        return redirect()->back()->with('success', 'Zostałeś zapisany na kurs.');
    }
}