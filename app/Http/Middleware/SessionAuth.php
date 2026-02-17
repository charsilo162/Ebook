<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class SessionAuth
{
    public function handle($request, Closure $next)
    {
        //dd(Session::all());
        if (!Session::has('user') || !Session::has('api_token')) {
       
            return redirect()->route('login');
        }

        return $next($request);
    }
}