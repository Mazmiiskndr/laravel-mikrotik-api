<?php

namespace App\Services\Nas;

use LaravelEasyRepository\Service;
use App\Repositories\Nas\NasRepository;
use Illuminate\Support\Facades\Log;

class NasServiceImplement extends Service implements NasService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(NasRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Retrieves NAS (Network Access Server) by its shortname.
     * @param string $shortName The shortname of the NAS.
     */
    public function getNasByShortname($shortName)
    {
        try {
            return $this->mainRepository->getNasByShortname($shortName);
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
            throw $th;
        }
    }

    /**
     * Fetches all parameters related to NAS.
     */
    public function getNasParameters()
    {
        try {
            return $this->mainRepository->getNasParameters();
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
            throw $th;
        }
    }

    /**
     * Processes the data for editing a NAS.
     * @param array $data The data to be processed for editing.
     */
    public function editNasProcess($data)
    {
        try {
            return $this->mainRepository->editNasProcess($data);
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
            throw $th;
        }
    }

    /**
     * Performs setup process using provided record and data.
     * @param mixed $record The record used in the setup process.
     * @param array $data The data used in the setup process.
     */
    public function setupProcess($record, $data)
    {
        try {
            return $this->mainRepository->setupProcess($record, $data);
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
            throw $th;
        }
    }
}
