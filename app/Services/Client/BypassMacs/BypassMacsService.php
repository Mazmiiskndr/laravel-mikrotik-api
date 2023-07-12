<?php

namespace App\Services\Client\BypassMacs;

use LaravelEasyRepository\BaseService;

interface BypassMacsService extends BaseService{

    /**
     * Retrieve Bypass Macs records.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $conditions
     * @param array|null $columns
     * @return array
     */
    public function getBypassMacs($conditions, $columns);

    /**
     * This function finds a bypass mac with id.
     * @param $bypassMacsId
     * @return mixed
     */
    public function getBypassMacId($bypassMacsId);

    /**
     * Retrieves List Bypassed Macs records from a database, initializes DataTables, and adds columns to DataTable.
     * @param array|null $columns
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatable($status);

    /**
     * Define validation rules for bypass macs creation.
     * @param string|null $id Bypass Macs ID for uniqueness checks. If not provided, a create operation is assumed.
     * @return array Array of validation rules
     */
    public function getRules($id = null);

    /**
     * Define validation messages for bypass mac creation.
     * @return array Array of validation messages
     */
    public function getMessages();

    /**
     * Stores a new bypass mac using the provided request data.
     * @param array $request The data used to create the new bypass mac.
     * @return Model|mixed The newly created bypass mac.
     * @throws \Exception if an error occurs while creating the bypass mac.
     */
    public function storeNewBypassMac($request);

    /**
     * Updates an existing bypass mac using the provided request data.
     * @param string $id Bypass Macs ID for uniqueness checks.
     * @param array $request The data used to update the bypass mac.
     * @return Model|mixed The updated bypass mac.
     * @throws \Exception if an error occurs while updating the bypass mac.
     */
    public function updateBypassMac($bypassMacId, $request);

    /**
     * Deletes a bypass mac and its associated Mikrotik IP binding using the provided bypass mac ID.
     * @param string $bypassMacId The ID of the bypass mac to delete.
     * @return bool Whether the deletion was successful.
     * @throws \Exception if an error occurs while deleting the bypass mac.
     */
    public function deleteBypassMac($bypassMacId);

    /**
     * Creates or updates a bypass mac using the provided data.
     * @param array $request The data used to create or update the bypass mac.
     * @return Model|mixed The newly created or updated bypass mac.
     */
    public function createOrUpdateBypassMac($request);
}
