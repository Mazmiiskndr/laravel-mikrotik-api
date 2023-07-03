<?php

namespace App\Repositories\Client\Voucher;

use App\Helpers\AccessControlHelper;
use App\Models\Setting;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Voucher;
use App\Models\VoucherBatches;
use Exception;
use Illuminate\Support\Facades\DB;
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
    protected $settingModel;

    public function __construct(Voucher $model,VoucherBatches $voucherBatchesModel, Setting $settingModel)
    {
        $this->model = $model;
        $this->voucherBatchesModel = $voucherBatchesModel;
        $this->settingModel = $settingModel;
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
     * Retrieve Voucher records based on voucher_batches_id
     * @param int $voucherBatchesId
     * @return Collection
     */
    public function getVouchersByBatchId($voucherBatchesId)
    {
        try {
            return $this->model->where('voucher_batch_id', $voucherBatchesId)->get();
        } catch (Exception $e) {
            // Log the exception message and return an empty collection
            Log::error("Error getting vouchers by batch id : " . $e->getMessage());
            return collect();
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

                $detailButton = '<a href="' . route('backend.clients.voucher.voucher-batch-detail', $data->id) . '" name="detail" class="detail btn btn-info btn-sm"> <i class="fas fa-eye"></i></a>';

                // Check if the current client is allowed to delete
                if (AccessControlHelper::isAllowedToPerformAction('delete_voucher_batch')) {
                    // If client is allowed, show delete button
                    $deleteButton = '&nbsp;&nbsp;<button type="button" class="delete btn btn-danger btn-sm" onclick="confirmDeleteVoucherBatch(\'' . $data->id . '\')"> <i class="fas fa-trash"></i></button>';
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
                return ($data->valid_until == 0) ? '-' : $data->valid_until;
            })
            ->addColumn('created_by', function ($data) {
                return $data->voucherBatch->created_by;
            })
            ->addColumn('service_name', function ($data) {
                return $data->voucherBatch->service->service_name;
            })
            ->addColumn('voucher_batch_id', function ($data) {
                $detailButton = '';
                $detailButton = '<a href="' . route('backend.clients.voucher.voucher-batch-detail', $data->voucherBatch->id) . '" name="detail" class="detail btn btn-info btn-sm"> <i class="fas fa-eye"></i>&nbsp; Detail</a>';

                return $detailButton;
            })
            ->rawColumns(['voucher_batch_id'])
            ->make(true);
    }

    /**
     * Retrieves Detail Voucher Batch records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableDetailVoucherBatch($voucherBatchesId)
    {
        // Retrieve records from the getClientWithService function
        $data = $this->getVouchersByBatchId($voucherBatchesId);

        // Initialize DataTables and add columns to the table
        return DataTables::of($data)
            ->addIndexColumn()
            // TODO: FOR TOTAL TIME USED
            ->addColumn('first_use', function ($data) {
                return ($data->first_use == 0) ? '-' : $data->first_use;
            })
            ->addColumn('valid_until', function ($data) {
                return ($data->valid_until == 0) ? '-' : $data->valid_until;
            })
            ->addColumn('status', function ($data) {
                return ucfirst($data->status);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Stores a new voucher batch using the provided request data.
     * @param array $request The data used to create the new voucher batch.
     * @return Model|mixed The newly created voucher batch.
     * @throws \Exception if an error occurs while creating the voucher batch.
     */
    public function storeNewVoucherBatch($request)
    {
        // Start a new database transaction.
        DB::beginTransaction();

        try {
            $voucherType = $this->settingModel->whereIn('setting', ['create_vouchers_type'])->first();
            // Create a new voucher batch
            $voucherBatch = $this->createVoucherBatch($request, $voucherType);

            // Generate vouchers for the voucher batch
            $this->createVouchers($request['quantity'], $request['charactersLength'], $voucherBatch->id, $voucherType);

            // Commit the transaction
            DB::commit();

            return $voucherBatch;
        } catch (\Exception $e) {
            // If an exception occurred during the process, rollback the transaction.
            DB::rollBack();

            // Log the error message.
            Log::error("Failed to store new voucher batch : " . $e->getMessage());

            // Rethrow the exception to be caught in the Livewire component.
            throw $e;
        }
    }

    /**
     * Deletes a voucher batch and its associated vouchers.
     * @param int $voucherBatchId The id of the voucher batch to delete.
     * @return void
     * @throws \Exception if an error occurs while deleting the voucher batch or its associated vouchers.
     */
    public function deleteVoucherBatch($voucherBatchId)
    {
        // Start a new database transaction.
        DB::beginTransaction();

        try {
            // Fetch the voucher batch
            $voucherBatch = $this->voucherBatchesModel->findOrFail($voucherBatchId);

            // Delete all vouchers associated with the voucher batch
            $voucherBatch->vouchers()->delete();

            // Delete the voucher batch itself
            $voucherBatch->delete();

            // Commit the transaction
            DB::commit();
            return true;
        } catch (\Exception $e) {
            // If an exception occurred during the process, rollback the transaction.
            DB::rollBack();

            // Log the error message.
            Log::error("Failed to delete voucher batch : " . $e->getMessage());

            // Rethrow the exception to be caught elsewhere.
            throw $e;
        }
    }


    /**
     * Creates a new voucher batch.
     * @param array $data The data used to create the new voucher batch.
     * @param object $voucherType The data used to create the new voucher batch.
     * @return Model|mixed The newly created voucher batch.
     * @throws \Exception if an error occurs while creating the voucher batch.
     */
    private function createVoucherBatch($data, $voucherType)
    {
        try {
            // Create a new voucher batch and return it
            return $this->voucherBatchesModel->create([
                'service_id'        => $data['idService'],
                'quantity'          => $data['quantity'],
                'created'           => strtotime(date('Y-m-d H:i:s')),
                'created_by'        => session('username'),
                'type'              => $voucherType->value,
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create voucher batch: ' . $e->getMessage());
        }
    }

    /**
     * Creates vouchers for a voucher batch.
     * @param int $quantity The number of vouchers to generate.
     * @param int $characterLength The length of the username and password.
     * @param int $voucherBatchId The id of the voucher batch.
     * @param object $voucherType The data used to create the new voucher batch.
     * @return void
     * @throws \Exception if an error occurs while creating the vouchers.
     */
    private function createVouchers($quantity, $characterLength, $voucherBatchId, $voucherType)
    {
        try {
            for ($i = 0; $i < $quantity; $i++) {
                $username = str()->random($characterLength);
                $password = $voucherType->value === 'no_password' ? $username : str()->random($characterLength);

                $this->model->create([
                    'voucher_batch_id' => $voucherBatchId,
                    'username'         => $username,
                    'password'         => $password,
                    'valid_until'      => 0,
                    'first_use'        => 0,
                    'status'           => 'active',
                    'clean_up'         => 0,
                ]);
            }
        } catch (\Exception $e) {
            throw new \Exception('Failed to create vouchers: ' . $e->getMessage());
        }
    }


}
