<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Backend\Client\ListClientController,
};

// Grouping routes that require check.session.cookie middleware
Route::middleware(['check.session.cookie'])->group(function () {

    // Grouping routes related to SETUP section
    Route::prefix('clients')->name('backend.clients.')->group(function () {
        // Route for clients list page
        Route::get('list-clients', [ListClientController::class, 'index'])->name('list-clients');

    });

});

