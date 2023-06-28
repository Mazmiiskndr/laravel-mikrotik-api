<?php

namespace App\Repositories\Config\SocialPlugin;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Setting;

class SocialPluginRepositoryImplement extends Eloquent implements SocialPluginRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieves the parameters for the social plugin.
     * @return Collection Returns a collection of setting records which contains setting name and its value.
     */
    public function getSocialPluginParameters()
    {
        // Get records from setting table based on setting
        $socialPlugins = $this->model->whereIn(
            'setting',
            [
                'fb_app_id',
                'fb_app_secret',
                'tw_api_key',
                'tw_api_secret',
                'google_api_client_id',
                'login_with_facebook_on',
                'login_with_twitter_on',
                'login_with_google_on',
                'login_with_linkedin_on',
                'google_api_client_secret',
                'linkedin_api_client_id',
                'linkedin_api_client_secret',
            ]
        )->get();

        return $socialPlugins;
    }

    /**
     * Updates or creates social plugin settings based on the given data.
     * @param array $settings The settings to update or create.
     */
    public function updateSocialPluginSettings($settings)
    {
        foreach ($settings as $key => $value) {
            $this->model->updateOrCreate(
                ['setting' => $key],
                ['value' => $value]
            );
        }
    }
}
