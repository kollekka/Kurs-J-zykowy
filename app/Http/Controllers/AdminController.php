<?php
namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\Course;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\Opinion;
use App\Models\Payment;

class AdminController extends Controller
{
    public function index()
    {
         $stats = [
            'users' => User::count(),
            'courses' => Course::count(),
            'instructors' => Instructor::count(),
            'lessons' => Lesson::count(),
            'enrollments' => Enrollment::count(),
            'opinions' => Opinion::count(),
            'payments' => Payment::count(), 
        ];

        $instructors = Instructor::all();
        $courses = Course::all();

        return view('admin.dashboard', compact(
            'stats',
            'instructors',
            'courses'
        ));
        
    }
}