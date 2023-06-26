<?php

namespace App\Repositories\ServiceMegalos;

use LaravelEasyRepository\Repository;

interface ServiceMegalosRepository extends Repository{

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
     * Stores a new service using the provided request data.
     * @param array $request The data used to create the new service.
     * @return Model|mixed The newly created service.
     * @throws \Exception if an error occurs while creating the service.
     */
    public function storeNewService($request);

    /**
     * Updates an existing service using the provided request data.
     * @param array $request The data used to update the service.
     * @param int $serviceId Service ID for uniqueness checks. If not provided, a create operation is assumed.
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
     * getServices
     *
     * @return void
     */
    public function getServices();

    /**
     * Retrieves a service by its ID.
     * @param int $serviceId Unique identifier of the service.
     * @return mixed Single record of the service from the database.
     */
    public function getServiceById($serviceId);

    /**
     * storeHotelRoomService
     *
     * @param  mixed $request
     * @return void
     */
    public function storeHotelRoomService($request);

    /**
     * deleteService
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteService($id);
}
