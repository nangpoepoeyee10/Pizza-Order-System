<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    public function handle(Request $request, \Closure $next): Response
    {
        if (!empty(Auth::user())) {
            if (url()->current() == route('auth#loginPage') || url()->current() == route('auth#registerPage')) {
                return back();
            }
            // only accept admin
            if (Auth::user()->role == 'user') {
                abort(404);
            }

            return $next($request);
        }

        return $next($request);
    }
}
