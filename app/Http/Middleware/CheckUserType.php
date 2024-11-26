<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->usertype == 'admin') {
            return redirect()->route('adminpage.dashboard');
        } elseif ($user && $user->usertype == 'user') {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
