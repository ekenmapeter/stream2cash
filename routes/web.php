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
    Route::get('/tasks/{task}', [UserController::class, 'taskDetails'])->name('tasks.details');
    Route::get('/tasks/{task}/watch', [UserController::class, 'watchTask'])->name('tasks.watch');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/avatar/{user}', [UserController::class, 'avatar'])->name('avatar');
    Route::get('/withdrawal', [UserController::class, 'withdrawal'])->name('withdrawal');
    Route::post('/withdrawal', [UserController::class, 'requestWithdrawal'])->name('withdrawal.request');
});

// Video completion API routes
Route::post('/api/video-complete', [UserController::class, 'completeVideo'])->middleware(['auth', 'verified', 'role:user', 'check.status']);
Route::post('/api/video-heartbeat', [UserController::class, 'videoHeartbeat'])->middleware(['auth', 'verified', 'role:user', 'check.status']);

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
    Route::get('/tasks/{task}/watchers', [AdminController::class, 'taskWatchers'])->name('tasks.watchers');
    Route::get('/watches/{watch}', [AdminController::class, 'watchDetails'])->name('watches.show');
    Route::post('/watches/{watch}/credit', [AdminController::class, 'creditWatch'])->name('watches.credit');
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

    // Settings Routes - moved to separate group below

    // Reports Routes
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/export', [AdminController::class, 'exportReport'])->name('reports.export');

    // Cheaters Routes
    Route::get('/cheaters', [AdminController::class, 'cheaters'])->name('cheaters');

    // Suspension Management Routes
    Route::get('/suspensions', [AdminController::class, 'suspensions'])->name('suspensions');
    Route::get('/suspensions/{suspension}', [AdminController::class, 'showSuspension'])->name('suspensions.show');
    Route::patch('/suspensions/{suspension}/approve', [AdminController::class, 'approveSuspension'])->name('suspensions.approve');
    Route::patch('/suspensions/{suspension}/reject', [AdminController::class, 'rejectSuspension'])->name('suspensions.reject');
    Route::patch('/suspensions/{suspension}/credit-wallet', [AdminController::class, 'creditWallet'])->name('suspensions.credit-wallet');
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

// Admin settings routes
Route::middleware(['auth', 'verified', 'role:admin', 'check.status'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/reset', [App\Http\Controllers\Admin\SettingsController::class, 'reset'])->name('settings.reset');
    Route::get('/settings/group/{group}', [App\Http\Controllers\Admin\SettingsController::class, 'getByGroup'])->name('settings.group');
    Route::post('/settings/single', [App\Http\Controllers\Admin\SettingsController::class, 'updateSingle'])->name('settings.single');
    Route::patch('/settings/autopilot', [App\Http\Controllers\Admin\AdminController::class, 'toggleAutopilot'])->name('settings.autopilot');
});
