<?php

namespace App\Services\Config\HotelRoom;

use LaravelEasyRepository\BaseService;

interface HotelRoomService extends BaseService
{

    /**
     * Fetches hotel room parameters from the model's table.
     * @return Model The fetched Eloquent model instance.
     */
    public function getHotelRoomParameters();

    /**
     * Updates or creates hotel room settings based on the given data.
     * @param  array $settings The settings to update or create.
     */
    public function updateHotelRoomSettings($settings);

    /**
     * Fetches data from the database and formats it for DataTables.
     * @return JsonResponse A JSON response suitable for DataTables.
     */
    public function getDatatables();
}
