<?php

namespace App\Services\Report;

use LaravelEasyRepository\BaseService;

interface ReportService extends BaseService{

    /**
     * Retrieves get all list radacct records where 'acctstoptime' is NULL.
     * Also, includes the first usage time for each user.
     * @return array An array that contains rows of data and number of rows.
     */
    public function getAllRadAcct();

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables();
}