<?php

namespace App\Services\Config\Client;

use LaravelEasyRepository\BaseService;

interface ClientService extends BaseService{

    /**
     * Retrieves client parameters from the settings table.
     * @return Collection The collection of client parameters.
     */
    public function getClientParameters();

    /**
     * Updates or creates client settings based on the provided parameters.
     * @param array $settings The array of settings to update or create.
     * @return void
     */
    public function updateClientSettings($settings);
}
