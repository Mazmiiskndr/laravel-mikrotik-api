<?php

namespace App\Repositories\Client\HotelRoom;

use LaravelEasyRepository\Repository;

interface HotelRoomRepository extends Repository{

    /**
     * Retrieve Hotel Rooms records and associated service names.
     * Conditionally applies a WHERE clause if provided.
     * @param array|null $conditions
     * @param array|null $columns
     * @return array
     */
    public function getHotelRoomsWithService($conditions, $columns);

    /**
     * This function finds a hotel room with its associated service.
     * @param $hotelRoomId
     * @return mixed
     */
    public function getHotelRoomIdWithService($hotelRoomId);

    /**
     * Retrieves Hotel Rooms records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableHotelRooms();

    /**
     * Updates an existing hotel room using the provided data.
     * @param string $id The ID of the hotel room to update.
     * @param array $data The data used to update the hotel room.
     * @return Model|mixed The updated hotel room.
     * @throws \Exception if an error occurs while updating the hotel room.
     */
    public function updateHotelRoom($id, $data);
}
