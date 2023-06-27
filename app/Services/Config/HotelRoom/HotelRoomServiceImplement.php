<?php

namespace App\Services\Config\HotelRoom;

use LaravelEasyRepository\Service;
use App\Repositories\Config\HotelRoom\HotelRoomRepository;
use Illuminate\Support\Facades\Log;

class HotelRoomServiceImplement extends Service implements HotelRoomService
{
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
     * Handles the method call to the repository and manages exceptions.
     * @param string $method The method to call.
     * @param array $parameters The parameters to pass to the method.
     * @throws \Exception If there is an error when calling the method.
     * @return mixed The result of the method call.
     */
    private function handleRepositoryCall(string $method, array $parameters = [])
    {
        try {
            return $this->mainRepository->{$method}(...$parameters);
        } catch (\Exception $exception) {
            $errorMessage = "Error when calling $method: " . $exception->getMessage();
            throw new \Exception($errorMessage);
        }
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
