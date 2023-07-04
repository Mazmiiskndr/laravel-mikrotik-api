<?php

namespace App\Repositories\Client\Voucher;

use App\Helpers\AccessControlHelper;
use App\Models\RadAcct;
use App\Models\RadCheck;
use App\Models\RadUserGroup;
use App\Models\Services;
use App\Models\Setting;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Voucher;
use App\Models\VoucherBatches;
use App\Services\Client\ClientService;
use App\Services\ServiceMegalos\ServiceMegalosService;
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
    protected $serviceMegalosService;
    protected $radAcctModel;
    protected $radCheckModel;
    protected $radUserGroupModel;
    protected $serviceModel;
    protected $clientService;

    public function __construct(
        Voucher $model,
        VoucherBatches $voucherBatchesModel,
        Setting $settingModel,
        ServiceMegalosService $serviceMegalosService,
        RadAcct $radAcctModel,
        RadCheck $radCheckModel,
        RadUserGroup $radUserGroupModel,
        Services $serviceModel,
        ClientService $clientService
    ) {
        $this->model = $model;
        $this->voucherBatchesModel = $voucherBatchesModel;
        $this->settingModel = $settingModel;
        $this->serviceMegalosService = $serviceMegalosService;
        $this->radAcctModel = $radAcctModel;
        $this->radCheckModel = $radCheckModel;
        $this->radUserGroupModel = $radUserGroupModel;
        $this->serviceModel = $serviceModel;
        $this->clientService = $clientService;
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
            $voucherBathesQuery = $this->voucherBatchesModel->select($columns)->with('service:id,service_name');

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
     * This function finds a voucher batch with its associated service.
     * @param $voucherBatchId
     * @return mixed
     */
    public function getVoucherBatchIdWithService($voucherBatchId)
    {
        return $this->voucherBatchesModel
            ->select('*')
            ->with('service:id,service_name,time_limit_type,time_limit,unit_time')
            ->where('id', $voucherBatchId)
            ->first();
    }

    /**
     * Retrieve Voucher records based on voucher_batches_id
     * @param int $voucherBatchesId
     * @return Collection
     */
    public function getVouchersByBatchId($voucherBatchesId)
    {
        try {
            return $this->model->with('voucherBatch.service:id,service_name,time_limit_type')
            ->where('voucher_batch_id', $voucherBatchesId)
            ->orderBy('serial_number','desc')->get();
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
        // Update voucher status to expired if the voucher batch is expired
        $this->updateVoucherStatusByVoucherBatchId($voucherBatchesId);
        // Retrieve records from the getClientWithService function
        $data = $this->getVouchersByBatchId($voucherBatchesId);


        // Initialize DataTables and add columns to the table
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('password', function ($data) {
                return ($data->voucherBatch->type == "with_password") ? $data->password : null;
            })
            ->addColumn('first_use', function ($data) {
                return ($data->voucherBatch->service->time_limit_type== "one_time_continuous") ? $this->getFirstUse($data->username) : $this->getTotalTimeUsed($data->username);
            })
            ->addColumn('valid_until', function ($data) {
                return ($data->valid_until == 0) ? '-' : date('Y-m-d H:i:s', $data->valid_until);
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
            $this->createVouchers($request['quantity'], $request['charactersLength'], $request['idService'], $voucherBatch->id, $voucherType);

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
            $vouchers = $voucherBatch->vouchers;

            foreach ($vouchers as $voucher) {
                $username = $voucher->username;

                // Delete related data from radacct, radcheck and radusergroup
                $this->deleteRelatedData($username);

                // Delete the voucher
                $voucher->delete();
            }

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
     * Format time for display based on the limit and unit.
     * @param int|string $limit The time limit.
     * @param string $unit The unit of time (e.g., "hours", "minutes").
     * @return string The formatted time for display.
     */
    public function formatTimeDisplay($limit, $unit)
    {
        if ((int)$limit == 1) {
            $unit = rtrim($unit, "s");
        }
        return $limit . ' ' . $unit;
    }

    // ***** 👇 PRIVATE FUNCTIONS 👇 *****

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
     * Creates a set of vouchers.
     * @param int $quantity The number of vouchers to create.
     * @param int $characterLength The length of the voucher username and password.
     * @param int $idService The id of the service the vouchers belong to.
     * @param int $voucherBatchId The id of the batch the vouchers belong to.
     * @param object $voucherType The type of the voucher.
     * @throws \Exception if voucher creation fails.
     */
    private function createVouchers($quantity, $characterLength, $idService, $voucherBatchId, $voucherType)
    {
        try {
            // Start a new database transaction
            DB::transaction(function () use ($quantity, $characterLength, $idService, $voucherBatchId, $voucherType) {
                // Loop over the quantity to generate each voucher
                for ($i = 0; $i < $quantity; $i++) {
                    // Generate a unique username.
                    // Keep generating until a unique username is found.
                    do {
                        $username = str()->random($characterLength);
                    } while (
                        $this->model->where('username', $username)->exists() ||
                        $this->radUserGroupModel->where('username', $username)->exists()
                    );

                    // Generate a password. If voucher type is 'no_password', use the username as the password.
                    $password = $voucherType->value === 'no_password' ? $username : str()->random($characterLength);

                    // Create a new voucher with the generated username, password and other given parameters.
                    $voucher = $this->model->create([
                        'voucher_batch_id' => $voucherBatchId,
                        'username'         => $username,
                        'password'         => $password,
                        'valid_until'      => 0,
                        'first_use'        => 0,
                        'status'           => 'active',
                        'clean_up'         => 0,
                    ]);

                    // Create a new entry in radCheck, Radacctm RadUserGroup table for this voucher.
                    $this->createRadCheck($username, $password);
                    $this->clientService->createRadAcct($username);
                    $this->createRadUserGroup($idService, $username, $voucher->id);
                }
            });
        } catch (\Exception $e) {
            // If any exception occurs during the process, throw a new exception with the error message.
            throw new \Exception('Failed to create vouchers: ' . $e->getMessage());
        }
    }

    /**
     * This method creates or updates entries in the radCheck table.
     * @param string $username The username of the voucher.
     * @param string $password The password of the voucher.
     */
    private function createRadCheck($username, $password)
    {
        // For each attribute, we will first check if an entry exists, and if it does, update it, otherwise create a new entry.
        $attributes = [
            'Cleartext-Password' => $password,
            'Simultaneous-Use' => 1,
        ];

        foreach ($attributes as $attribute => $value) {
            if ($value !== null) {
                $entry = $this->radCheckModel->where([
                    'username' => $username,
                    'attribute' => $attribute,
                ])->first();

                $data = [
                    'username' => $username,
                    'attribute' => $attribute,
                    'op' => $attribute == 'ValidFrom' ? '>=' : ':=',
                    'value' => $value,
                ];

                if ($entry) {
                    $entry->update($data);
                } else {
                    $this->radCheckModel->create($data);
                }
            }
        }
    }

    /**
     * This method creates entries in the radUserGroup table.
     * @param int $idService The id of the service the vouchers belong to.
     * @param string $username The username of the voucher.
     * @param int $voucherId The id of the voucher.
     */
    private function createRadUserGroup($idService, $username, $voucherId)
    {
        // Fetch the service_name for this client
        $service = $this->serviceModel->find($idService);

        // Create an entry in the 'radusergroup' table
        $this->radUserGroupModel->create([
            'username' => $username,
            'groupname' => $service->service_name ?? '',
            'priority' => 1,
            'user_type' => 'voucher',
            'voucher_id' => $voucherId,
        ]);
    }

    /**
     * Deletes the related data from the radacct, radcheck, and radusergroup models.
     * @param string $username The username of the voucher.
     * @return void
     */
    private function deleteRelatedData($username)
    {
        // Delete related data from radacct
        $this->radAcctModel->where('username', $username)->delete();

        // Delete related data from radcheck
        $this->radCheckModel->where('username', $username)->delete();

        // Delete related data from radusergroup
        $this->radUserGroupModel->where('username', $username)->delete();
    }

    /**
     * This function updates the status of vouchers related to a specific voucher batch.
     * @param  int  $voucherBatchId
     * @return bool
     */
    public function updateVoucherStatusByVoucherBatchId($voucherBatchId)
    {
        try {
            $voucherBatch = $this->getVoucherBatchIdWithService($voucherBatchId);

            if (!$voucherBatch) {
                return false;
            }

            $vouchers = $this->findActiveVouchersForBatch($voucherBatchId);

            if ($vouchers->isEmpty()) {
                return true;
            }

            $quota = $this->calculateServiceQuota($voucherBatch->service);

            $this->updateVoucherStatuses($vouchers, $quota);

            return true;
        } catch (\Exception $e) {
            // Log the exception or handle it as required
            Log::error('Error updating voucher statuses: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * This function finds all active vouchers for a specific batch.
     * @param $voucherBatchId
     * @return mixed
     */
    private function findActiveVouchersForBatch($voucherBatchId)
    {
        return $this->model
            ->with('voucherBatch.service')
            ->where('status', 'active')
            ->where('voucher_batch_id', $voucherBatchId)
            ->latest()
            ->get();
    }

    /**
     * This function calculates the service quota based on the service time limit and unit time.
     *
     * @param $service
     * @return mixed
     */
    private function calculateServiceQuota($service)
    {
        return $service->time_limit * $this->serviceMegalosService->timeToInt($service->unit_time);
    }

    /**
     * This function updates the statuses of a collection of vouchers based on their quota.
     * @param $vouchers
     * @param $quota
     */
    private function updateVoucherStatuses($vouchers, $quota)
    {
        foreach ($vouchers as $voucher) {
            $this->updateVoucherStatus($voucher, $quota);
        }
    }

    /**
     * This function updates the status of a single voucher based on its quota.
     * @param $voucher
     * @param $quota
     */
    private function updateVoucherStatus($voucher, $quota)
    {
        if ($this->isVoucherExpired($voucher)) {
            $this->changeStatusVoucher($voucher->id, "expired");
            return;
        }

        if ($this->hasVoucherReachedQuota($voucher, $quota)) {
            $this->changeStatusVoucher($voucher->id, "quota reached");
        }
    }

    /**
     * This function checks if a voucher is expired.
     * @param $voucher
     * @return bool
     */
    private function isVoucherExpired($voucher)
    {
        return !empty($voucher->valid_until) && time() >= $voucher->valid_until;
    }

    /**
     * This function checks if a voucher has reached its quota.
     * @param $voucher
     * @param $quota
     * @return bool
     */
    private function hasVoucherReachedQuota($voucher, $quota)
    {
        $actualUse = $this->calculateVoucherActualUse($voucher);

        // If the actual use is null, return false
        if (is_null($actualUse)) {
            return false;
        }

        // Compare actual use with the quota
        return $actualUse >= $quota;
    }

    /**
     * This function calculates the actual use of a voucher.
     * @param $voucher
     * @return int|mixed
     */
    private function calculateVoucherActualUse($voucher)
    {
        if ($voucher->voucherBatch->service->time_limit_type == "none") {
            return null;
        }

        if ($voucher->voucherBatch->service->time_limit_type == "one_time_gradually") {
            return $this->getTotalTimeUsed($voucher->username);
        }

        if ($voucher->voucherBatch->service->time_limit_type == "one_time_continuous") {
            return !empty($voucher->first_use) ? time() - $voucher->first_use : 0;
        }
    }

    /**
     * This function changes the status of a voucher.
     * @param $id
     * @param $status
     */
    private function changeStatusVoucher($id, $status)
    {
        $voucher = $this->model->findOrFail($id);
        $voucher->status = $status;
        $voucher->save();
    }

    /**
     * Fetches the first 'acctstarttime' for a given username where 'acctstarttime' is not NULL.
     * @param string $username The username for which the first usage time is to be fetched.
     * @return string|bool The first usage time if it exists, otherwise false.
     */
    private function getFirstUse($username)
    {
        try {
            // Fetch the first 'acctstarttime' for the given username where 'acctstarttime' is not NULL.
            $query = $this->radAcctModel->select('acctstarttime as firsttime')
                ->where('username', $username)
                ->whereNotNull('acctstarttime')
                ->orderBy('acctstarttime')
                ->first();

            // Check if 'firsttime' exists and return it. Otherwise, return false.
            return !empty($query->firsttime) ? $query->firsttime : false;
        } catch (\Exception $e) {
            // Log the error.
            Log::error("Error fetching the first usage time for username {$username}: " . $e->getMessage());

            // In the event of an error, return false.
            return false;
        }
    }

    /**
     * This function gets the total time used by a user.
     * @param $username
     * @return int
     */
    private function getTotalTimeUsed($username)
    {
        $totalSessionTime = $this->radAcctModel
            ->where('username', $username)
            ->sum('acctsessiontime');
        return ($totalSessionTime !== 0 || !empty($totalSessionTime)) ? $totalSessionTime : "-";
    }

}
