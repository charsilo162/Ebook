<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Session;

class VendorMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Session::get('user');

        if (!$user) {
            return redirect()->route('login');
        }

        // Your old logic — now works perfectly
        if ($user['type'] != 'vendor') {
            return redirect()->route('home');
        }
// dd($request);
        return $next($request);
    }
}
