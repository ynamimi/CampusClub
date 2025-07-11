<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PresidentMiddleware
{
    public function handle($request, Closure $next)
    {
        // If trying to access president routes but not authenticated as president
        if ($request->is('president/*') && !Auth::guard('president')->check()) {
            return redirect()->route('president.login');
        }

        return $next($request);
    }
}

