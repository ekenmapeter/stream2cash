<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GeneralController::class, 'index'])->name('home');
Route::get('/about', [GeneralController::class, 'about'])->name('about');
Route::get('/how-it-works', [GeneralController::class, 'howItWorks'])->name('how-it-works');
Route::get('/testimonies', [GeneralController::class, 'testimonies'])->name('testimonies');
Route::get('/contact', [GeneralController::class, 'contact'])->name('contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
