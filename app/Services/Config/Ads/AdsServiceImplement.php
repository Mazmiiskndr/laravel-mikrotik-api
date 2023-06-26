<?php

namespace App\Services\Config\Ads;

use LaravelEasyRepository\Service;
use App\Repositories\Config\Ads\AdsRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class AdsServiceImplement extends Service implements AdsService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(AdsRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Fetches a set of ad parameters from the current model's table.
     * @return Collection A collection of Eloquent model instances.
     */
    public function getAdsParameters()
    {
        try {
            return $this->mainRepository->getAdsParameters();
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
        }
    }

    /**
     * Updates or creates ad settings based on the given data.
     * @param  array $settings The settings to update or create.
     */
    public function updateAdsSettings($settings)
    {
        try {
            return $this->mainRepository->updateAdsSettings($settings);
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
        }
    }

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables()
    {
        try {
            return $this->mainRepository->getDatatables();
        } catch (Exception $exception) {
            throw new Exception("Error get datatables ads : " . $exception->getMessage());
        }
    }

    /**
     * Stores a new ad using the provided request data.
     * @param array $request The data used to create the new ad.
     * @return Model|mixed The newly created ad.
     * @throws \Exception if an error occurs while creating the ad.
     */
    public function storeNewAd($request)
    {
        try {
            return $this->mainRepository->storeNewAd($request);
        } catch (Exception $exception) {
            throw new Exception("Error to store new ad : " . $exception->getMessage());
        }
    }

    /**
     * Updates an existing ad using the provided request data.
     * @param array $request The data used to update the ad.
     * @param int $id The ID of the ad to update.
     * @return Model|mixed The updated ad.
     * @throws \Exception if an error occurs while updating the ad.
     */
    public function updateAd($request, $id)
    {
        try {
            return $this->mainRepository->updateAd($request, $id);
        } catch (Exception $exception) {
            throw new Exception("Error to updatin ad : " . $exception->getMessage());
        }
    }

    /**
     * Deletes an existing ad and its associated images.
     * @param int $id The ID of the ad to delete.
     * @throws \Exception if an error occurs while deleting the ad.
     */
    public function deleteAd($id)
    {
        try {
            return $this->mainRepository->deleteAd($id);
        } catch (Exception $exception) {
            throw new Exception("Error deleted ad : " . $exception->getMessage());
        }
    }

    /**
     * Get the maximum width for ads from the settings.
     * @return int|null The maximum width for ads.
     */
    public function adsMaxWidth()
    {
        try {
            return $this->mainRepository->adsMaxWidth();
        } catch (Exception $exception) {
            throw new Exception("Error getting ads max width : " . $exception->getMessage());
        }
    }

    /**
     * Get the maximum height for ads from the settings.
     * @return int|null The maximum height for ads.
     */
    public function adsMaxHeight()
    {
        try {
            return $this->mainRepository->adsMaxHeight();
        } catch (Exception $exception) {
            throw new Exception("Error getting ads max height : " . $exception->getMessage());
        }
    }

    /**
     * Get the maximum size for ads from the settings.
     * @return int|null The maximum size for ads.
     */
    public function adsMaxSize()
    {
        try {
            return $this->mainRepository->adsMaxSize();
        } catch (Exception $exception) {
            throw new Exception("Error getting ads max size : " . $exception->getMessage());
        }
    }

    /**
     * Get the maximum mobile width for ads from the settings.
     * @return int|null The maximum mobile width for ads.
     */
    public function mobileAdsMaxWidth()
    {
        try {
            return $this->mainRepository->mobileAdsMaxWidth();
        } catch (Exception $exception) {
            throw new Exception("Error getting mobile ads max width : " . $exception->getMessage());
        }
    }

    /**
     * Get the maximum mobile height for ads from the settings.
     * @return int|null The maximum mobile height for ads.
     */
    public function mobileAdsMaxHeight()
    {
        try {
            return $this->mainRepository->mobileAdsMaxHeight();
        } catch (Exception $exception) {
            throw new Exception("Error getting mobile ads max height : " . $exception->getMessage());
        }
    }

    /**
     * Get the maximum mobile size for ads from the settings.
     * @return int|null The maximum mobile size for ads.
     */
    public function mobileAdsMaxSize()
    {
        try {
            return $this->mainRepository->mobileAdsMaxSize();
        } catch (Exception $exception) {
            throw new Exception("Error getting mobile ads max size : " . $exception->getMessage());
        }
    }

    /**
     * Get the path ads upload folder for ads from the settings.
     * @return int|null The maximum ads upload folder for ads.
     */
    public function adsUploadFolder()
    {
        try {
            return $this->mainRepository->adsUploadFolder();
        } catch (Exception $exception) {
            throw new Exception("Error getting path ads upload folder : " . $exception->getMessage());
        }
    }
}
