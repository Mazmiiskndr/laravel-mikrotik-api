<?php

namespace App\Services\Client\Voucher;

use LaravelEasyRepository\BaseService;

interface VoucherService extends BaseService{

    /**
     * Retrieve Voucher records and associated service names.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $conditions
     * @param array|null $columns
     * @return array
     */
    public function getVoucherBatchesWithService($conditions, $columns);

    /**
     * Retrieve Voucher records based on voucher_batches_id
     * @param int $voucherBatchesId
     * @return Collection
     */
    public function getVouchersByBatchId($voucherBatchesId);

    /**
     * This function finds a voucher batch with its associated service.
     * @param $voucherBatchId
     * @return mixed
     */
    public function getVoucherBatchIdWithService($voucherBatchId);

    /**
     * Retrieves voucher batch records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableVoucherBatches();

    /**
     * Retrieves active voucher records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableActiveVouchers();

    /**
     * Retrieves Detail Voucher Batch records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableDetailVoucherBatch($voucherBatchesId);

    /**
     * Stores a new voucher batch using the provided request data.
     * @param array $request The data used to create the new voucher batch.
     * @return Model|mixed The newly created voucher batch.
     * @throws \Exception if an error occurs while creating the voucher batch.
     */
    public function storeNewVoucherBatch($request);

    /**
     * Deletes a voucher batch and its associated vouchers.
     * @param int $voucherBatchId The id of the voucher batch to delete.
     * @return void
     * @throws \Exception if an error occurs while deleting the voucher batch or its associated vouchers.
     */
    public function deleteVoucherBatch($voucherBatchId);

    /**
     * Format time for display based on the limit and unit.
     * @param int|string $limit The time limit.
     * @param string $unit The unit of time (e.g., "hours", "minutes").
     * @return string The formatted time for display.
     */
    public function formatTimeDisplay($limit, $unit);

    /**
     * Creates a new log entry with the given parameters.
     * @param int $voucherBatchId The ID of the voucher batch.
     * @param int $idService The ID of the service.
     * @param int $quantity The quantity of vouchers.
     * @param string $action The action of vouchers.
     * @return object The created log entry.
     */
    public function createLog($voucherBatchId, $idService, $quantity, $action);
}
