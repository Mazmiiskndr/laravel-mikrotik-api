<?php

namespace App\Services\Nas;

use LaravelEasyRepository\BaseService;

interface NasService extends BaseService{

    /**
     * Retrieves NAS (Network Access Server) by its shortname.
     * @param string $shortName The shortname of the NAS.
     */
    public function getNasByShortname($shortName);

    /**
     * Fetches all parameters related to NAS.
     */
    public function getNasParameters();

    /**
     * Processes the data for editing a NAS.
     * @param array $data The data to be processed for editing.
     */
    public function editNasProcess($data);

    /**
     * Performs setup process using provided record and data.
     * @param mixed $record The record used in the setup process.
     * @param array $data The data used in the setup process.
     */
    public function setupProcess($record, $data);
}
