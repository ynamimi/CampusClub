<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Check if the guard is for the president
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard('president')->check()) {
                // Explicitly redirect authenticated president to dashboard
                logger()->info('Redirecting authenticated president to dashboard');
                return redirect()->route('president.dashboard');
            }

            if (Auth::guard('web')->check()) {
                // Redirect authenticated student to their dashboard
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
