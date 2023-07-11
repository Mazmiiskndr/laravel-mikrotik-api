<?php

namespace App\Repositories\Client\BypassMacs;

use App\Helpers\ActionButtonsBuilder;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Mac;
use App\Traits\DataTablesTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BypassMacsRepositoryImplement extends Eloquent implements BypassMacsRepository{

    use DataTablesTrait;

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Mac $model)
    {
        $this->model = $model;
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
        try {
            // Prepare the query to select bypass macs and include their associated service
            $bypassMacsQuery = $this->model->select($columns);

            // Add the 'where' conditions if they exist
            if ($conditions) {
                $bypassMacsQuery = $bypassMacsQuery->where($conditions);
            }

            // Get the results and the count of rows
            $bypassMacsData['data'] = $bypassMacsQuery->latest()->get();
            $bypassMacsData['total'] = $bypassMacsQuery->count();

            return $bypassMacsData;
        } catch (Exception $e) {
            // Log the exception message and return an empty array
            Log::error("Error getting data bypass macs : " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * This function finds a bypass mac with id.
     * @param $bypassMacsId
     * @return mixed
     */
    public function getBypassMacsId($bypassMacsId)
    {
        try {
            return $this->model->find($bypassMacsId);
        } catch (Exception $e) {
            // Log the exception message and return an empty array
            Log::error("Error getting id bypass macs : " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Retrieves List Bypassed Macs records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableListBypassed()
    {
        // Retrieve records from the getBypassMacs function with status = 'bypassed'
        try {
            $data = $this->getBypassMacs(['status' => 'bypassed'],['id','mac_address','status','description','created_at'])['data'];
            $editPermission = 'edit_mac';
            $deletePermission = 'delete_mac';
            $onclickEdit = 'showMac';
            $onclickDelete = 'confirmDeleteMac';
            $editButton = 'button';

            // Format the data for DataTables
            return $this->formatDataTablesResponse(
                $data,
                [
                    'status' => function ($data) {
                        return ucwords($data->status);
                    },
                    'date' => function ($data) {
                        return date('Y-m-d H:i:s', strtotime($data->created_at));
                    },
                    'action' => function ($data) use ($editPermission, $deletePermission, $editButton, $onclickEdit, $onclickDelete) {
                        return $this->getActionButtons($data, $deletePermission, $editPermission, $editButton, $onclickEdit, $onclickDelete);
                    }
                ]
            );
        } catch (Exception $e) {
            // Log the exception and return a custom error message
            Log::error("Error: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while trying to process your request. Please try again later.'], 500);
        }
    }


    /**
     * Define validation rules for bypass macs creation.
     * @param string|null $id Bypass Macs ID for uniqueness checks. If not provided, a create operation is assumed.
     * @return array Array of validation rules
     */
    public function getRules($id = null)
    {
        // If id is not provided, we're creating a new bypass macs, else we're updating an existing bypass macs.
        $macAddressRule = 'required|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/|unique:macs,mac_address';
        if ($id !== null) {
            $macAddressRule .= ",$id,id";
        }

        return [
            'mikrotikId' => 'nullable|integer',
            'macAddress' => 'required|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'server' => 'required|string',
        ];
    }

    /**
     * Define validation messages for bypass mac creation.
     * @return array Array of validation messages
     */
    public function getMessages()
    {
        return [
            'mikrotikId.required'      => 'Mikrotik ID must be an integer!',
            'macAddress.required'      => 'Mac Address cannot be empty!',
            'macAddress.regex'         => 'MAC address format is invalid!',
            'macAddress.unique'        => 'MAC address already exists!',
            'status.required'          => 'Status cannot be empty!',
            'description.string'       => 'Description must be a string!',
            'server.required'          => 'Server cannot be empty!',
            'server.string'            => 'Server must be a string!',
        ];
    }

    /**
     * Stores a new bypass mac using the provided request data.
     * @param array $request The data used to create the new bypass mac.
     * @return Model|mixed The newly created bypass mac.
     * @throws \Exception if an error occurs while creating the bypass mac.
     */
    public function storeNewBypassMac($request)
    {
        // Start a new database transaction.
        DB::beginTransaction();

        try {
            // Create new bypass mac entries
            $bypassMac = $this->createOrUpdateBypassMac($request);

            // Commit the transaction (apply the changes).
            DB::commit();

            return $bypassMac;
        } catch (\Exception $e) {
            // If an exception occurred during the create process, rollback the transaction.
            DB::rollBack();

            // Log the error message.
            Log::error("Failed to store new bypass mac : " . $e->getMessage());

            // Rethrow the exception to be caught in the Livewire component.
            throw $e;
        }
    }

    // 👇 **** PRIVATE FUNCTIONS **** 👇

    /**
     * Creates or updates a bypass mac using the provided data.
     * @param array $request The data used to create or update the bypass mac.
     * @return Model|mixed The newly created or updated bypass mac.
     */
    private function createOrUpdateBypassMac($request)
    {
        if(isset($request['id'])){
            $data['id'] = $request['id'];
        }
        $data['mac_address'] = $request['macAddress'];
        $data['status'] = $request['status'];
        $data['description'] = $request['description'];
        $data['server'] = $request['server'];
        $data['mikrotik_id'] = $request['mikrotikId'];

        // If the id is set in the data, update the existing entry
        if (isset($data['id'])) {
            $bypassMac = $this->model->find($data['id']);
            $bypassMac->update($data);
        } else {
            // Else, create a new entry
            $bypassMac = $this->model->create($data);
        }

        return $bypassMac;
    }

    /**
     * Generate action buttons for the DataTables row.
     * @param $data
     * @param $deletePermission
     * @param $editPermission
     * @param $editButton
     * @param $onclickEdit
     * @param $onclickDelete
     * @return string HTML string for the action buttons
     */
    private function getActionButtons($data, $deletePermission, $editPermission, $editButton, $onclickEdit, $onclickDelete)
    {
        return (new ActionButtonsBuilder())
            ->setEditPermission($editPermission)
            ->setDeletePermission($deletePermission)
            ->setOnclickDelete($onclickDelete)
            ->setOnclickEdit($onclickEdit)
            ->setType($editButton)
            ->setIdentity($data->id)
            ->build();
    }
}
