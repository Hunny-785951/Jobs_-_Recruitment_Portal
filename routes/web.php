<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsAdmin;

// ==========================================
// 1. AUTHENTICATION ROUTES (Guests Only)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.authenticate');
});

// ==========================================
// 2. ADMIN / RECRUITER ROUTES
// Note: Placed ABOVE public routes so /jobs/create doesn't trigger a 404!
// ==========================================
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
});

// ==========================================
// 3. LOGGED-IN USER ROUTES (Both Candidates & Admins)
// ==========================================
Route::middleware(['auth'])->group(function () {
    // Smart dashboard (Controller handles which view to show based on role)
    Route::get('/dashboard', [JobController::class, 'dashboard'])->name('dashboard');
    
    // Applying for jobs
    Route::get('/jobs/{job}/apply', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('applications.store');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ==========================================
// 4. PUBLIC ROUTES (Visible to everyone)
// Note: Wildcard {job} placed LAST so it doesn't break other routes
// ==========================================
Route::get('/', [JobController::class, 'index'])->name('home');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');