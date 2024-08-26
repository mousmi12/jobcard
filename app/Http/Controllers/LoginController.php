<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view ('login');
    }
    public function dologin(Request $request)
{
    // Validate the request data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt to log the user in
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Authentication passed...
        $user = Auth::user();

        // Store user role in session
        session(['role' => $user->role]);

        return redirect()->intended('dashboard');
    }

    // Authentication failed...
    return redirect()->back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
