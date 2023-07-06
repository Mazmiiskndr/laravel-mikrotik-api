<?php

namespace App\Repositories\Client\UsersData;

use LaravelEasyRepository\Repository;

interface UsersDataRepository extends Repository{

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables();
}
