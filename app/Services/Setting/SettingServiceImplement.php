<?php

namespace App\Services\Setting;

use LaravelEasyRepository\Service;
use App\Repositories\Setting\SettingRepository;
use Exception;

class SettingServiceImplement extends Service implements SettingService
{

    protected $mainRepository;
    /**
     * Constructor.
     * @param SettingRepository $mainRepository The main repository for settings.
     */
    public function __construct(SettingRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Handles the method call to the repository and manages exceptions.
     * @param string $method The method to call.
     * @param array $parameters The parameters to pass to the method.
     * @throws Exception If there is an error when calling the method.
     * @return mixed The result of the method call.
     */
    private function handleRepositoryCall(string $method, array $parameters = [])
    {
        try {
            return $this->mainRepository->{$method}(...$parameters);
        } catch (Exception $exception) {
            $errorMessage = "Error when calling $method: " . $exception->getMessage();
            throw new Exception($errorMessage);
        }
    }

    /**
     * Retrieves a setting based on the setting name and module ID.
     * @param string $settingName The setting name.
     * @param string|null $flagModule The flag module.
     * @return string Returns the setting value.
     */
    public function getSetting($settingName, $flagModule = null)
    {
        return $this->handleRepositoryCall('getSetting', [$settingName, $flagModule]);
    }

    /**
     * Updates a setting based on the setting name, module ID, and new value.
     * @param string $settingName The setting name.
     * @param string|null $flagModule The flag module.
     * @param string $value The new value.
     * @return int The number of affected rows.
     */
    public function updateSetting($settingName, $flagModule = null, $value)
    {
        return $this->handleRepositoryCall('updateSetting', [$settingName, $flagModule, $value]);
    }

    /**
     * Gets the allowed permissions array for all actions.
     * @param array $actions The actions.
     * @return array The allowed permissions.
     * @throws Exception If an error occurs while retrieving the permissions.
     */
    public function getAllowedPermissions($actions)
    {
        return $this->handleRepositoryCall('getAllowedPermissions', [$actions]);
    }
}
