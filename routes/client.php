<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Backend\Client\ClientController,
    Backend\Client\Voucher\VoucherBatchController,
    Backend\Client\Voucher\VoucherActiveController,
    Backend\Client\HotelRoom\HotelRoomsController,
    Backend\Client\UserData\UsersDataController,
    Backend\Client\BypassMacs\BypassMacsController,
};

// Grouping routes that require check.session.cookie middleware
Route::middleware(['check.session.cookie'])->group(function () {

    // Grouping routes related to Clients section
    Route::prefix('clients')->name('backend.clients.')->group(function () {
        // Route for clients list page
        Route::get('list-clients', [ClientController::class, 'index'])->name('list-clients');

        // Grouping routes related to configuration voucher
        Route::prefix('voucher')->name('voucher.')->group(function () {
            // Route for list voucher batches page
            Route::get('list-voucher-batches', [VoucherBatchController::class, 'index'])->name('list-voucher-batches');

            Route::get('voucher-batch-detail/{voucher_batch_id}', [VoucherBatchController::class, 'show'])->name('voucher-batch-detail');
            // Print voucher batch detail 👇
            Route::get('voucher-batch-detail/{voucher_batch_id}/print', [VoucherBatchController::class, 'print'])->name('voucher-batch-detail.print');

            Route::get('list-active-vouchers', [VoucherActiveController::class, 'index'])->name('list-active-vouchers');
        });

        // Route for hotel rooms list page
        Route::get('hotel-rooms', [HotelRoomsController::class, 'index'])->name('hotel-rooms');
        // Print hotel rooms to PDF 👇
        Route::get('hotel-rooms/print', [HotelRoomsController::class, 'print'])->name('hotel-rooms.print');
        // Route for list bypassed macs list page
        Route::get('list-bypassed-macs', [BypassMacsController::class, 'bypassed'])->name('list-bypassed-macs');
        // Route for list blocked macs list page
        Route::get('list-blocked-macs', [BypassMacsController::class, 'blocked'])->name('list-blocked-macs');
        // Route for configs list users data page
        Route::get('users-data', [UsersDataController::class, 'index'])->name('users-data');
        // Print users data to PDF 👇
        Route::get('users-data/print', [UsersDataController::class, 'print'])->name('users-data.print');

    });

});

