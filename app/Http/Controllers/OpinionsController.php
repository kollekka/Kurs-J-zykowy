<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Opinion;

class OpinionsController extends Controller
{
    public function store(Request $request, $id)
    {
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:255',
        ]);

        Opinion::create([
            'opinion' => $request->content,
            'rating' => $request->rating,
            'course_id' => $id, 
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Twoja opinia została dodana!');
    }
}
