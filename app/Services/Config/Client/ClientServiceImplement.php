<?php

namespace App\Services\Config\Client;

use App\Repositories\Config\Client\ClientRepository;
use Exception;
use LaravelEasyRepository\Service;

class ClientServiceImplement extends Service implements ClientService
{
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
