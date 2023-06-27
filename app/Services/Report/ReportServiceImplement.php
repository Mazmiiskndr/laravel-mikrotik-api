<?php

namespace App\Services\Report;

use LaravelEasyRepository\Service;
use App\Repositories\Report\ReportRepository;
use Exception;

class ReportServiceImplement extends Service implements ReportService
{

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
