<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Fallback dashboard route (required for Breeze)
Route::get('/dashboard', function () {
    return Auth::user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Shared authenticated routes
Route::middleware(['auth'])->group(function () {
    // Profile routes (accessible to all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User-specific routes
    Route::middleware([RoleMiddleware::class.':user'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
        Route::resource('events', EventController::class)->except(['show']);
    });

    // Admin-specific routes
    Route::middleware([RoleMiddleware::class.':admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        
        // Admin Event Management
        Route::prefix('admin/events')->group(function () {
            Route::get('/', [EventController::class, 'index'])->name('admin.events.index');
            Route::get('/{event}', [EventController::class, 'show'])->name('admin.events.show');
            Route::get('/{event}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
            Route::put('/{event}', [EventController::class, 'update'])->name('admin.events.update');
            Route::delete('/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');
        });
        
        // Admin User Management
        Route::prefix('admin/users')->name('admin.users.')->group(function () {
            Route::get('/', [AdminController::class, 'listUsers'])->name('index');
            Route::get('/{user}/edit', [AdminController::class, 'editUser'])->name('edit');
            Route::put('/{user}', [AdminController::class, 'updateUser'])->name('update');
        });
    });
});

require __DIR__.'/auth.php';
