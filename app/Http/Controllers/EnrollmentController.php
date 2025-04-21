<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function create($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Musisz być zalogowany, aby się zapisać.');
            }
        $course = Course::findOrFail($id);
        
        return view('enroll', compact('course'));
    }
}
