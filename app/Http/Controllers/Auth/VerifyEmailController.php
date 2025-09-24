<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeUserMail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();
        $redirectUrl = $user && method_exists($user, 'getAttribute') && $user->getAttribute('role') === 'admin'
            ? route('admin.dashboard', absolute: false)
            : route('user.dashboard', absolute: false);

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended($redirectUrl.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
            Mail::to($user->email)->send(new WelcomeUserMail($user));
        }

        return redirect()->intended($redirectUrl.'?verified=1');
    }
}
