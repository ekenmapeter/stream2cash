<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
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
Route::middleware(['auth', 'verified', 'role:user', 'check.status', 'track.ip'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/wallet', [UserController::class, 'wallet'])->name('wallet');
    Route::get('/tasks', [UserController::class, 'tasks'])->name('tasks');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/withdrawal', [UserController::class, 'withdrawal'])->name('withdrawal');
});

// Admin Dashboard Routes - requires admin role
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management Routes
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::patch('/users/{user}/update-balance', [AdminController::class, 'updateUserBalance'])->name('users.update-balance');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // User Status Management Routes
    Route::post('/users/{user}/suspend', [AdminController::class, 'suspendUser'])->name('users.suspend');
    Route::post('/users/{user}/block', [AdminController::class, 'blockUser'])->name('users.block');
    Route::patch('/users/{user}/activate', [AdminController::class, 'activateUser'])->name('users.activate');

    // User IP Records Routes
    Route::get('/users/{user}/ip-records', [AdminController::class, 'userIpRecords'])->name('users.ip-records');
    Route::patch('/ip-records/{ipRecord}/mark-suspicious', [AdminController::class, 'markIpSuspicious'])->name('ip-records.mark-suspicious');
    Route::patch('/ip-records/{ipRecord}/clear-suspicion', [AdminController::class, 'clearIpSuspicion'])->name('ip-records.clear-suspicion');

    // Impersonation Routes
    Route::post('/impersonate/{user}', [AdminController::class, 'impersonate'])->name('impersonate');
    Route::post('/stop-impersonate', [AdminController::class, 'stopImpersonate'])->name('stop-impersonate');

    // Task Management Routes
    Route::get('/tasks', [AdminController::class, 'tasks'])->name('tasks');
    Route::get('/tasks/create', [AdminController::class, 'createTask'])->name('tasks.create');
    Route::post('/tasks', [AdminController::class, 'storeTask'])->name('tasks.store');
    Route::get('/tasks/{task}', [AdminController::class, 'showTask'])->name('tasks.show');
    Route::patch('/tasks/{task}', [AdminController::class, 'updateTask'])->name('tasks.update');
    Route::delete('/tasks/{task}', [AdminController::class, 'deleteTask'])->name('tasks.delete');
    Route::patch('/tasks/{task}/toggle-status', [AdminController::class, 'toggleTaskStatus'])->name('tasks.toggle-status');

    // Withdrawal Management Routes
    Route::get('/withdrawals', [AdminController::class, 'withdrawals'])->name('withdrawals');
    Route::get('/withdrawals/{withdrawal}', [AdminController::class, 'showWithdrawal'])->name('withdrawals.show');
    Route::patch('/withdrawals/{withdrawal}/approve', [AdminController::class, 'approveWithdrawal'])->name('withdrawals.approve');
    Route::patch('/withdrawals/{withdrawal}/reject', [AdminController::class, 'rejectWithdrawal'])->name('withdrawals.reject');

    // Analytics Routes
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/analytics/users', [AdminController::class, 'userAnalytics'])->name('analytics.users');
    Route::get('/analytics/earnings', [AdminController::class, 'earningAnalytics'])->name('analytics.earnings');
    Route::get('/analytics/withdrawals', [AdminController::class, 'withdrawalAnalytics'])->name('analytics.withdrawals');

    // Settings Routes
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::patch('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    // Reports Routes
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/export', [AdminController::class, 'exportReport'])->name('reports.export');
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

// Admin authentication routes
Route::middleware(['guest'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'createAdmin'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'storeAdmin'])->name('login.store');
});
