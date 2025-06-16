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
use App\Models\Course;


class UserController extends Controller
{
    public function profile(Request $request)
    {
        $user = Auth::user();

    
        $filter = $request->input('filter', 'upcoming');
        $languages = Course::distinct()->pluck('language')->toArray();

        $search = $request->input('search');
        $language = $request->input('language');
        $sort = $request->input('sort', 'start_date'); 
        $order = $request->input('order', 'asc'); 

        
        $query = $user->courses();

        if ($filter === 'upcoming') {
            $query->where('start_date', '>', now());
        } elseif ($filter === 'past') {
            $query->where('end_date', '<', now());
        }

       
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

       
        if ($language) {
            $query->where('language', $language);
        }

       
        if ($sort === 'rating_asc') {
        $query->withAvg('opinions', 'rating')->orderBy('opinions_avg_rating', 'asc');
        } elseif ($sort === 'rating_desc') {
            $query->withAvg('opinions', 'rating')->orderBy('opinions_avg_rating', 'desc');
        } elseif ($sort === 'start_date_desc') {
            $query->orderBy('start_date', 'desc');
        } else {
            $query->orderBy('start_date', 'asc'); 
        }

        $courses = $query->get();

        return view('user', compact('user', 'courses', 'filter', 'search', 'language', 'sort', 'order','languages'));
    }

    public function update(UpdateUserProfileRequest $request)
    {
        $user = Auth::user(); 

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->filled('password') ? bcrypt($request->input('password')) : $user->password,
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->update(['profile_image' => $path]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function index()
    {
        $users = User::paginate(10);
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