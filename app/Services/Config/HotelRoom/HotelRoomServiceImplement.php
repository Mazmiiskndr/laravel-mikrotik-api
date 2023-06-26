<?php

namespace App\Services\Config\HotelRoom;

use LaravelEasyRepository\Service;
use App\Repositories\Config\HotelRoom\HotelRoomRepository;
use Illuminate\Support\Facades\Log;

class HotelRoomServiceImplement extends Service implements HotelRoomService
{

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
     * Fetches hotel room parameters from the model's table.
     * @return Model The fetched Eloquent model instance.
     */
    public function getHotelRoomParameters()
    {
        try {
            return $this->mainRepository->getHotelRoomParameters();
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
        }
    }

    /**
     * Updates or creates hotel room settings based on the given data.
     * @param  array $settings The settings to update or create.
     */
    public function updateHotelRoomSettings($settings)
    {
        try {
            return $this->mainRepository->updateHotelRoomSettings($settings);
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
        }
    }

    /**
     * Fetches data from the database and formats it for DataTables.
     * @return JsonResponse A JSON response suitable for DataTables.
     */
    public function getDatatables()
    {
        try {
            return $this->mainRepository->getDatatables();
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
            return [];
            //throw $th;
        }
    }


}
