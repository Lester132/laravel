<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Allow only admin users
        if (Auth::check() && Auth::user()->usertype === 'admin') {
            return $next($request);
        }

        // Redirect non-admin users to home
        return redirect()->route('home');
    }
}
