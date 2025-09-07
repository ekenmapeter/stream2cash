<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();
            $userRole = $user->role ?? 'user';

            // Redirect based on user role
            switch ($userRole) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'user':
                default:
                    return redirect()->route('user.dashboard');
            }
        }

        return $next($request);
    }
}
