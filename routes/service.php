<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Backend\Service\ServiceController,
};

// Grouping routes that require check.session.cookie middleware
Route::middleware(['check.session.cookie'])->group(function () {

    // Grouping routes related to SETUP section
    Route::prefix('services')->name('backend.services.')->group(function () {
        // Route for services list page
        Route::get('list-services', [ServiceController::class, 'index'])->name('list-services');
        // Route for add new service page
        Route::get('add-new-service', [ServiceController::class, 'create'])->name('add-new-service');
        // Route for edit service page
        Route::get('edit-service/{id}', [ServiceController::class, 'edit'])->name('edit-service');
        // Route for services list premium page
        Route::get('premium-services', [ServiceController::class, 'showPremiumServices'])->name('premium-services');
        // Route for edit service page
        Route::get('edit-premium-services/{id}', [ServiceController::class, 'editPremiumServices'])->name('edit-premium-service');
    });
});
