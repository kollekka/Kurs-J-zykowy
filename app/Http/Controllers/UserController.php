<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;


class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        // Jeśli użytkownik jest zalogowany, $user zawsze będzie obiektem.
        // Jeśli nie ma kursów, $user->courses będzie pustą kolekcją.
        $courses = $user->courses;

        return view('user', compact('user', 'courses'));
    }

    public function update(UpdateUserProfileRequest $request)
    {
        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profil został zaktualizowany.');
    }

    public function index()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users')); // Zakładamy, że istnieje taki widok
    }

    /**
     * Wyświetla formularz do tworzenia nowego użytkownika (dla administratora).
     */
    public function create()
    {
        return view('admin.users.create'); 
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }


    /**
     * Zapisuje nowego użytkownika w bazie danych (dla administratora).
     */
    public function store(StoreUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->filled('is_admin') ? $request->boolean('is_admin') : false,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Użytkownik został pomyślnie utworzony.');
    }
    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Nie możesz usunąć własnego konta.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Użytkownik został usunięty.');
    }
}
