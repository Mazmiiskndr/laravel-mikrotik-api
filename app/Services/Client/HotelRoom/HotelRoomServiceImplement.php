<?php

namespace App\Services\Client\HotelRoom;

use LaravelEasyRepository\Service;
use App\Repositories\Client\HotelRoom\HotelRoomRepository;
use App\Traits\HandleRepositoryCall;

class HotelRoomServiceImplement extends Service implements HotelRoomService
{
    use HandleRepositoryCall;
    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(HotelRoomRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
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
        return $this->handleRepositoryCall('getHotelRoomsWithService', [$conditions, $columns]);
    }

    /**
     * This function finds a hotel room with its associated service.
     * @param $hotelRoomId
     * @return mixed
     */
    public function getHotelRoomIdWithService($hotelRoomId)
    {
        return $this->handleRepositoryCall('getHotelRoomIdWithService', [$hotelRoomId]);
    }

    /**
     * Retrieves Hotel Rooms records from a database, initializes DataTables, and adds columns to DataTable.
     * @return \Yajra\DataTables\DataTables Yajra DataTables JSON response.
     */
    public function getDatatableHotelRooms()
    {
        return $this->handleRepositoryCall('getDatatableHotelRooms');
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
        return $this->handleRepositoryCall('updateHotelRoom', [$id, $data]);
    }
}
