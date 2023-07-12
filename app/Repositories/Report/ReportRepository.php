<?php

namespace App\Repositories\Report;

use LaravelEasyRepository\Repository;

interface ReportRepository extends Repository{

    /**
     * Retrieves get all list radacct records where 'acctstoptime' is NULL.
     * Also, includes the first usage time for each user.
     * @return array An array that contains rows of data and number of rows.
     */
    public function getAllRadAcct();

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables();

    /**
     * Retrieve one radacct records where by 'radacctId'.
     * @param int $id RadAcct ID for query.
     */
    public function getRadAcctById($radAcctId);

    /**
     * Updates an existing blocked mac addresses using the provided request data.
     * @param object $request The data used to update the blocked mac addresses.
     * @return Model|mixed The updated blocked mac addresses.
     * @throws \Exception if an error occurs while updating the blocked mac addresses.
     */
    public function blockedMacAddresses($request);
}
