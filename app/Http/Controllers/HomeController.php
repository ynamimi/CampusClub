<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Method to handle redirection after login
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'student') {
            return redirect()->route('student.home'); // Redirect to student home page
        } elseif ($user->role == 'president') {
            return redirect()->route('president.dashboard', ['id' => $user->id]); // Pass the president's ID to the route
        }

        // Default redirection if no role is set
        return redirect()->route('student.home');
    }
}
