<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// 👇 Fallback dashboard route (required for Breeze)
Route::get('/dashboard', function () {
    return Auth::user()->role === 'admin' 
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 👇 Shared authenticated routes
Route::middleware('auth')->group(function () {
    // Profile routes (accessible to all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // 👇 User-specific routes
    Route::middleware(['role:user'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
        Route::resource('events', EventController::class)->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);
    });

    // 👇 Admin-specific routes
    Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class.':admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::prefix('admin')->group(function () {
            Route::resource('events', EventController::class)->except(['create', 'store']);
        });
    });
});

// 👇 Authentication routes
require __DIR__.'/auth.php';
