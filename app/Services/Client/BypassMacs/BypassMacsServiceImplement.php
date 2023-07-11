<?php

namespace App\Services\Client\BypassMacs;

use LaravelEasyRepository\Service;
use App\Repositories\Client\BypassMacs\BypassMacsRepository;
use App\Traits\HandleRepositoryCall;

class BypassMacsServiceImplement extends Service implements BypassMacsService
{
    use HandleRepositoryCall;

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(BypassMacsRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Retrieve Bypass Macs records.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $conditions
     * @param array|null $columns
     * @return array
     */
    public function getBypassMacs($conditions = null, $columns = ['*'])
    {
        return $this->handleRepositoryCall('getBypassMacs', [$conditions, $columns]);
    }

    /**
     * This function finds a bypass mac with id.
     * @param $bypassMacsId
     * @return mixed
     */
    public function getBypassMacsId($bypassMacsId)
    {
        return $this->handleRepositoryCall('getBypassMacsId', [$bypassMacsId]);
    }


    /**
     * Retrieves List Bypassed Macs records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableListBypassed()
    {
        return $this->handleRepositoryCall('getDatatableListBypassed');
    }
}
