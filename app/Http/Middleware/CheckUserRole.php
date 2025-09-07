<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $user = Auth::user();

        // If no specific role is required, just check if user is logged in
        if ($role === null) {
            return $next($request);
        }

        // Check user role
        $userRole = $user->role ?? 'user'; // Default to 'user' if no role is set

        // Define role hierarchy and redirects
        $roleRedirects = [
            'admin' => 'admin.dashboard',
            'user' => 'user.dashboard',
            'moderator' => 'moderator.dashboard',
        ];

        // Check if user has the required role or higher
        if ($this->hasRole($userRole, $role)) {
            return $next($request);
        }

        // Redirect to appropriate dashboard based on user role
        $redirectRoute = $roleRedirects[$userRole] ?? 'user.dashboard';

        return redirect()->route($redirectRoute)
            ->with('error', 'You do not have permission to access this page.');
    }

    /**
     * Check if user has the required role or higher
     *
     * @param string $userRole
     * @param string $requiredRole
     * @return bool
     */
    private function hasRole($userRole, $requiredRole)
    {
        // Define role hierarchy (higher number = higher privilege)
        $roleHierarchy = [
            'user' => 1,
            'moderator' => 2,
            'admin' => 3,
        ];

        $userLevel = $roleHierarchy[$userRole] ?? 1;
        $requiredLevel = $roleHierarchy[$requiredRole] ?? 1;

        return $userLevel >= $requiredLevel;
    }
}
