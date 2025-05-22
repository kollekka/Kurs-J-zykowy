<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Instructor; // Potrzebne do formularzy admina
use App\Models\Opinion;
use App\Http\Requests\StoreCourseRequest; // Dodajemy Form Request
use App\Http\Requests\UpdateCourseRequest; // Dodajemy Form Request


class CourseController extends Controller
{
    /**
     * Display a listing of the resource for public users (filtered).
     * Metoda `index` pozostaje bez zmian dla publicznego listowania kursów.
     * Dodamy osobną metodę `adminIndex` dla panelu administratora.
     */

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

    /**
     * Display a listing of the resource for admin.
     */
    public function adminIndex()
    {
        $courses = Course::with('instructor')->latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource (admin).
     */
    public function create()
    {
        $instructors = Instructor::orderBy('full_name')->pluck('full_name', 'id');
        return view('admin.courses.create', compact('instructors'));
    }

    /**
     * Store a newly created resource in storage (admin).
     */
    public function store(StoreCourseRequest $request)
    {
        Course::create($request->validated());

        return redirect()->route('admin.courses.index')->with('success', 'Kurs został pomyślnie dodany.');
    }

    /**
     * Show the form for editing the specified resource (admin).
     */
    public function edit(Course $course) 
    {
        $instructors = Instructor::orderBy('full_name')->get();
        return view('admin.courses.edit', compact('course', 'instructors'));
    }

    /**
     * Update the specified resource in storage (admin).
     */
    public function update(UpdateCourseRequest $request, Course $course) // Używamy Route Model Binding
    {
        $course->update($request->validated());

        return redirect()->route('admin.courses.index')->with('success', 'Kurs został zaktualizowany.');
    }

    /**
     * Remove the specified resource from storage (admin).
     */
    public function destroy(Course $course) // Używamy Route Model Binding
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Kurs został usunięty.');
    }
}