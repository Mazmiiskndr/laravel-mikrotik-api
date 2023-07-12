<?php

namespace App\Repositories\Report;

use App\Helpers\AccessControlHelper;
use App\Helpers\MikrotikConfigHelper;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\RadAcct;
use App\Services\Client\BypassMacs\BypassMacsService;
use App\Services\MikrotikApi\MikrotikApiService;
use App\Traits\DataTablesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ReportRepositoryImplement extends Eloquent implements ReportRepository
{
    use DataTablesTrait;
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $radAcctModel;
    protected $mikrotikApiService;
    protected $bypassMacsService;

    public function __construct(RadAcct $radAcctModel, MikrotikApiService $mikrotikApiService, BypassMacsService $bypassMacsService)
    {
        $this->radAcctModel = $radAcctModel;
        $this->mikrotikApiService = $mikrotikApiService;
        $this->bypassMacsService = $bypassMacsService;
    }

    /**
     * Retrieves get all list radacct records where 'acctstoptime' is NULL.
     * Also, includes the first usage time for each user.
     * @return array An array that contains rows of data and number of rows.
     */
    public function getAllRadAcct()
    {
        try {
            // Prepare the data.
            $responseData = [];

            // Fetch the data where 'acctstoptime' is NULL and 'starttime' is not NULL.
            $responseData['activeSessions'] = $this->radAcctModel->select([
                'radacctid',
                'username',
                'acctstarttime as starttime',
                'nasipaddress',
                'framedipaddress as ipaddress',
                'acctsessiontime',
                'callingstationid as macaddress'
            ])
                ->whereNull('acctstoptime')
                ->whereNotNull('acctstarttime')
                ->get()
                ->map(function ($item) {
                    $item->oltime = strtotime($item->starttime);
                    return $item;
                });

            // Count the number of rows where 'acctstoptime' is NULL and 'starttime' is not NULL.
            $responseData['activeSessionsCount'] = $this->radAcctModel->whereNull('acctstoptime')->whereNotNull('acctstarttime')->count();

            // Add the 'firsttime' to each row.
            foreach ($responseData['activeSessions'] as $session) {
                $session->firsttime = $this->getFirstUse($session->username);
            }

            // Return the result.
            return $responseData;
        } catch (\Exception $e) {
            // Log the error and return a message.
            Log::error("Error getting all radacct records: " . $e->getMessage());
            return [
                'error' => 'An error occurred while trying to fetch the records. Please try again.',
            ];
        }
    }

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables()
    {
        // Retrieve records from the database using getAllRadAcct function
        $data = $this->getAllRadAcct()['activeSessions'];

        // Format the data for DataTables
        return $this->formatDataTablesResponse(
            $data,
            [
                'firstuse' => function ($data) {
                    return $data->firsttime;
                },
                'sessionstart' => function ($data) {
                    return $data->starttime;
                },
                'onlinetime' => function ($data) {
                    return gmdate('j\d H:i:s', $data->oltime);
                },
                'ipaddress' => function ($data) {
                    return $data->ipaddress;
                },
                'macaddress' => function ($data) {
                    return $data->macaddress;
                },
            ]
        );

    }

    /**
     * Retrieve one radacct records where by 'radacctId'.
     * @param int $id RadAcct ID for query.
     */
    public function getRadAcctById($radAcctId)
    {
        try {
            // Prepare the data.
            $responseData = $this->radAcctModel->select([
                'radacctid',
                'username',
                'acctstarttime as starttime',
                'nasipaddress',
                'framedipaddress as ipaddress',
                'acctsessiontime',
                'callingstationid as macaddress'
            ])->find($radAcctId);

            // Return the result.
            return $responseData;
        } catch (\Exception $e) {
            // Log the error and return a message.
            Log::error("Error getting all radacct records: " . $e->getMessage());
            return [
                'error' => 'An error occurred while trying to fetch the records. Please try again.',
            ];
        }
    }

    /**
     * Updates an existing blocked mac addresses using the provided request data.
     * @param object $request The data used to update the blocked mac addresses.
     * @return Model|mixed The updated blocked mac addresses.
     * @throws \Exception if an error occurs while updating the blocked mac addresses.
     */
    public function blockedMacAddresses($request)
    {
        try {
            // Prepare the data to be updated.
            $radAcctData = $this->prepareRadAcctData($request);

            // Blocked the Mikrotik IP binding
            $mikrotikId = $this->createOrUpdateIpBinding($radAcctData['radacctid'], $radAcctData);
            $radAcctData['mikrotikId'] = $mikrotikId;
            $this->bypassMacsService->createOrUpdateBypassMac($radAcctData);

            return true;
        } catch (\Exception $e) {
            // Log the error message.
            Log::error("Failed to blocked mac addresses : " . $e->getMessage());
            // Rethrow the exception to be caught in the Livewire component.
            throw $e;
        }
    }

    // 👇 **** PRIVATE FUNCTIONS **** 👇
    /**
     * Prepares the data for updating blocked mac addresses.
     * created or updated an IP binding from the Mikrotik router.
     * @param object $request The data for blocked mac addresses.
     */
    private function prepareRadAcctData($request)
    {
        return [
            'radacctid' => $request->radacctid,
            'macAddress' => $request->macaddress,
            'status' => 'blocked',
            'server' => 'all',
            'description' => null,
        ];
    }

    /**
     * created or updated an IP binding from the Mikrotik router.
     * @param string $radAcctId The ID of the bypass mac.
     * @param array $request The ID of the Mikrotik IP binding.
     * @return bool Whether the deletion was successful.
     * @throws \Exception if an error occurs while deleting the IP binding.
     */
    private function createOrUpdateIpBinding($radAcctId, $request)
    {
        // Fetch and Validate Mikrotik Config
        $config = $this->fetchAndValidateMikrotikConfig();

        if ($config) {
            // Update the IP binding
            $ipBindingUpdated = $this->mikrotikApiService->createOrUpdateMikrotikIpBinding($config['ip'], $config['username'], $config['password'], $request);
            // If the IP binding deletion was not successful, throw an Exception.
            if (!$ipBindingUpdated) {
                throw new \Exception("Failed to update IP binding for bypass mac with ID $radAcctId");
            }

            return $ipBindingUpdated;
        }

        return false;
    }

    /**
     * Fetches Mikrotik configuration settings and validates them.
     * @throws \Exception if the Mikrotik configuration settings are invalid.
     * @return array An associative array containing Mikrotik configuration settings if they are valid.
     */
    private function fetchAndValidateMikrotikConfig()
    {
        // Retrieve the Mikrotik configuration settings.
        $config = MikrotikConfigHelper::getMikrotikConfig();

        // Check if the configuration exists and no values are empty.
        if (!$config || in_array("", $config, true)) {
            throw new \Exception("Invalid Mikrotik configuration settings.");
        }

        return $config;
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
}
