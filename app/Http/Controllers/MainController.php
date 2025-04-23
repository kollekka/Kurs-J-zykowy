<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course; 

class MainController extends Controller
{

    public function index()
    {
        // Pobierz 9 najpopularniejszych kursów
        $courses = Course::all();

        // Przekaż dane do widoku
        return view('main', compact('courses'));
    }
}
