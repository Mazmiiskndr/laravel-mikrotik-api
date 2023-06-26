<?php

namespace App\Repositories\Config\Ads;

use LaravelEasyRepository\Repository;

interface AdsRepository extends Repository{

    /**
     * Fetches a set of ad parameters from the current model's table.
     * @return Collection A collection of Eloquent model instances.
     */
    public function getAdsParameters();

    /**
     * Updates or creates ad settings based on the given data.
     * @param  array $settings The settings to update or create.
     */
    public function updateAdsSettings($settings);

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables();

    /**
     * Stores a new ad using the provided request data.
     * @param array $request The data used to create the new ad.
     * @return Model|mixed The newly created ad.
     * @throws \Exception if an error occurs while creating the ad.
     */
    public function storeNewAd($request);

    /**
     * Updates an existing ad using the provided request data.
     * @param array $request The data used to update the ad.
     * @param int $id The ID of the ad to update.
     * @return Model|mixed The updated ad.
     * @throws \Exception if an error occurs while updating the ad.
     */
    public function updateAd($request, $id);

    /**
     * Deletes an existing ad and its associated images.
     * @param int $id The ID of the ad to delete.
     * @throws \Exception if an error occurs while deleting the ad.
     */
    public function deleteAd($id);

    /**
     * Get the maximum width for ads from the settings.
     * @return int|null The maximum width for ads.
     */
    public function adsMaxWidth();

    /**
     * Get the maximum height for ads from the settings.
     * @return int|null The maximum height for ads.
     */
    public function adsMaxHeight();

    /**
     * Get the maximum size for ads from the settings.
     * @return int|null The maximum size for ads.
     */
    public function adsMaxSize();

    /**
     * Get the maximum mobile width for ads from the settings.
     * @return int|null The maximum mobile width for ads.
     */
    public function mobileAdsMaxWidth();

    /**
     * Get the maximum mobile height for ads from the settings.
     * @return int|null The maximum mobile height for ads.
     */
    public function mobileAdsMaxHeight();

    /**
     * Get the maximum mobile size for ads from the settings.
     * @return int|null The maximum mobile size for ads.
     */
    public function mobileAdsMaxSize();

    /**
     * Get the path ads upload folder for ads from the settings.
     * @return int|null The maximum ads upload folder for ads.
     */
    public function adsUploadFolder();
}
