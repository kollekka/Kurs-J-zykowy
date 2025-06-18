<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course; 
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    public function index()
    {
        $courses = Course::all()->sortByDesc('start_date')->take(9);

        $languageCounts = Course::select('language', DB::raw('count(*) as total'))
                            ->groupBy('language')->orderBy('total', 'desc')
                            ->pluck('total', 'language')->take(7);

        return view('main', compact('courses','languageCounts'));
    }
}
