<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes - redirect authenticated users to dashboard
Route::middleware(['redirect.authenticated'])->group(function () {
    Route::get('/', [GeneralController::class, 'index'])->name('home');
    Route::get('/about', [GeneralController::class, 'about'])->name('about');
    Route::get('/how-it-works', [GeneralController::class, 'howItWorks'])->name('how-it-works');
    Route::get('/testimonies', [GeneralController::class, 'testimonies'])->name('testimonies');
    Route::get('/contact', [GeneralController::class, 'contact'])->name('contact');
});

// User Dashboard Routes - requires user role or higher
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/wallet', [UserController::class, 'wallet'])->name('wallet');
    Route::get('/tasks', [UserController::class, 'tasks'])->name('tasks');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/withdrawal', [UserController::class, 'withdrawal'])->name('withdrawal');
});

// Admin Dashboard Routes - requires admin role
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

// Redirect old dashboard route to appropriate dashboard based on role
Route::get('/dashboard', function () {
    $user = Auth::user();
    $userRole = $user->role ?? 'user';

    switch ($userRole) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'user':
        default:
            return redirect()->route('user.dashboard');
    }
})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
