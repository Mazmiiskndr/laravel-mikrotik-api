<?php

namespace App\Repositories\Client\Voucher;

use App\Helpers\AccessControlHelper;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Voucher;
use App\Models\VoucherBatches;
use Exception;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class VoucherRepositoryImplement extends Eloquent implements VoucherRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;
    protected $voucherBatchesModel;

    public function __construct(Voucher $model,VoucherBatches $voucherBatchesModel)
    {
        $this->model = $model;
        $this->voucherBatchesModel = $voucherBatchesModel;
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
        try {
            // Prepare the query to select voucher batches and include their associated service
            $voucherBathesQuery = $this->voucherBatchesModel->select($columns)->with(['service' => function ($query) {
                $query->select('id', 'service_name'); // Assuming 'id' is the primary key of 'services'
            }]);

            // Add the 'where' conditions if they exist
            if ($conditions) {
                $voucherBathesQuery = $voucherBathesQuery->where($conditions);
            }

            // Get the results and the count of rows
            $voucherBathesData['data'] = $voucherBathesQuery->latest()->get();
            $voucherBathesData['total'] = $voucherBathesQuery->count();

            return $voucherBathesData;
        } catch (Exception $e) {
            // Log the exception message and return an empty array
            Log::error("Error getting data voucher batches : " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Retrieves Voucher Batches records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableVoucherBatches()
    {
        // Retrieve records from the getClientWithService function
        $voucherBathesData = $this->getVoucherBatchesWithService();
        $data = $voucherBathesData['data'];

        // Initialize DataTables and add columns to the table
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('create_date', function ($data) {
                return date('d F Y H:i', $data->created);
            })
            ->addColumn('service_name', function ($data) {
                return $data->service->service_name;
            })
            ->addColumn('action', function ($data) {
                $detailButton = '';
                $deleteButton = '';

                $detailButton = '<button type="button" name="detail" class="detail btn btn-info btn-sm"> <i class="fas fa-eye"></i></button>';

                // Check if the current client is allowed to delete
                if (AccessControlHelper::isAllowedToPerformAction('delete_voucher_batch')) {
                    // If client is allowed, show delete button
                    $deleteButton = '&nbsp;&nbsp;<button type="button" class="delete btn btn-danger btn-sm" onclick="confirmDeleteVoucherBatch(\'' . $data->voucher_batches_uid . '\')"> <i class="fas fa-trash"></i></button>';
                }

                return $detailButton . $deleteButton;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Retrieves Active Vouchers records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableActiveVouchers()
    {
        $data = $this->model->with('voucherBatch.service')
        ->where('status', 'active')
        ->latest()
        ->get();

        // Initialize DataTables and add columns to the table
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('create_date', function ($data) {
                return date('d F Y H:i', $data->voucherBatch->created);
            })
            ->addColumn('valid_until', function ($data) {
                return ($data->valid_until == 0) ? $data->valid_until : '-';
            })
            ->addColumn('created_by', function ($data) {
                return $data->voucherBatch->created_by;
            })
            ->addColumn('service_name', function ($data) {
                return $data->voucherBatch->service->service_name;
            })
            ->addColumn('voucher_batch_id', function ($data) {
                $detailButton = '';
                // TODO: CREATE DETAIL VOUCHER BATCHES
                $detailButton = '<button type="button" name="detail" class="detail btn btn-info btn-sm"> <i class="fas fa-eye"></i>&nbsp; Detail</button>';

                return $detailButton;
            })
            ->rawColumns(['voucher_batch_id'])
            ->make(true);
    }
}
