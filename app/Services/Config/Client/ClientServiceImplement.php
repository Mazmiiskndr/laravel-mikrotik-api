<?php

namespace App\Services\Config\Client;

use App\Repositories\Config\Client\ClientRepository;
use App\Traits\HandleRepositoryCall;
use Exception;
use LaravelEasyRepository\Service;

class ClientServiceImplement extends Service implements ClientService
{
    use HandleRepositoryCall;

    protected $mainRepository;
    /**
     * Constructor.
     * @param ClientRepository $mainRepository The main repository for settings.
     */
    public function __construct(ClientRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Retrieves client parameters from the settings table.
     * @return Collection The collection of client parameters.
     */
    public function getClientParameters()
    {
        return $this->handleRepositoryCall('getClientParameters');
    }

    /**
     * Updates or creates client settings based on the provided parameters.
     * @param array $settings The array of settings to update or create.
     * @return void
     */
    public function updateClientSettings($settings)
    {
        return $this->handleRepositoryCall('updateClientSettings', [$settings]);
    }
}
