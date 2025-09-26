<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckUserRole::class,
            'redirect.authenticated' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'redirect.dashboard' => \App\Http\Middleware\RedirectToDashboard::class,
            'track.ip' => \App\Http\Middleware\TrackUserIp::class,
            'check.status' => \App\Http\Middleware\CheckUserStatus::class,
        ]);
        // Globally add form submission logger to web middleware group
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\LogFormSubmission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
