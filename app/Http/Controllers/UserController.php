<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Http\Requests\UpdateUserByAdminRequest;


class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $courses = $user->courses;

        return view('user', compact('user', 'courses'));
    }

    public function update(UpdateUserProfileRequest $request)
    {
        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old profile image if it exists
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Store new profile image
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profil został zaktualizowany.');
    }

    public function index()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users')); 
    }

    public function create()
    {
        return view('admin.users.create'); 
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function store(StoreUserRequest $request)
    {
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->filled('is_admin') ? $request->boolean('is_admin') : false,
        ];

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $userData['profile_image'] = $imagePath;
        }

        User::create($userData);

        return redirect()->route('admin.users.index')->with('success', 'Użytkownik został pomyślnie utworzony.');
    }

    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Nie możesz usunąć własnego konta.');
        }

        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Użytkownik został usunięty.');
    }

    public function updateAdmin(UpdateUserByAdminRequest $request, User $user)
    {
        $dataToUpdate = [
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->boolean('is_admin'),
        ];

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $dataToUpdate['profile_image'] = $imagePath;
        }

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $user->update($dataToUpdate);

        return redirect()->route('admin.users.index')->with('success', 'Dane użytkownika zostały pomyślnie zaktualizowane.');
    }

    public function removeProfileImage()
    {
        $user = Auth::user();

        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
            $user->profile_image = null;
            $user->save();
        }

        return redirect()->route('user.profile')->with('success', 'Zdjęcie profilowe zostało usunięte.');
    }
}