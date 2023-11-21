<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class UserController extends Controller
{

public function showRegistrationForm()
{
    return view('auth.register');
}

public function register(Request $request)
{
    // Validate the registration form data
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
    ]);

    // Create a new user in the database
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // Log the user in
    Auth::login($user);

    // Redirect to the user's profile
    return redirect('/profile');
}

public function showLoginForm()
{
    return view('auth.login');
}

public function login(Request $request)
{
    // Validate the login form data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt to log the user in
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Authentication passed, redirect to the user's profile
        return redirect('/profile');
    }

    // Authentication failed, redirect back to the login form with an error
    return back()->with('error', 'Invalid credentials');
}

public function logout()
{
    // Log the user out
    Auth::logout();

    // Redirect to the home page or login page
    return redirect('/');
}

public function profile(User $user)
{
    // Display user profile

    return view('profile.index', compact('user'));
}

public function borrowed()
{
    // Display a list of borrowed books and deadlines for the logged-in user
    $user = Auth::user();
    $borrowedBooks = $user->borrowedBooks;

    return view('profile.borrowed', ['borrowedBooks' => $borrowedBooks]);
}
}
