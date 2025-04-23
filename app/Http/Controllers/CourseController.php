<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use lessons\Order;

class CourseController extends Controller
{
    public function show($id)
    {
        // Pobierz kurs na podstawie ID
        $course = Course::with('lessons')->findOrFail($id);

        // Przekaż dane do widoku
        return view('course', compact('course'));
        
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
        $courses = $query->paginate(16);
    
        return view('courses', compact('courses'));
    
    }
}