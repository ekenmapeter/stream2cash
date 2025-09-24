<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            $redirectUrl = $user && method_exists($user, 'getAttribute') && $user->getAttribute('role') === 'admin'
                ? route('admin.dashboard', absolute: false)
                : route('user.dashboard', absolute: false);
            return redirect()->intended($redirectUrl);
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
