<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PreventAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Redirect admin users to the dashboard
        if (Auth::check() && Auth::user()->usertype === 'admin') {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
