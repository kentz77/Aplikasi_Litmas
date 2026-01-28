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

// Root → arahkan ke login (bukan langsung view)
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard (wajib login)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Menambahkan Litmas
Route::get('/litmas/create', [LitmasController::class, 'create'])
    ->name('litmas.create');

Route::post('/litmas', [LitmasController::class, 'store'])
    ->name('litmas.store');

Route::get('/litmas', [LitmasController::class, 'index'])
    ->name('litmas.index');

// Profile routes (Breeze default)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Admin & Super User
Route::middleware(['auth', 'role:admin,superuser'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');
});

// Super User saja
Route::middleware(['auth', 'role:superuser'])->group(function () {
    Route::get('/manajemen-user', [UserController::class, 'index']);
});

// User biasa
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/litmas-saya', [LitmasController::class, 'myLitmas']);
});

// ========================
// PROFILE (SEMUA ROLE LOGIN)
// ========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// Auth routes (login, logout, register, dll)
require __DIR__.'/auth.php';
