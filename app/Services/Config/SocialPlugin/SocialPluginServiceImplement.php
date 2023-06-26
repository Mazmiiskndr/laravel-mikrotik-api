<?php

namespace App\Services\Config\SocialPlugin;

use LaravelEasyRepository\Service;
use App\Repositories\Config\SocialPlugin\SocialPluginRepository;
use Illuminate\Support\Facades\Log;

class SocialPluginServiceImplement extends Service implements SocialPluginService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(SocialPluginRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Retrieves the parameters for the social plugin.
     * @return Collection Returns a collection of setting records which contains setting name and its value.
     */
    public function getSocialPluginParameters()
    {
        try {
            return $this->mainRepository->getSocialPluginParameters();
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
            throw $th;
        }
    }

    /**
     * Updates or creates social plugin settings based on the given data.
     * @param array $settings The settings to update or create.
     */
    public function updateSocialPluginSettings($settings)
    {
        try {
            return $this->mainRepository->updateSocialPluginSettings($settings);
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
            throw $th;
        }
    }
}
