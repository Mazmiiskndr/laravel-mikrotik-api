<?php

namespace App\Repositories\Client\HotelRoom;

use App\Helpers\ActionButtonsBuilder;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\HotelRoom;
use App\Traits\DataTablesTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class HotelRoomRepositoryImplement extends Eloquent implements HotelRoomRepository{

    use DataTablesTrait;
    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(HotelRoom $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve Hotel Rooms records and associated service names.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $conditions
     * @param array|null $columns
     * @return array
     */
    public function getHotelRoomsWithService($conditions = null, $columns = ['*'])
    {
        try {
            // Prepare the query to select hotel rooms and include their associated service
            $hotelRoomsQuery = $this->model->select($columns)->with('service:id,service_name');

            // Add the 'where' conditions if they exist
            if ($conditions) {
                $hotelRoomsQuery = $hotelRoomsQuery->where($conditions);
            }

            // Get the results and the count of rows
            $hotelRoomsData['data'] = $hotelRoomsQuery->latest()->get();
            $hotelRoomsData['total'] = $hotelRoomsQuery->count();

            return $hotelRoomsData;
        } catch (Exception $e) {
            // Log the exception message and return an empty array
            Log::error("Error getting data hotel rooms : " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * This function finds a hotel room with its associated service.
     * @param $hotelRoomId
     * @return mixed
     */
    public function getHotelRoomIdWithService($hotelRoomId)
    {
        return $this->model->select('*')
            ->with('service:id,service_name,time_limit_type,time_limit,unit_time')
            ->where('id', $hotelRoomId)
            ->first();
    }

    /**
     * Retrieves Hotel Rooms records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableHotelRooms()
    {
        // Retrieve records from the getClientWithService function
        $data = $this->getHotelRoomsWithService()['data'];
        $editPermission = 'edit_hotel_room';
        $onclickEdit = 'showHotelRoom';
        $onclickDelete = 'confirmDeleteHotelRoom';
        $editButton = 'button';

        // Format the data for DataTables
        return $this->formatDataTablesResponse(
            $data,
            [
                'service_name' => function ($data) {
                    return $data->service->service_name;
                },
                'status' => function ($data) {
                    return $data->status == 'active' ? '<span class="badge bg-label-success">Active</span>' : '<span class="badge bg-label-danger">Non Active</span>';
                },
                // TODO FOR EDIT HOTEL ROOMS
                'action' => function ($data) use ($editPermission, $editButton, $onclickEdit, $onclickDelete) {
                    return $this->getActionButtons($data, $editPermission, $editButton, $onclickEdit, $onclickDelete);
                }
            ]
        );
    }

    // 👇 **** PRIVATE FUNCTIONS **** 👇

    /**
     * Generate action buttons for the DataTables row.
     * @param $data
     * @param $editPermission
     * @param $editButton
     * @param $onclickEdit
     * @param $onclickDelete
     * @return string HTML string for the action buttons
     */
    private function getActionButtons($data, $editPermission, $editButton, $onclickEdit, $onclickDelete)
    {
        return (new ActionButtonsBuilder())
            ->setEditPermission($editPermission)
            ->setOnclickDelete($onclickDelete)
            ->setOnclickEdit($onclickEdit)
            ->setType($editButton)
            ->setIdentity($data->id)
            ->build();
    }
}
