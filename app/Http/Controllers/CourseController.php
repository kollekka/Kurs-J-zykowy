<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course; 

class CourseController extends Controller
{
    public function show($id)
    {
        // Pobierz kurs na podstawie ID
        $course = Course::findOrFail($id);

        // Przekaż dane do widoku
        return view('course', compact('course'));
    }
}
