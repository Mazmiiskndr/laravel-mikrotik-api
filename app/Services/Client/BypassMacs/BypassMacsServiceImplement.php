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
    public function getBypassMacId($bypassMacsId)
    {
        return $this->handleRepositoryCall('getBypassMacId', [$bypassMacsId]);
    }


    /**
     * Retrieves List Bypassed Macs records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableListBypassed()
    {
        return $this->handleRepositoryCall('getDatatableListBypassed');
    }
    /**
     * Define validation rules for bypass macs creation.
     * @param string|null $id Bypass Macs ID for uniqueness checks. If not provided, a create operation is assumed.
     * @return array Array of validation rules
     */
    public function getRules($id = null)
    {
        return $this->handleRepositoryCall('getRules', [$id]);
    }

    /**
     * Define validation messages for bypass mac creation.
     * @return array Array of validation messages
     */
    public function getMessages()
    {
        return $this->handleRepositoryCall('getMessages');
    }

    /**
     * Stores a new bypass mac using the provided request data.
     * @param array $request The data used to create the new bypass mac.
     * @return Model|mixed The newly created bypass mac.
     * @throws \Exception if an error occurs while creating the bypass mac.
     */
    public function storeNewBypassMac($request)
    {
        return $this->handleRepositoryCall('storeNewBypassMac',[$request]);
    }

    /**
     * Updates an existing bypass mac using the provided request data.
     * @param string $id Bypass Macs ID for uniqueness checks.
     * @param array $request The data used to update the bypass mac.
     * @return Model|mixed The updated bypass mac.
     * @throws \Exception if an error occurs while updating the bypass mac.
     */
    public function updateBypassMac($bypassMacId, $request)
    {
        return $this->handleRepositoryCall('updateBypassMac',[$bypassMacId, $request]);
    }

    /**
     * Deletes a bypass mac and its associated Mikrotik IP binding using the provided bypass mac ID.
     * @param string $bypassMacId The ID of the bypass mac to delete.
     * @return bool Whether the deletion was successful.
     * @throws \Exception if an error occurs while deleting the bypass mac.
     */
    public function deleteBypassMac($bypassMacId)
    {
        return $this->handleRepositoryCall('deleteBypassMac', [$bypassMacId]);
    }
}
