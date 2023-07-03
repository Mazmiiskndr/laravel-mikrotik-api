<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Backend\Client\ClientController,
    Backend\Client\Voucher\VoucherBatchController,
    Backend\Client\Voucher\VoucherActiveController,
};

// Grouping routes that require check.session.cookie middleware
Route::middleware(['check.session.cookie'])->group(function () {

    // Grouping routes related to Clients section
    Route::prefix('clients')->name('backend.clients.')->group(function () {
        // Route for clients list page
        Route::get('list-clients', [ClientController::class, 'index'])->name('list-clients');

        // Grouping routes related to configuration voucher
        Route::prefix('voucher')->name('voucher.')->group(function () {
            // Route for configs list page
            Route::get('list-voucher-batches', [VoucherBatchController::class, 'index'])->name('list-voucher-batches');
            Route::get('voucher-batch-detail/{voucher_batch_id}', [VoucherBatchController::class, 'show'])->name('voucher-batch-detail');
            Route::get('list-active-vouchers', [VoucherActiveController::class, 'index'])->name('list-active-vouchers');
            // TODO: PRINT PDF VOUCHER
            // Route::get('vouchers/{voucherBatchId}/print', [VoucherActiveController::class, 'print'])->name('print');
        });

    });

});

