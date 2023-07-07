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
     * Retrieve users data records and associated service names.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $conditions
     * @param array|null $columns
     * @return array
     */
    public function getUsersData($conditions = null, $columns = ['*'])
    {
        return $this->handleRepositoryCall('getUsersData', [$conditions, $columns]);
    }

    /**
     * Retrieve userData by id.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $id
     * @return array
     */
    public function getUserDataById($id)
    {
        return $this->handleRepositoryCall('getUserDataById', [$id]);
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

    /**
     * Delete users data data from tables based on the users data ID.
     * @param string $id The ID of the users data to delete.
     * @throws \Exception if an error occurs while deleting the users data.
     */
    public function deleteUsersData($id)
    {
        return $this->handleRepositoryCall('deleteUsersData',[ $id ]);
    }
}
