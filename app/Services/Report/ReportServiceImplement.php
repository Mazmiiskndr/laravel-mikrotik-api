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

}
