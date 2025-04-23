<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Course;

class AdminController extends Controller
{
    public function index()
    {
        $instructors = Instructor::all();
        $courses = Course::all();
        return view('admin.dashboard', compact('instructors'), compact('courses'));
        
    }

    public function addInstructor(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:instructors',
            'bio' => 'required|string|max:1000',
        ]);

        Instructor::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'bio' => $request->bio,
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function addCourse(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date', 
            'price' => 'required|numeric|min:0',
            'instructor_id' => 'required|exists:instructors,id',
        ]);
    
        Course::create([
            'name' => $request->name,
            'language' => $request->language,
            'level' => $request->level,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'price' => $request->price,
            'instructor_id' => $request->instructor_id,
        ]);
        return redirect()->route('admin.dashboard');
    }

        public function deleteInstructor($id)
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Instruktor został usunięty.');
    }

    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Kurs został usunięty.');
    }   
}