<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use App\Http\Requests\StoreEnrollmentByAdminRequest; 
use App\Http\Requests\UpdateEnrollmentRequest; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;


class EnrollmentController extends Controller
{
    
    public function index(Request $request)
    {
        if (Auth::user()->is_admin) {
            $enrollments = Enrollment::with(['user', 'course'])->latest()->paginate(15);
            return view('admin.enrollments.index', compact('enrollments'));
        } else {
            $enrollments = Auth::user()->enrollments()->with('course')->latest()->paginate(10);
            return view('user', compact('enrollments')); 
        }
    }

  
    public function create()
    {
        
        $users = User::orderBy('name')->get();
        $courses = Course::orderBy('name')->get();
        return view('admin.enrollments.create', compact('users', 'courses'));
    }

  
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
        return view('admin.enrollments.index', compact('enrollment')); 
    }

    public function edit(Enrollment $enrollment)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('main')->with('error', 'Nie masz uprawnień do tej akcji.');
        }
        $enrollment->load(['user', 'course']); 
        $users = User::orderBy('name')->get();
        $courses = Course::orderBy('name')->get();
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

    public function destroyByUser(Course $course)
    {
        $user = Auth::user();
        $enrollment = Enrollment::where('user_id', $user->id)
                                ->where('course_id', $course->id)
                                ->first();

        if ($enrollment) {
            if (now() < $course->end_date) {
                $enrollment->delete();
                return redirect()->route('user.profile')->with('success', 'Pomyślnie zrezygnowano z kursu.');
            } else {
                return redirect()->route('user.profile')->with('error', 'Nie można zrezygnować z kursu, który już się zakończył.');
            }
        }

        return redirect()->route('user.profile')->with('error', 'Nie znaleziono zapisu na ten kurs lub wystąpił błąd.');
    }

    public function enrollUser(Course $course)
    {
        return view('enroll', ['course' => $course]);
    }

    public function storeUserEnrollment(Request $request)
    {
         $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'payment_method' => 'required|string|in:card,bank_transfer,paypal', 
        ]);

        $course = Course::findOrFail($validated['course_id']);
        $user = Auth::user();

        $discount = 1.0;
        if ($user->created_at->gt(Carbon::now()->subWeek())) {
            $discount = 0.2;
        }

        $finalAmount = round(($course->price ?? 0) * $discount, 2);

        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'payment_method' => $validated['payment_method'],
            'enrollment_date' => now(), 
            'status' => 'enrolled', 
        ]);

        Payment::create([
            'enrollment_id' => $enrollment->id,
            'amount' => $finalAmount,
            'payment_method' => $validated['payment_method'],
            'status' => 'paid',
        ]);

        return redirect()->route('user.profile')->with('success', 'Zapis został pomyślnie utworzony.');
    }
}