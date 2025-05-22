<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Opinion;
use App\Http\Requests\StoreOpinionRequest;
use App\Http\Requests\UpdateOpinionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 
use App\Http\Requests\StoreAdminOpinionRequest; 
use App\Models\User;

class OpinionsController extends Controller
{
    /**
     * Display a listing of the opinions (for admin).
     */
    public function index()
    {
        $opinions = Opinion::with(['user', 'course'])->latest()->paginate(15);
        return view('admin.opinions.index', compact('opinions')); 
    }

    /**
     * Store a newly created opinion in storage.
     * The $course parameter comes from route model binding.
     */
    public function store(StoreOpinionRequest $request, Course $course)
    {
        // The StoreOpinionRequest handles authorization and validation.
        Opinion::create([
            'comment' => $request->comment, // Assuming 'comment' is the correct field name
            'rating' => $request->rating,
            'course_id' => $course->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('course.show', $course->id)->with('success', 'Twoja opinia została dodana!');
    }

    /**
     * Show the form for editing the specified opinion.
     * The $opinion parameter comes from route model binding.
     */
    public function edit(Opinion $opinion)
    {
        if (Auth::id() !== $opinion->user_id && !Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Nie masz uprawnień do edycji tej opinii.');
        }

        return view('admin.opinions.edit', compact('opinion')); // Ensure this view exists e.g., resources/views/opinions/edit.blade.php
    }

    
    public function update(UpdateOpinionRequest $request, Opinion $opinion)
    {
        
        $opinion->update([
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        
        if (Auth::user()->is_admin && $request->headers->get('referer') && str_contains($request->headers->get('referer'), 'admin/opinions')) {
            return redirect()->route('admin.opinions.index')->with('success', 'Opinia została zaktualizowana.');
        }
        return redirect()->route('course.show', $opinion->course_id)->with('success', 'Twoja opinia została zaktualizowana.');
    }

    /**
     * Remove the specified opinion from storage.
     * The $opinion parameter comes from route model binding.
     */
    public function destroy(Opinion $opinion, Request $request) 
    {
       
        if (Auth::id() !== $opinion->user_id && !Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Nie masz uprawnień do usunięcia tej opinii.');
        }

        $courseId = $opinion->course_id; 
        $opinion->delete();

        
        if (Auth::user()->is_admin && $request->headers->get('referer') && str_contains($request->headers->get('referer'), 'admin/opinions')) {
            return redirect()->route('admin.opinions.index')->with('success', 'Opinia została usunięta.');
        }
        return redirect()->route('course.show', $courseId)->with('success', 'Twoja opinia została usunięta.');
    }

     public function createForAdmin()
    {
        // Autoryzacja może być również w FormRequest lub middleware
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('main')->with('error', 'Nie masz uprawnień do tej akcji.');
        }
        $users = User::orderBy('name')->get();
        $courses = Course::orderBy('name')->get();
        return view('admin.opinions.create', compact('users', 'courses'));
    }

    public function storeForAdmin(StoreAdminOpinionRequest $request)
    {
        // Walidacja i autoryzacja są obsługiwane przez StoreAdminOpinionRequest
        Opinion::create([
            'opinion' => $request->validated()['opinion'],
            'rating' => $request->validated()['rating'],
            'course_id' => $request->validated()['course_id'],
            'user_id' => $request->validated()['user_id'],
        ]);

        return redirect()->route('admin.opinions.index')->with('success', 'Opinia została pomyślnie dodana przez administratora.');
    }
}
