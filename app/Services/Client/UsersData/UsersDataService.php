<?php

namespace App\Services\Client\UsersData;

use LaravelEasyRepository\BaseService;

interface UsersDataService extends BaseService{

    /**
     * Retrieve users data records and associated service names.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $conditions
     * @param array|null $columns
     * @return array
     */
    public function getUsersData($conditions, $columns);

    /**
     * Retrieve userData by id.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $id
     * @return array
     */
    public function getUserDataById($id);

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables();

    /**
     * Delete users data data from tables based on the users data ID.
     * @param string $id The ID of the users data to delete.
     * @throws \Exception if an error occurs while deleting the users data.
     */
    public function deleteUsersData($id);
}
