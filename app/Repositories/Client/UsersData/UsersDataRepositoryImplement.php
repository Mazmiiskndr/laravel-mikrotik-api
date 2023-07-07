<?php

namespace App\Repositories\Client\UsersData;

use App\Helpers\ActionButtonsBuilder;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\UserData;
use App\Traits\DataTablesTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class UsersDataRepositoryImplement extends Eloquent implements UsersDataRepository{

    use DataTablesTrait;
    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(UserData $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve users data records and associated service names.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $conditions
     * @param array|null $columns
     * @param array|null $dateRange
     * @return array
     */
    public function getUsersData($conditions = null, $columns = ['*'], $dateRange = [])
    {
        try {
            // Prepare the query to select users data and include their associated service
            $usersQuery = $this->model->select($columns);

            // Add the 'where' conditions if they exist
            if ($conditions) {
                $usersQuery = $usersQuery->where($conditions);
            }

            // Add date range filter if exists
            if ($dateRange != null) {
                $fromDate = $dateRange['from_date'] ?? null;
                $toDate = $dateRange['to_date'] ?? null;

                if ($fromDate && $toDate) {
                    $usersQuery = $usersQuery->whereBetween('date', [$fromDate, $toDate]);
                }
            }

            // Get the results and the count of rows
            $usersData['data'] = $usersQuery->latest()->get();
            $usersData['total'] = $usersQuery->count();

            return $usersData;
        } catch (Exception $e) {
            // Log the exception message and return an empty array
            Log::error("Error getting users data : " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Retrieve userData by id.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $id
     * @return array
     */
    public function getUserDataById($id)
    {
        try {
            // Prepare the query to select userDatas and join with services
            $userDataQuery = $this->model->where('id', $id)->first();

            return $userDataQuery;
        } catch (Exception $e) {
            // Log the exception message and return an empty array
            Log::error("Error getting data users by id : " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables($fromDate = null, $toDate = null)
    {
        // Prepare the dateRange array for the getUsersData method
        $dateRange = ($fromDate !== null && $toDate !== null) ? ['from_date' => $fromDate, 'to_date' => $toDate] : null;
        // Retrieve records from the database using the model, including the related 'users-data' records, and sort by the latest records
        $uersData = $this->getUsersData(null, ['id', 'date', 'name', 'email', 'room_number'], $dateRange);
        $data = $uersData['data'];

        $deletePermission = 'delete_users_data';
        $onclickEdit = 'showUsers';
        $onclickDelete = 'confirmDeleteUsersData';
        $editButton = 'button';

        // Format the data for DataTables
        return $this->formatDataTablesResponse(
            $data,
            [
                'date' => function ($data) {
                    return date('Y-F-d', strtotime($data->date));
                },
                'action' => function ($data) use ($deletePermission, $editButton, $onclickEdit, $onclickDelete) {
                    return $this->getActionButtons($data, $deletePermission, $editButton, $onclickEdit, $onclickDelete);
                }
            ]
        );
    }


    /**
     * Delete users data data from tables based on the users data ID.
     * @param string $id The ID of the users data to delete.
     * @throws \Exception if an error occurs while deleting the users data.
     */
    public function deleteUsersData($id)
    {
        try {
            // Retrieve the users data from the database.
            $usersData = $this->model->where('id', $id)->first();

            // If the users data exists, delete its associated data from all related tables.
            if ($usersData !== null) {
                // Delete data from the 'users-data' table.
                $usersData->delete();
            } else {
                throw new \Exception("Users Data with ID $id not found.");
            }
        } catch (\Exception $e) {
            // If an exception occurred during the deletion process, log the error message.
            Log::error("Failed to delete users data data : " . $e->getMessage());
            // Rethrow the exception to be caught in the Livewire component.
            throw $e;
        }
    }

    // 👇 **** PRIVATE FUNCTIONS **** 👇

    /**
     * Generate action buttons for the DataTables row.
     * @param $data
     * @param $deletePermission
     * @param $editButton
     * @param $onclickEdit
     * @param $onclickDelete
     * @return string HTML string for the action buttons
     */
    private function getActionButtons($data, $deletePermission, $editButton, $onclickEdit, $onclickDelete)
    {
        return (new ActionButtonsBuilder())
            ->setDeletePermission($deletePermission)
            ->setOnclickDelete($onclickDelete)
            ->setOnclickEdit($onclickEdit)
            ->setType($editButton)
            ->setIdentity($data->id)
            ->build();
    }
}
