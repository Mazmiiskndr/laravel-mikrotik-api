<?php

namespace App\Services\Setting;

use LaravelEasyRepository\Service;
use App\Repositories\Setting\SettingRepository;
use App\Traits\HandleRepositoryCall;
use Exception;

class SettingServiceImplement extends Service implements SettingService
{
    use HandleRepositoryCall;

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
