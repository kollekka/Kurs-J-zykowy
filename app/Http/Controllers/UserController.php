<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $courses = $user ? $user->courses : "Brak dostępnych kursów"; 

        return view('user', compact('user', 'courses'));
    }
}
