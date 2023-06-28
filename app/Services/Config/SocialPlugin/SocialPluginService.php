<?php

namespace App\Services\Config\SocialPlugin;

use LaravelEasyRepository\BaseService;

interface SocialPluginService extends BaseService{

    /**
     * Retrieves the parameters for the social plugin.
     * @return Collection Returns a collection of setting records which contains setting name and its value.
     */
    public function getSocialPluginParameters();

    /**
     * Updates or creates social plugin settings based on the given data.
     * @param array $settings The settings to update or create.
     */
    public function updateSocialPluginSettings($settings);
}
