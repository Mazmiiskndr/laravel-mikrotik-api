<?php

namespace App\Services\Report;

use LaravelEasyRepository\Service;
use App\Repositories\Report\ReportRepository;
use App\Traits\HandleRepositoryCall;
use Exception;

class ReportServiceImplement extends Service implements ReportService
{
    use HandleRepositoryCall;

    protected $mainRepository;
    /**
     * Constructor.
     * @param ReportRepository $mainRepository The main repository for reports.
     */
    public function __construct(ReportRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Retrieves all list radacct records where 'acctstoptime' is NULL.
     * @return mixed The result of calling the `getAllRadAcct` method of the `mainRepository` object.
     * @throws Exception If an error occurs while retrieving radacct records.
     */
    public function getAllRadAcct()
    {
        return $this->handleRepositoryCall('getAllRadAcct');
    }

    /**
     * Retrieves records from the database, initializes DataTables, and adds columns to DataTable.
     * @return mixed The result of calling the `getDatatables` method of the `mainRepository` object.
     * @throws Exception If an error occurs while retrieving data for DataTables.
     */
    public function getDatatables()
    {
        return $this->handleRepositoryCall('getDatatables');
    }

    /**
     * Retrieve one radacct records where by 'radacctId'.
     * @param int $id RadAcct ID for query.
     */
    public function getRadAcctById($radAcctId)
    {
        return $this->handleRepositoryCall('getRadAcctById', [$radAcctId]);
    }

    /**
     * Updates an existing blocked mac addresses using the provided request data.
     * @param object $request The data used to update the blocked mac addresses.
     * @return Model|mixed The updated blocked mac addresses.
     * @throws \Exception if an error occurs while updating the blocked mac addresses.
     */
    public function blockedMacAddresses($request)
    {
        return $this->handleRepositoryCall('blockedMacAddresses', [$request]);
    }

}
