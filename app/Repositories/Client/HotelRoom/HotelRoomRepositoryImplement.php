<?php

namespace App\Repositories\Client\HotelRoom;

use App\Helpers\ActionButtonsBuilder;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\HotelRoom;
use App\Traits\DataTablesTrait;
use Exception;
use Illuminate\Support\Facades\DB;
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
            ->with('service:id,service_name')
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
                'action' => function ($data) use ($editPermission, $editButton, $onclickEdit, $onclickDelete) {
                    return $this->getActionButtons($data, $editPermission, $editButton, $onclickEdit, $onclickDelete);
                }
            ]
        );
    }

    /**
     * Updates an existing hotel room using the provided data.
     * @param string $id The ID of the hotel room to update.
     * @param array $data The data used to update the hotel room.
     * @return Model|mixed The updated hotel room.
     * @throws \Exception if an error occurs while updating the hotel room.
     */
    public function updateHotelRoom($id, $data)
    {
        // Start a new database transaction.
        DB::beginTransaction();

        try {
            $hotelRoom = $this->model->findOrFail($id);
            // If the hotel room exists, update its data.
            if ($hotelRoom !== null) {
                // Update hotel room data
                $hotelRoom->service_id = $data['idService'];
                $hotelRoom->password = $data['password'];
                $hotelRoom->edit = 1;
                $hotelRoom->room_number = $data['roomNumber'];
                $hotelRoom->save();

                // Commit the transaction (apply the changes).
                DB::commit();

                return $hotelRoom;
            } else {
                throw new \Exception("Hotel Room with ID $id not found.");
            }
        } catch (\Exception $e) {
            // Rollback the Transaction.
            DB::rollBack();
            // Log the error message
            Log::error("Failed to update hotel room : " . $e->getMessage());
            // Rethrow the exception to be caught in the Livewire component.
            throw $e;
        }
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
