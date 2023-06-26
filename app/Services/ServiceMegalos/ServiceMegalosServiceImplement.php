<?php

namespace App\Services\ServiceMegalos;

use LaravelEasyRepository\Service;
use App\Repositories\ServiceMegalos\ServiceMegalosRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class ServiceMegalosServiceImplement extends Service implements ServiceMegalosService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(ServiceMegalosRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables()
    {
        try {
            return $this->mainRepository->getDatatables();
        } catch (Exception $exception) {
            throw new Exception("Error getting data to datatable : " . $exception->getMessage());
        }
    }

    /**
     * Retrieves records from a database, initializes DataTables Premium Services, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getPremiumServicesDatatables()
    {
        try {
            return $this->mainRepository->getPremiumServicesDatatables();
        } catch (Exception $exception) {
            throw new Exception("Error getting data to premium services datatables : " . $exception->getMessage());
        }
    }

    /**
     * Define validation rules for service creation.
     * @param object $request The rules data used to create the new service.
     * @param string|null $serviceId Service ID for uniqueness checks. If not provided, a create operation is assumed.
     * @return array Array of validation rules
     */
    public function getRules($request, $serviceId = null)
    {
        try {
            return $this->mainRepository->getRules($request, $serviceId);
        } catch (Exception $exception) {
            throw new Exception("Error getting rules : " . $exception->getMessage());
        }
    }

    /**
     * Define validation messages for service creation.
     * @return array Array of validation messages
     */
    public function getMessages()
    {
        try {
            return $this->mainRepository->getMessages();
        } catch (Exception $exception) {
            throw new Exception("Error getting messages : " . $exception->getMessage());
        }
    }

    /**
     * Get the attributes based on the provided service.
     */
    public function getAttributes()
    {
        try {
            return $this->mainRepository->getAttributes();
        } catch (Exception $exception) {
            throw new Exception("Error getting attributes : " . $exception->getMessage());
        }
    }

    /**
     * Stores a new service using the provided request data.
     * @param array $request The data used to create the new service.
     * @return Model|mixed The newly created service.
     * @throws \Exception if an error occurs while creating the service.
     */
    public function storeNewService($request)
    {
        try {
            return $this->mainRepository->storeNewService($request);
        } catch (Exception $exception) {
            throw new Exception("Error creating new service : " . $exception->getMessage());
        }
    }

    /**
     * Updates an existing service using the provided request data.
     * @param array $request The data used to update the service.
     * @param int $serviceId Service ID for uniqueness checks. If not provided, a create operation is assumed.s
     * @return Model|mixed The updated service.
     * @throws \Exception if an error occurs while updating the service.
     */
    public function updateService($request, $serviceId)
    {
        try {
            return $this->mainRepository->updateService($request, $serviceId);
        } catch (Exception $exception) {
            throw new Exception("Error updating service : " . $exception->getMessage());
        }
    }

    /**
     * Delete an existing service and radgroupreply.
     * @param int $serviceId The id of the service to be deleted.
     * @throws \Exception if an error occurs while deleting the service.
     */
    public function deleteServiceAndRadGroupReply($serviceId)
    {
        try {
            return $this->mainRepository->deleteServiceAndRadGroupReply($serviceId);
        } catch (Exception $exception) {
            throw new Exception("Error deleting service : " . $exception->getMessage());
        }
    }

    /**
     * @return The `getServices()` function is returning the result of calling the `getServices()`
     * method on the `` object.
     */
    public function getServices()
    {
        try {
            return $this->mainRepository->getServices();
        } catch (Exception $exception) {
            throw new Exception("Error getting services: " . $exception->getMessage());
        }
    }

    /**
     * Retrieves a service by its ID.
     * @param int $serviceId Unique identifier of the service.
     * @return mixed Single record of the service from the database.
     */
    public function getServiceById($serviceId)
    {
        try {
            return $this->mainRepository->getServiceById($serviceId);
        } catch (Exception $exception) {
            throw new Exception("Error getting services by id : " . $exception->getMessage());
        }
    }

    /**
     * storeHotelRoomService
     *
     * @param  mixed $request
     * @return void
     */
    public function storeHotelRoomService($request)
    {
        try {
            return $this->mainRepository->storeHotelRoomService($request);
        } catch (Exception $exception) {
            throw new Exception("Error storing hotel room service: " . $exception->getMessage());
        }
    }

    /**
     * deleteService
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteService($id)
    {
        try {
            return $this->mainRepository->deleteService($id);
        } catch (Exception $exception) {
            throw new Exception("Error deleting service: " . $exception->getMessage());
        }
    }
}
