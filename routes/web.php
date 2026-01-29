<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LitmasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Root
Route::get('/', function () {
    return redirect()->route('login');
});

// ========================
// SEMUA USER LOGIN
// ========================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Litmas
    Route::get('/litmas', [LitmasController::class, 'index'])
        ->name('litmas.index');

    Route::get('/litmas/create', [LitmasController::class, 'create'])
        ->name('litmas.create');

    Route::post('/litmas', [LitmasController::class, 'store'])
        ->name('litmas.store');
});

// ========================
// USER BIASA
// ========================
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/litmas-saya', [LitmasController::class, 'myLitmas'])
        ->name('litmas.my');
});

// ========================
// HANYA ADMIN
// ========================
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/manajemen-user', [UserController::class, 'index'])
        ->name('users.index');

    Route::get('/manajemen-user/create', [UserController::class, 'create'])
        ->name('users.create');

    Route::post('/manajemen-user', [UserController::class, 'store'])
        ->name('users.store');

    Route::get('/manajemen-user/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit');

    Route::put('/manajemen-user/{user}', [UserController::class, 'update'])
        ->name('users.update');

    Route::delete('/manajemen-user/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy');

    Route::post('/manajemen-user/{user}/reset-password', [UserController::class, 'resetPassword'])
        ->name('users.reset-password');
});


// Auth routes
require __DIR__.'/auth.php';
