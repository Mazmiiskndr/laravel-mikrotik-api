<?php

namespace App\Services\Client\Voucher;

use LaravelEasyRepository\Service;
use App\Repositories\Client\Voucher\VoucherRepository;
use Exception;

class VoucherServiceImplement extends Service implements VoucherService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(VoucherRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Handles the method call to the repository and manages exceptions.
     * @param string $method The method to call.
     * @param array $parameters The parameters to pass to the method.
     * @throws Exception If there is an error when calling the method.
     * @return mixed The result of the method call.
     */
    private function handleRepositoryCall(string $method, array $parameters = [])
    {
        try {
            return $this->mainRepository->{$method}(...$parameters);
        } catch (Exception $exception) {
            $errorMessage = "Error when calling $method: " . $exception->getMessage();
            throw new Exception($errorMessage);
        }
    }

    /**
     * Retrieve Voucher records and associated service names.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $conditions
     * @param array|null $columns
     * @return array
     */
    public function getVoucherBatchesWithService($conditions = null, $columns = ['*'])
    {
        return $this->handleRepositoryCall('getVoucherBatchesWithService', [$conditions, $columns]);
    }

    /**
     * This function finds a voucher batch with its associated service.
     * @param $voucherBatchId
     * @return mixed
     */
    public function getVoucherBatchIdWithService($voucherBatchId)
    {
        return $this->handleRepositoryCall('getVoucherBatchIdWithService', [$voucherBatchId]);
    }

    /**
     * Retrieve Voucher records based on voucher_batches_id
     * @param int $voucherBatchesId
     * @return Collection
     */
    public function getVouchersByBatchId($voucherBatchesId)
    {
        return $this->handleRepositoryCall('getVouchersByBatchId', [$voucherBatchesId]);
    }

    /**
     * Retrieves voucher batch records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableVoucherBatches()
    {
        return $this->handleRepositoryCall('getDatatableVoucherBatches');
    }

    /**
     * Retrieves active voucher records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableActiveVouchers()
    {
        return $this->handleRepositoryCall('getDatatableActiveVouchers');
    }

    /**
     * Retrieves Detail Voucher Batch records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableDetailVoucherBatch($voucherBatchesId)
    {
        return $this->handleRepositoryCall('getDatatableDetailVoucherBatch', [$voucherBatchesId]);
    }

    /**
     * Stores a new voucher batch using the provided request data.
     * @param array $request The data used to create the new voucher batch.
     * @return Model|mixed The newly created voucher batch.
     * @throws \Exception if an error occurs while creating the voucher batch.
     */
    public function storeNewVoucherBatch($request)
    {
        return $this->handleRepositoryCall('storeNewVoucherBatch', [$request]);
    }

    /**
     * Deletes a voucher batch and its associated vouchers.
     * @param int $voucherBatchId The id of the voucher batch to delete.
     * @return void
     * @throws \Exception if an error occurs while deleting the voucher batch or its associated vouchers.
     */
    public function deleteVoucherBatch($voucherBatchId)
    {
        return $this->handleRepositoryCall('deleteVoucherBatch', [$voucherBatchId]);
    }
}
