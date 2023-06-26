<?php

namespace App\Services\Report;

use LaravelEasyRepository\Service;
use App\Repositories\Report\ReportRepository;
use Exception;

class ReportServiceImplement extends Service implements ReportService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(ReportRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Retrieves get all list radacct records where 'acctstoptime' is NULL.
     * Also, includes the first usage time for each user.
     * @return array An array that contains rows of data and number of rows.
     */
    public function getAllRadAcct()
    {
        try {
            return $this->mainRepository->getAllRadAcct();
        } catch (Exception $exception) {
            throw new Exception("Error getting data radacct : " . $exception->getMessage());
        }
    }

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables()
    {
        try {
            return $this->mainRepository->getDatatables();
        } catch (Exception $exception) {
            throw new Exception("Error getting data to datatable : " . $exception->getMessage());
        }
    }

}
