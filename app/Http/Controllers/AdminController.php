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

    /**
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function statistics()
    {
            $startDate = request('start_date', now()->subMonths(3)->startOfDay()->toDateString());

            $users = User::where('created_at', '>=', $startDate)->get();

            $userRegistrationsDaily = $users->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d');
            })->map(function($group) {
                return [
                    'day' => $group->first()->created_at->format('Y-m-d'),
                    'total' => $group->count()
                ];
            })->sortBy('day')->values();

            if (request()->ajax()) {
                return response()->json(['userRegistrationsDaily' => $userRegistrationsDaily]);
            }

        $instructorCourseCounts = Instructor::withCount('courses')
            ->orderBy('courses_count', 'desc')
            ->take(5) 
            ->get();

        $activeCoursesCount = Course::where('end_date', '>=', now()->toDateString())->count();

        $averageCourseRating = Opinion::avg('rating');

        $mostEnrolledCourses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(5)
            ->get();

        $topRatedCourses = Course::select('courses.id', 'courses.name', 'courses.language')
            ->withAvg('opinions as average_rating', 'rating')
            ->orderByDesc('average_rating')
            ->take(5)
            ->get();

        $stats = [
            'totalUsers' => User::count(), 
            'totalCourses' => Course::count(), 
            'totalInstructors' => Instructor::count(), 
            'activeCoursesCount' => $activeCoursesCount,
            'averageCourseRating' => $averageCourseRating ? number_format($averageCourseRating, 2) : 'Brak ocen',
        ];

        return view('admin.statistics.index', compact(
            'stats',
            'instructorCourseCounts',
            'userRegistrationsDaily',
            'mostEnrolledCourses',
            'topRatedCourses'
        ));
    }
}