<?php

namespace App\Services\Config\SocialPlugin;

use LaravelEasyRepository\Service;
use App\Repositories\Config\SocialPlugin\SocialPluginRepository;
use App\Traits\HandleRepositoryCall;

class SocialPluginServiceImplement extends Service implements SocialPluginService
{
    use HandleRepositoryCall;

    protected $mainRepository;
    /**
     * Constructor.
     * @param SocialPluginRepository $mainRepository The main repository for settings.
     */
    public function __construct(SocialPluginRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Retrieves the parameters for the social plugin.
     * @return mixed Returns a collection of setting records which contains setting name and its value.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function getSocialPluginParameters()
    {
        return $this->handleRepositoryCall('getSocialPluginParameters');
    }

    /**
     * Updates or creates social plugin settings based on the given data.
     * @param array $settings The settings to update or create.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function updateSocialPluginSettings($settings)
    {
        return $this->handleRepositoryCall('updateSocialPluginSettings', [$settings]);
    }
}
