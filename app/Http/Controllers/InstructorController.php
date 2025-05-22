<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Http\Requests\StoreInstructorRequest;
use App\Http\Requests\UpdateInstructorRequest;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructors = Instructor::all();
        return view('admin.instructors.index', compact('instructors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.instructors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstructorRequest $request)
    {
        Instructor::create($request->validated());

        return redirect()->route('admin.instructors.index')->with('success', 'Instruktor został pomyślnie dodany.');
    }

    public function show(Instructor $instructor)
    {
        return view('admin.instructors.show', compact('instructor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instructor $instructor)
    {
        return view('admin.instructors.edit', compact('instructor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstructorRequest $request, Instructor $instructor)
    {
        $instructor->update($request->validated());

        return redirect()->route('admin.instructors.index')->with('success', 'Dane instruktora zostały zaktualizowane.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructor)
    {
        // Można dodać logikę sprawdzającą, czy instruktor nie jest powiązany z aktywnymi kursami
        // if ($instructor->courses()->exists()) {
        //     return redirect()->route('admin.instructors.index')->with('error', 'Nie można usunąć instruktora przypisanego do kursów.');
        // }

        $instructor->delete();

        return redirect()->route('admin.instructors.index')->with('success', 'Instruktor został usunięty.');
    }
}
