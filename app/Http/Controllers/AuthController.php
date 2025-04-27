<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Wyświetlanie formularza logowania
    public function showLoginForm()
    {
        return view('login');
    }

    // Obsługa logowania
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/main')->with('success', 'Zalogowano pomyślnie!');
        }

        return back()->withErrors([
            'email' => 'Podane dane są nieprawidłowe.',
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