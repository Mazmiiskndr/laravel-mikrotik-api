<?php

use Illuminate\Support\Facades\Route;

// Import Livewire DataTables SETUP Controllers
use App\Http\Livewire\Backend\Setup\{
    Administrator\Admin\DataTable as DataTableAdmin,
    Administrator\Group\DataTable as DataTableGroup,
    Ads\DataTable as DataTableAds,
    Config\DataTable as DataTableConfig,
    Config\HotelRoom\DataTable as DataTableHotelRoom
};

// Import Livewire DataTables Controllers
use App\Http\Livewire\Backend\{
    Client\List\DataTable as DataTableClient,
    Service\List\DataTable as DataTableService,
    Dashboard\DataTable as DataTableLeasesData
};

// Grouping routes that require check.session.cookie middleware
Route::middleware(['check.session.cookie'])->group(function () {

    // Grouping routes related to getting datatable for both administrator and configurations
    Route::prefix('livewire/backend/')->group(function () {

        Route::prefix('setup')->group(function () {
            // Grouping routes related to getting datatable for administrator
            Route::prefix('administrator')->group(function () {
                // Route for getting datatable data for admins
                Route::get('admin/getDataTable', [DataTableAdmin::class, 'getDataTable'])->name('admin.getDataTable');
                // Route for getting datatable data for groups
                Route::get('group/getDataTable', [DataTableGroup::class, 'getDataTable'])->name('group.getDataTable');
                // Route for getting datatable data for ads
                Route::get('ads/getDataTable', [DataTableAds::class, 'getDataTable'])->name('ads.getDataTable');
            });

            // Grouping routes related to getting datatable for configurations
            Route::prefix('config')->group(function () {
                // Route for getting datatable data for configurations
                Route::get('getDataTable', [DataTableConfig::class, 'getDataTable'])->name('config.getDataTable');
                // Route for getting datatable data for hotel rooms configuration
                Route::get('hotelRoom/getDataTable', [DataTableHotelRoom::class, 'getDataTable'])->name('config.hotelRoom.getDataTable');
            });
        });

        Route::prefix('client/')->group(function () {
                // Route for getting datatable data for clients
                Route::get('getDataTable', [DataTableClient::class, 'getDataTable'])->name('client.getDataTable');
        });

        Route::prefix('service/')->group(function () {
                // Route for getting datatable data for clients
                Route::get('getDataTable', [DataTableService::class, 'getDataTable'])->name('service.getDataTable');
        });

        // Grouping routes related to getting datatable for both administrator and configurations
        Route::prefix('dashboard/')->group(function () {
            // Grouping routes related to getting datatable for administrator
            // Route for getting datatable data for admins
            Route::get('leasesData/getDataTable', [DataTableLeasesData::class, 'getDataTable'])->name('leasesData.getDataTable');
        });

    });
});
