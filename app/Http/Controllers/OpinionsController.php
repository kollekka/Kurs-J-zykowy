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
    
    public function index()
    {
        $opinions = Opinion::with(['user', 'course'])->latest()->paginate(15);
        return view('admin.opinions.index', compact('opinions')); 
    }

    
    public function store(StoreOpinionRequest $request, Course $course)
    {
        $validatedData = $request->validated(); 
       

        Opinion::create([
            'opinion' => $validatedData['opinion'],
            'rating' => $validatedData['rating'],   
            'course_id' => $course->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('course.show', $course->id)->with('success', 'Opinion created successfully.');
    }

   
    public function edit(Opinion $opinion)
    {
        if (Auth::id() !== $opinion->user_id && !Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'You do not have permission to edit this opinion.');
        }

        return view('admin.opinions.edit', compact('opinion')); 
    }

    
    public function update(UpdateOpinionRequest $request, Opinion $opinion)
    {
        
        $opinion->update([
            'opinion' => $request->opinion, 
            'rating' => $request->rating,
        ]);

        
        if (Auth::user()->is_admin && $request->headers->get('referer') && str_contains($request->headers->get('referer'), 'admin/opinions')) {
            return redirect()->route('admin.opinions.index')->with('success', 'Opinia została zaktualizowana.');
        }
        return redirect()->route('course.show', $opinion->course_id)->with('success', 'Opinion updated successfully.');
    }

    
    public function destroy(Opinion $opinion, Request $request) 
    {
       
        if (Auth::id() !== $opinion->user_id && !Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'You do not have permission to delete this opinion.');
        }

        $courseId = $opinion->course_id; 
        $opinion->delete();

        
        if (Auth::user()->is_admin && $request->headers->get('referer') && str_contains($request->headers->get('referer'), 'admin/opinions')) {
            return redirect()->route('admin.opinions.index')->with('success', 'Opinion deleted successfully.');
        }
        return redirect()->route('course.show', $courseId)->with('success', 'Opinion deleted successfully.');
    }

     public function createForAdmin()
    {
        
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('main')->with('error', 'You do not have permission to access this page.');
        }
        $users = User::orderBy('name')->get();
        $courses = Course::orderBy('name')->get();
        return view('admin.opinions.create', compact('users', 'courses'));
    }

    public function storeForAdmin(StoreAdminOpinionRequest $request)
    {
        Opinion::create([
            'opinion' => $request->validated()['opinion'],
            'rating' => $request->validated()['rating'],
            'course_id' => $request->validated()['course_id'],
            'user_id' => $request->validated()['user_id'],
        ]);

        return redirect()->route('admin.opinions.index')->with('success', 'Opinion added successfully.');
    }
}
