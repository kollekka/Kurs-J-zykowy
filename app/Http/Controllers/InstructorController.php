<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Http\Requests\StoreInstructorRequest;
use App\Http\Requests\UpdateInstructorRequest;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
   
    public function index()
    {
        $instructors = Instructor::paginate(10);
        return view('admin.instructors.index', compact('instructors'));
    }

   
    public function create()
    {
        return view('admin.instructors.create');
    }

    public function store(StoreInstructorRequest $request)
    {
        Instructor::create($request->validated());

        return redirect()->route('admin.instructors.index')->with('success', 'Instruktor został pomyślnie dodany.');
    }

    public function show(Instructor $instructor)
    {
        return view('admin.instructors.index', compact('instructor'));
    }

   
    public function edit(Instructor $instructor)
    {
        return view('admin.instructors.edit', compact('instructor'));
    }

   
    public function update(UpdateInstructorRequest $request, Instructor $instructor)
    {
        $instructor->update($request->validated());

        return redirect()->route('admin.instructors.index')->with('success', 'Dane instruktora zostały zaktualizowane.');
    }

 
    public function destroy(Instructor $instructor)
    {

        $instructor->delete();

        return redirect()->route('admin.instructors.index')->with('success', 'Instruktor został usunięty.');
    }
}
