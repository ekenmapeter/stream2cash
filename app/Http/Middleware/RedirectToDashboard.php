<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectToDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userRole = $user->role ?? 'user';

            // Redirect to appropriate dashboard based on user role
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
