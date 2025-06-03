<?php
namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\Course;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\Opinion;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

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
     * Wyświetla dedykowaną stronę ze statystykami.
     *
     * @return \Illuminate\View\View
     */
    public function statistics()
    {

        // 2. Instruktorzy z największą liczbą kursów (do wykresu słupkowego)
        $instructorCourseCounts = Instructor::withCount('courses')
            ->orderBy('courses_count', 'desc')
            ->take(5) // Pokaż top 5
            ->get();

        // 3. Rejestracje użytkowników w ostatnich 6 miesiącach (do wykresu liniowego)
        $userRegistrationsMonthly = User::select(
                DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // 4. Liczba aktywnych kursów (które się jeszcze nie zakończyły)
        $activeCoursesCount = Course::where('end_date', '>=', now()->toDateString())->count();

        // 5. Średnia ocena wszystkich kursów
        $averageCourseRating = Opinion::avg('rating');

        // 6. Najpopularniejsze kursy (top 5 wg liczby zapisów)
        $mostEnrolledCourses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(5)
            ->get();

        // 7. Top 5 kursów wg średniej oceny
        $topRatedCourses = Course::select('courses.id', 'courses.name', 'courses.language', DB::raw('AVG(opinions.rating) as average_rating'))
            ->join('opinions', 'courses.id', '=', 'opinions.course_id')
            ->groupBy('courses.id', 'courses.name', 'courses.language')
            ->orderByDesc('average_rating')
            ->take(5)
            ->get();

        $stats = [
            'totalUsers' => User::count(), // Ogólna liczba użytkowników
            'totalCourses' => Course::count(), // Ogólna liczba kursów
            'totalInstructors' => Instructor::count(), // Ogólna liczba instruktorów
            'activeCoursesCount' => $activeCoursesCount,
            'averageCourseRating' => $averageCourseRating ? number_format($averageCourseRating, 2) : 'Brak ocen',
        ];
        return view('admin.statistics.index', compact('stats', 'instructorCourseCounts', 'userRegistrationsMonthly', 'mostEnrolledCourses', 'topRatedCourses'));
    }
}