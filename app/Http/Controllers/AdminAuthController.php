<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Show Admin Login Form
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Handle Login
    public function login(Request $request)
    {
        // Validate Inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Check credentials using ADMIN guard
        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->remember)) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()
            ->withErrors(['email' => 'Invalid credentials'])
            ->withInput($request->only('email', 'remember'));
    }

    // Logout Admin
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
