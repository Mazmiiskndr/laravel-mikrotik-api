<?php

namespace App\Services\Config\HotelRoom;

use LaravelEasyRepository\Service;
use App\Repositories\Config\HotelRoom\HotelRoomRepository;
use App\Traits\HandleRepositoryCall;

class HotelRoomServiceImplement extends Service implements HotelRoomService
{
    use HandleRepositoryCall;

    protected $mainRepository;
    /**
     * Constructor.
     * @param HotelRoomRepository $mainRepository The main repository for settings.
     */
    public function __construct(HotelRoomRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Fetches hotel room parameters from the model's table.
     * @return mixed The fetched hotel room parameters.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function getHotelRoomParameters()
    {
        return $this->handleRepositoryCall('getHotelRoomParameters');
    }

    /**
     * Updates or creates hotel room settings based on the given data.
     * @param array $settings The settings to update or create.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function updateHotelRoomSettings($settings)
    {
        return $this->handleRepositoryCall('updateHotelRoomSettings', [$settings]);
    }

    /**
     * Fetches data from the database and formats it for DataTables.
     * @return mixed The result suitable for DataTables.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function getDatatables()
    {
        return $this->handleRepositoryCall('getDatatables');
    }

}
