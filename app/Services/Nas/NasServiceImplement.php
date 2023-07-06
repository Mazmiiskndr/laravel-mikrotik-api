<?php

namespace App\Services\Nas;

use LaravelEasyRepository\Service;
use App\Repositories\Nas\NasRepository;
use App\Traits\HandleRepositoryCall;
use Exception;
class NasServiceImplement extends Service implements NasService
{
    use HandleRepositoryCall;

    protected $mainRepository;
    /**
     * Constructor.
     * @param NasRepository $mainRepository The main repository for settings.
     */
    public function __construct(NasRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Retrieves NAS (Network Access Server) by its shortname.
     * @param string $shortName The shortname of the NAS.
     * @return mixed The result of calling the `getNasByShortname` method of the `mainRepository` object.
     * @throws Exception If an error occurs while retrieving NAS.
     */
    public function getNasByShortname($shortName)
    {
        return $this->handleRepositoryCall('getNasByShortname', [$shortName]);
    }

    /**
     * Fetches all parameters related to NAS.
     * @return mixed The result of calling the `getNasParameters` method of the `mainRepository` object.
     * @throws Exception If an error occurs while retrieving NAS parameters.
     */
    public function getNasParameters()
    {
        return $this->handleRepositoryCall('getNasParameters');
    }

    /**
     * Processes the data for editing a NAS.
     * @param array $data The data to be processed for editing.
     * @return mixed The result of calling the `editNasProcess` method of the `mainRepository` object.
     * @throws Exception If an error occurs while editing NAS.
     */
    public function editNasProcess($data)
    {
        return $this->handleRepositoryCall('editNasProcess', [$data]);
    }

    /**
     * Performs setup process using provided record and data.
     * @param mixed $record The record used in the setup process.
     * @param array $data The data used in the setup process.
     * @return mixed The result of calling the `setupProcess` method of the `mainRepository` object.
     * @throws Exception If an error occurs during the setup process.
     */
    public function setupProcess($record, $data)
    {
        return $this->handleRepositoryCall('setupProcess', [$record, $data]);
    }
}
