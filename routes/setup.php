<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Backend\Setup\Administrator\AdminController,
    Backend\Setup\Administrator\GroupController,
    Backend\Setup\Config\ConfigController,
    Backend\Setup\SetUrlRedirectController,
    Backend\Setup\VoucherPrintSetupController,
    Backend\Setup\Ads\AdsController as SetupAdsController
};



Route::middleware(['check.session.cookie'])->group(function () {

    // Grouping routes related to SETUP section
    Route::prefix('setup')->name('backend.setup.')->group(function () {
        // Route for URL redirection setup page
        Route::get('set-url-redirect', [SetUrlRedirectController::class, 'index'])->name('set-url-redirect');

        // Route for voucher print setup page
        Route::get('voucher-print-setup', [VoucherPrintSetupController::class, 'index'])->name('voucher-print-setup');

        // Grouping routes related to administrator setup
        Route::prefix('admin')->name('admin.')->group(function () {
            // Route for admins list page
            Route::get('list-admins', [AdminController::class, 'index'])->name('list-admins');
            // Route for groups list page
            Route::get('list-groups', [GroupController::class, 'index'])->name('list-groups');
            // Route for adding a new group
            Route::get('add-new-group', [GroupController::class, 'create'])->name('add-new-group');
            // Route for edit group
            Route::get('edit-group/{id}', [GroupController::class, 'edit'])->name('edit-group');
        });

        // Grouping routes related to configuration setup
        Route::prefix('config')->name('config.')->group(function () {
            // Route for configs list page
            Route::get('list-configs', [ConfigController::class, 'index'])->name('list-config');
            // Route for hotel rooms configuration page
            Route::get('list-configs/hotel_rooms', [ConfigController::class, 'hotel_rooms'])->name('hotel_rooms');
        });

        // Grouping routes related to ads setup
        Route::prefix('ads')->name('ads.')->group(function () {
            // Route for ads list page
            Route::get('list-ads', [SetupAdsController::class, 'index'])->name('list-ads');
        });
    });


});
