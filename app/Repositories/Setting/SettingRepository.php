<?php

namespace App\Repositories\Setting;

use LaravelEasyRepository\Repository;

interface SettingRepository extends Repository{

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
     * Get the allowed permissions array for all actions.
     * @return array
     * @param  mixed $actions
     */
    public function getAllowedPermissions($actions);
}
