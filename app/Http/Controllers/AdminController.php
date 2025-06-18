<?php
namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\Course;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\Opinion;
use App\Models\Payment;
use Illuminate\Http\Request; 
use Carbon\Carbon; 

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
    public function statistics(Request $request)
    {
       
        $defaultStartDate = Carbon::now()->subMonths(3)->startOfDay();
        $defaultEndDate = Carbon::now()->endOfDay();

        $startDate = $request->input('start_date')
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : $defaultStartDate;
        $endDate = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : $defaultEndDate;

     
        if ($startDate->gt($endDate)) {
            $startDate = $defaultStartDate;
            $endDate = $defaultEndDate;
        }

     
        $usersInPeriod = User::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc') 
            ->get();

    
        $userRegistrationsDaily = $usersInPeriod
            ->groupBy(function ($user) {
                return $user->created_at->format('Y-m-d'); 
            })
            ->map(function ($dailyUsersCollection, $dateKey) {
                return [
                    'day' => $dateKey, 
                    'total' => $dailyUsersCollection->count(), 
                ];
            })->sortBy('day')->values(); 


        $instructorCourseCounts = Instructor::select('instructors.id', 'instructors.full_name')
            ->withCount('courses as courses_count') 
            ->orderByDesc('courses_count')
            ->take(5)
            ->get();

        $topRatedCourses = Course::select('courses.id', 'courses.name', 'courses.language')
            ->withAvg('opinions', 'rating') 
            ->orderByDesc('opinions_avg_rating')
            ->take(5)
            ->get();


        $mostEnrolledCourses = Course::withCount(['enrollments as enrollments_count' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('enrollments.enrollment_date', [$startDate, $endDate]);
            }])
            ->whereHas('enrollments', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('enrollments.enrollment_date', [$startDate, $endDate]);
            })
            ->orderBy('enrollments_count', 'desc')
            ->take(5)
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'userRegistrationsDaily' => $userRegistrationsDaily,
                'instructorCourseCounts' => $instructorCourseCounts,
                'topRatedCourses' => $topRatedCourses,
                'mostEnrolledCourses' => $mostEnrolledCourses,
                'startDate' => $startDate->toDateString(), 
                'endDate' => $endDate->toDateString(),
            ]);
        }

        $activeCoursesCount = Course::where('end_date', '>=', now()->toDateString())->count();
        $overallAverageCourseRating = Opinion::avg('rating');
        $stats = [
            'totalUsers' => User::count(), 
            'totalCourses' => Course::count(), 
            'totalInstructors' => Instructor::count(), 
            'activeCoursesCount' => $activeCoursesCount,
            'averageCourseRating' => $overallAverageCourseRating ? number_format($overallAverageCourseRating, 2) : 'Brak ocen',
        ];

        return view('admin.statistics.index', compact(
            'stats',
            'instructorCourseCounts',
            'userRegistrationsDaily',
            'mostEnrolledCourses',
            'topRatedCourses',
            'startDate', 
        ));
    }
}