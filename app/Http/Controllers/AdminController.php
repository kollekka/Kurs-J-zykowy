<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Course;
Use App\Models\Lesson;
use Illuminate\Validation\Validator;

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

    public function editInstructor($id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('admin.editInstructor', compact('instructor'));
    }

    public function editCourse($id)
    {
        $course = Course::with('lessons')->findOrFail($id);
        return view('admin.editCourse', compact('course'));
    }

    public function addCourse(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:40',
            'language' => 'required|string|max:20',
            'level' => 'required',
            'start_date' => 'required|date|after:Today',
            'end_date' => 'required|date|after_or_equal:'.\Carbon\Carbon::parse($request->start_date)->addDays(7), 
            'price' => 'required|numeric|min:0|max:1000',
            'group_size'=> 'required|integer|min:1|max:24',
            'instructor_id' => 'required|exists:instructors,id',
        ]);
    
        Course::create([
            'name' => $request->name,
            'language' => $request->language,
            'level' => $request->level,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'price' => $request->price,
            'group_size' => $request->group_size,
            'instructor_id' => $request->instructor_id,
        ]);
        return redirect()->route('admin.dashboard');
    }

    public function deleteInstructor($id)
        {
            $instructor = Instructor::findOrFail($id);
            $instructor->delete();

            return redirect()->route('admin.dashboard');
        }

    public function deleteCourse($id)
        {
            $course = Course::findOrFail($id);
            $course->delete();

            return redirect()->route('admin.dashboard');
        }   

    public function updateInstructor(Request $request, $id)
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->update($request->all());
        return redirect()->route('admin.dashboard');
    }

    public function updateCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->update($request->all());
        return redirect()->route('admin.dashboard');
    }

    public function editLesson($id)
    {
        $lesson = Lesson::findOrFail($id);
        return view('admin.editLesson', compact('lesson'));
    }

    public function updateLesson(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->update($request->all());
        return redirect()->route('admin.editCourse', $lesson->course_id);
    }
}