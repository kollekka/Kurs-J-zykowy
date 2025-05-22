<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use App\Http\Requests\StoreEnrollmentByAdminRequest; // Zmieniamy na nowy Form Request
use App\Http\Requests\UpdateEnrollmentRequest; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource (for admin or user's own enrollments).
     */
    public function index(Request $request)
    {
        if (Auth::user()->is_admin) {
            $enrollments = Enrollment::with(['user', 'course'])->latest()->paginate(15);
            return view('admin.enrollments.index', compact('enrollments'));
        } else {
            $enrollments = Auth::user()->enrollments()->with('course')->latest()->paginate(10);
            return view('user.enrollments.index', compact('enrollments')); // np. user/enrollments/index.blade.php
        }
    }

    /**
     * Show the form for creating a new resource (admin).
     */
    public function create()
    {
        
        $users = User::orderBy('name')->get();
        $courses = Course::orderBy('name')->get();
        return view('admin.enrollments.create', compact('users', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnrollmentByAdminRequest $request)
    {
       
        Enrollment::create([
            'user_id' => $request->user_id, 
            'course_id' => $request->course_id, 
            'enrollment_date' => $request->enrollment_date,
            'status' => $request->status, 
        ]);

        return redirect()->route('admin.enrollments.index')->with('success', 'Zapis został pomyślnie utworzony.');
    }

    public function show(Enrollment $enrollment)
    {
        if (Auth::id() !== $enrollment->user_id && !Auth::user()->is_admin) {
            return redirect()->route('main')->with('error', 'Nie masz dostępu do tych informacji.');
        }
        $enrollment->load(['user', 'course']);
        return view('admin.enrollments.show', compact('enrollment')); 
    }

    public function edit(Enrollment $enrollment)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('main')->with('error', 'Nie masz uprawnień do tej akcji.');
        }
        $enrollment->load(['user', 'course']); 
        $users = User::orderBy('name')->all();
        $courses = Course::orderBy('name')->all();
        return view('admin.enrollments.edit', compact('enrollment', 'users', 'courses'));
    }

    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment)
    {
        $enrollment->update($request->validated());
        return redirect()->route('admin.enrollments.index')->with('success', 'Status zapisu został zaktualizowany.');
    }

    public function destroy(Enrollment $enrollment)
    {
        if (Auth::id() !== $enrollment->user_id && !Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Nie masz uprawnień do anulowania tego zapisu.');
        }

        $enrollment->delete(); 

        if (Auth::user()->is_admin) {
            return redirect()->route('admin.enrollments.index')->with('success', 'Zapis został usunięty/anulowany.');
        }
        return redirect()->route('user.profile')->with('success', 'Twój zapis na kurs został anulowany.');
    }
}
