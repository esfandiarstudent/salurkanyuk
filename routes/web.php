<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DonationRequestController;
use App\Http\Controllers\DonationHistoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/', fn() => redirect('/dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Donations
    Route::resource('donations', DonationItemController::class);
    Route::post('/requests/{donationRequest}/approve', [DonationItemController::class, 'approveRequest'])->name('requests.approve');
    Route::post('/requests/{donationRequest}/reject', [DonationItemController::class, 'rejectRequest'])->name('requests.reject');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Donation Requests
    Route::get('/requests', [DonationRequestController::class, 'index'])->name('requests.index');
    Route::post('/requests', [DonationRequestController::class, 'store'])->name('requests.store');
    Route::delete('/requests/{donationRequest}', [DonationRequestController::class, 'destroy'])->name('requests.destroy');

    // History
    Route::get('/history', [DonationHistoryController::class, 'index'])->name('history.index');
    Route::put('/history/{donationHistory}', [DonationHistoryController::class, 'update'])->name('history.update');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
