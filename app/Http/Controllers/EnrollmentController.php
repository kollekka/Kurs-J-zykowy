<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

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

    public function store(Request $request)
{
    // Walidacja danych
    $request->validate([
        'course_id' => 'required|exists:courses,id',
        'payment_method' => 'required|in:card,bank_transfer,paypal',
    ]);

    // Zapisz zapis w tabeli enrollments
    \DB::table('enrollments')->insert([
        'user_id' => auth()->id(),
        'course_id' => $request->course_id,
        'enrollment_date' => now(),
        'status' => 'pending',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('main')->with('success', 'You have successfully enrolled in the course!');
    }
}
