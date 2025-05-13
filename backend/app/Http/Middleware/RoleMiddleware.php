<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request); // Lanjutkan jika role sesuai
        }

        // Jika role tidak sesuai, arahkan ke halaman login atau halaman error
        return redirect()->route('login')->withErrors(['error' => 'You do not have permission to access this page.']);
    }
}
