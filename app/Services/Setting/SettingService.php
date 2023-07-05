<?php

namespace App\Services\Setting;

use LaravelEasyRepository\BaseService;

interface SettingService extends BaseService{

    /**
     * Retrieves a setting based on the setting name and module ID.
     * @param string $settingName The setting name.
     * @param string|null $flagModule The flag module.
     * @return string Returns the setting value.
     */
    public function getSetting($settingName, $flagModule);

    /**
     * Updates a setting based on the setting name, module ID, and new value.
     * @param string $settingName The setting name.
     * @param string|null $flagModule The flag module.
     * @param string $value The new value.
     * @return int The number of affected rows.
     */
    public function updateSetting($settingName, $flagModule, $value);

    /**
     * Get th allowede permissions array for all actions.
     * @return array
     * @param  mixed $actions
     */
    public function getAllowedPermissions($actions);
}
