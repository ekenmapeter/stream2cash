<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if user is suspended
            if ($user->isSuspended()) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account has been suspended. Reason: ' . ($user->suspension_reason ?? 'No reason provided.'));
            }

            // Check if user is blocked
            if ($user->isBlocked()) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account has been blocked. Reason: ' . ($user->block_reason ?? 'No reason provided.'));
            }
        }

        return $next($request);
    }
}
