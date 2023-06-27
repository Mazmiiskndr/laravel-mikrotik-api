<?php

namespace App\Services\Config\SocialPlugin;

use LaravelEasyRepository\Service;
use App\Repositories\Config\SocialPlugin\SocialPluginRepository;

class SocialPluginServiceImplement extends Service implements SocialPluginService
{
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
     * Handles the method call to the repository and manages exceptions.
     * @param string $method The method to call.
     * @param array $parameters The parameters to pass to the method.
     * @throws \Exception If there is an error when calling the method.
     * @return mixed The result of the method call.
     */
    private function handleRepositoryCall(string $method, array $parameters = [])
    {
        try {
            return $this->mainRepository->{$method}(...$parameters);
        } catch (\Exception $exception) {
            $errorMessage = "Error when calling $method: " . $exception->getMessage();
            throw $exception;
        }
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
