<?php

namespace App\Services\Config\Ads;

use LaravelEasyRepository\Service;
use App\Repositories\Config\Ads\AdsRepository;
use App\Traits\HandleRepositoryCall;
use Exception;
use Illuminate\Support\Facades\Log;

class AdsServiceImplement extends Service implements AdsService
{
    use HandleRepositoryCall;

    protected $mainRepository;
    /**
     * Constructor.
     * @param AdsRepository $mainRepository The main repository for settings.
     */
    public function __construct(AdsRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Fetches a set of ad parameters from the current model's table.
     * @return mixed A collection of ad parameters.
     * @throws Exception if an error occurs during the repository method call.
     */
    public function getAdsParameters()
    {
        return $this->handleRepositoryCall('getAdsParameters');
    }

    /**
     * Updates or creates ad settings based on the given data.
     * @param  array $settings The settings to update or create.
     * @throws Exception if an error occurs during the repository method call.
     */
    public function updateAdsSettings($settings)
    {
        return $this->handleRepositoryCall('updateAdsSettings', [$settings]);
    }

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return mixed The result of the getDatatables repository method call.
     * @throws Exception if an error occurs during the repository method call.
     */
    public function getDatatables()
    {
        return $this->handleRepositoryCall('getDatatables');
    }

    /**
     * Stores a new ad using the provided request data.
     * @param array $request The data used to create the new ad.
     * @return mixed The newly created ad.
     * @throws Exception if an error occurs while creating the ad.
     */
    public function storeNewAd($request)
    {
        return $this->handleRepositoryCall('storeNewAd', [$request]);
    }

    /**
     * Updates an existing ad using the provided request data.
     * @param array $request The data used to update the ad.
     * @param int $id The ID of the ad to update.
     * @return mixed The updated ad.
     * @throws Exception if an error occurs while updating the ad.
     */
    public function updateAd($request, $id)
    {
        return $this->handleRepositoryCall('updateAd', [$request, $id]);
    }

    /**
     * Deletes an existing ad and its associated images.
     * @param int $id The ID of the ad to delete.
     * @throws Exception if an error occurs while deleting the ad.
     */
    public function deleteAd($id)
    {
        return $this->handleRepositoryCall('deleteAd', [$id]);
    }

    /**
     * Get the maximum width for ads from the settings.
     * @return int|null The maximum width for ads.
     * @throws Exception if an error occurs during the repository method call.
     */
    public function adsMaxWidth()
    {
        return $this->handleRepositoryCall('adsMaxWidth');
    }

    /**
     * Get the maximum height for ads from the settings.
     * @return int|null The maximum height for ads.
     * @throws Exception if an error occurs during the repository method call.
     */
    public function adsMaxHeight()
    {
        return $this->handleRepositoryCall('adsMaxHeight');
    }

    /**
     * Get the maximum size for ads from the settings.
     * @return int|null The maximum size for ads.
     * @throws Exception if an error occurs during the repository method call.
     */
    public function adsMaxSize()
    {
        return $this->handleRepositoryCall('adsMaxSize');
    }

    /**
     * Get the maximum mobile width for ads from the settings.
     * @return int|null The maximum mobile width for ads.
     * @throws Exception if an error occurs during the repository method call.
     */
    public function mobileAdsMaxWidth()
    {
        return $this->handleRepositoryCall('mobileAdsMaxWidth');
    }

    /**
     * Get the maximum mobile height for ads from the settings.
     * @return int|null The maximum mobile height for ads.
     * @throws Exception if an error occurs during the repository method call.
     */
    public function mobileAdsMaxHeight()
    {
        return $this->handleRepositoryCall('mobileAdsMaxHeight');
    }

    /**
     * Get the maximum mobile size for ads from the settings.
     * @return int|null The maximum mobile size for ads.
     * @throws Exception if an error occurs during the repository method call.
     */
    public function mobileAdsMaxSize()
    {
        return $this->handleRepositoryCall('mobileAdsMaxSize');
    }

    /**
     * Get the path ads upload folder for ads from the settings.
     * @return int|null The maximum ads upload folder for ads.
     * @throws Exception if an error occurs during the repository method call.
     */
    public function adsUploadFolder()
    {
        return $this->handleRepositoryCall('adsUploadFolder');
    }
}
