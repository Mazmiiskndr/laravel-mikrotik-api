<?php

namespace App\Repositories\Client\BypassMacs;

use App\Helpers\ActionButtonsBuilder;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Mac;
use App\Traits\DataTablesTrait;
use Exception;
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

    // 👇 **** PRIVATE FUNCTIONS **** 👇

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
