<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class UserMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Session::get('user');

        if (!$user) {
            return redirect()->route('login');
        }

        if (($user['type']) !== 'user') {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}