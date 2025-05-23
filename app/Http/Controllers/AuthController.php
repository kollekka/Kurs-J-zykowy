<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string|exists:users,name',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/main')->with('success', 'Zalogowano pomyślnie!');
        }

        return back()->withErrors([
            'message' => 'Nieprawidłowe dane logowania.',
        ]);
    } 
    // Obsługa wylogowania
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}