<?php

namespace App\Services\Client\UsersData;

use LaravelEasyRepository\Service;
use App\Repositories\Client\UsersData\UsersDataRepository;
use App\Traits\HandleRepositoryCall;
use Exception;

class UsersDataServiceImplement extends Service implements UsersDataService
{
    use HandleRepositoryCall;

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(UsersDataRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return mixed The result of the getDatatables repository method call.
     * @throws Exception if an error occurs during the repository method call.
     */
    public function getDatatables()
    {
        return $this->handleRepositoryCall('getDatatables');
    }

    // Define your custom methods :)
}
