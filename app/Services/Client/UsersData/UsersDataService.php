<?php

namespace App\Services\Client\UsersData;

use LaravelEasyRepository\BaseService;

interface UsersDataService extends BaseService{

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables();
}
