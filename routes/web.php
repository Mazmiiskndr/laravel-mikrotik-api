<?php

use Illuminate\Support\Facades\Route;
// Import Controllers for routes
use App\Http\Controllers\{
    Home\LoginController,
    Backend\DashboardController
};

// Home / Login Page route
Route::get('/', [LoginController::class, 'index'])->name('index');

// Grouping routes that require check.session.cookie middleware
Route::middleware(['check.session.cookie'])->group(function () {

    // Route for dashboard page
    Route::get('dashboard', [DashboardController::class, 'index'])->name('backend.dashboard');

});

// Route for logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
