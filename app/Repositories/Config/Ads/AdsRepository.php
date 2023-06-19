<?php

namespace App\Repositories\Config\Ads;

use LaravelEasyRepository\Repository;

interface AdsRepository extends Repository{

    /**
     * getAdsParameters
     *
     * @return void
     */
    public function getAdsParameters();


    /**
     * updateAdsSettings
     *
     * @param  mixed $settings
     * @return void
     */
    public function updateAdsSettings($settings);

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables();

    /**
     * storeNewAd
     * @param  mixed $request
     * @return void
     */
    public function storeNewAd($request);
}
