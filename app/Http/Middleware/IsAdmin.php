<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() && Auth::user()->roles == 'ADMIN') {

            return $next($request);
        } elseif (Auth::user() && Auth::user()->roles == 'PETUGAS') {

            return $next($request);
        }

        return redirect('user');
    }
}
