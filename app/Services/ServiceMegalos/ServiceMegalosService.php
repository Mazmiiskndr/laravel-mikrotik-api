<?php

namespace App\Services\ServiceMegalos;

use LaravelEasyRepository\BaseService;

interface ServiceMegalosService extends BaseService{

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables();

    /**
     * Retrieves records from a database, initializes DataTables Premium Services, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getPremiumServicesDatatables();

    /**
     * Define validation rules for service creation.
     * @param object $request The rules data used to create the new service.
     * @param string|null $serviceId Service ID for uniqueness checks. If not provided, a create operation is assumed.
     * @return array Array of validation rules
     */
    public function getRules($request, $serviceId = null);

    /**
     * Define validation messages for service creation.
     * @return array Array of validation messages
     */
    public function getMessages();

    /**
     * Get the attributes based on the provided service.
     */
    public function getAttributes();

    /**
     * Stores a new service using the provided request data.
     * @param array $request The data used to create the new service.
     * @return Model|mixed The newly created service.
     * @throws \Exception if an error occurs while creating the service.
     */
    public function storeNewService($request);

    /**
     * Updates an existing service using the provided request data.
     * @param array $request The data used to update the service.
     * @param int $serviceId Service ID for uniqueness checks. If not provided, a create operation is assumed.s
     * @return Model|mixed The updated service.
     * @throws \Exception if an error occurs while updating the service.
     */
    public function updateService($request, $serviceId);

    /**
     * Delete an existing service and radgroupreply.
     * @param int $serviceId The id of the service to be deleted.
     * @throws \Exception if an error occurs while deleting the service.
     */
    public function deleteServiceAndRadGroupReply($serviceId);

    /**
     * Fetches all services from the database.
     */
    public function getServices();

    /**
     * Retrieves a service by its ID.
     * @param int $serviceId The unique identifier of the service.
     * @return mixed A single service record from the database.
     */
    public function getServiceById($serviceId);

    /**
     * Stores a hotel room service in the database.
     * @param array $request The request data to be stored.
     */
    public function storeHotelRoomService($request);

    /**
     * Deletes a service by its ID from the database.
     * @param int $id The unique identifier of the service to be deleted.
     */
    public function deleteService($id);

    /**
     * Convert time to integer seconds based on the provided unit.
     * @param string $unit The unit of the time value, can be 'minutes', 'hours', or 'days'.
     * @return int The time in seconds.
     * @throws Exception If an invalid unit is provided.
     */
    public function timeToInt($unit);

}
