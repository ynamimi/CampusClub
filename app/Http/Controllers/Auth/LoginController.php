<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\President;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Default redirect path (fallback)
    protected $redirectTo = '/home';

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showPresidentLogin()
    {
        return view('auth.president-login');
    }

    protected function authenticated(Request $request, $user)
    {
        // Check if user is president
        if (Auth::guard('president')->check()) {
            $club = Club::where('president_id', $user->id)->first();
            if ($club) {
                return redirect()->route('president.dashboard', ['club_id' => $club->id]);
            }
            return redirect()->route('president.login')->withErrors(['error' => 'No club associated with this president']);
        }

        // Default student redirection
        return redirect()->route('student.home');
    }

    public function presidentLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate as a club (not president)
        if (Auth::guard('president')->attempt($credentials)) {
            $club = Auth::guard('president')->user();

            // Get the associated president
            $president = $club->president;

            if (!$president) {
                Auth::guard('president')->logout();
                return back()->withErrors(['email' => 'No president associated with this club']);
            }

            return redirect()->route('president.dashboard', ['club_id' => $club->id]);
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return $this->authenticated($request, Auth::guard('web')->user());
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('president')->check()) {
            Auth::guard('president')->logout();
        } else {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
