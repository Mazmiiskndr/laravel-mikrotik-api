<?php

use Illuminate\Support\Facades\Route;
// Import Controllers for routes
use App\Http\Controllers\{
    Backend\Report\ListOnlineUserController,
};

// Grouping routes that require check.session.cookie middleware
Route::middleware(['check.session.cookie'])->group(function () {
    // Route for online users list page in reports section
    Route::get('reports/list-online-users', [ListOnlineUserController::class, 'index'])->name('backend.reports.list-online-users');
});
