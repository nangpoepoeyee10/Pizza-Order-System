<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->role == 'admin'){
            return route('category#list');
        }else{
            return route('user#home');
        }
        return $next($request);
    }
}
