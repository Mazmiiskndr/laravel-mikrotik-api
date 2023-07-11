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
    public function getBypassMacsId($bypassMacsId);


    /**
     * Retrieves List Bypassed Macs records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableListBypassed();

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
}
