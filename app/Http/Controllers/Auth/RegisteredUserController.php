<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Mail\WelcomeUserMail;
use App\Mail\NewUserAdminMail;
use Illuminate\Support\Facades\Mail;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'balance'  => 0.00,          // start with zero balance
            'role'     => 'user',        // default role
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Queue Welcome Mail to User
    Mail::to($user->email)->queue(new WelcomeUserMail($user));

    // Queue Notification Mail to Admin
    Mail::to('admin@example.com')->queue(new NewUserAdminMail($user));

        return redirect()->route('user.dashboard');
    }
}
