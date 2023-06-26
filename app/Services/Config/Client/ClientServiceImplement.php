<?php

namespace App\Services\Config\Client;

use App\Repositories\Config\Client\ClientRepository;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Log;

class ClientServiceImplement extends Service implements ClientService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

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
        try {
            return $this->mainRepository->getClientParameters();
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
            throw $th;
        }
    }

    /**
     * Updates or creates client settings based on the provided parameters.
     * @param array $settings The array of settings to update or create.
     * @return void
     */
    public function updateClientSettings($settings)
    {
        try {
            $this->mainRepository->updateClientSettings($settings);
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
            throw $th;
        }
    }
}
