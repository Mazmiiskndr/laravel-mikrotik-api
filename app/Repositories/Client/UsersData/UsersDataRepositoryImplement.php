<?php

namespace App\Repositories\Client\UsersData;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\UserData;

class UsersDataRepositoryImplement extends Eloquent implements UsersDataRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(UserData $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables()
    {
        // code..
    }
}
