<?php

namespace App\Services\ServiceMegalos;

use LaravelEasyRepository\Service;
use App\Repositories\ServiceMegalos\ServiceMegalosRepository;
use App\Traits\HandleRepositoryCall;
use Exception;

class ServiceMegalosServiceImplement extends Service implements ServiceMegalosService
{
    use HandleRepositoryCall;

    protected $mainRepository;
    /**
     * Constructor.
     * @param ServiceMegalosRepository $mainRepository The main repository for settings.
     */
    public function __construct(ServiceMegalosRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Fetches and prepares data for DataTables.
     * @return mixed The result of getDatatables method from the repository.
     */
    public function getDatatables()
    {
        return $this->handleRepositoryCall('getDatatables');
    }

    /**
     * Fetches and prepares data for Premium Services DataTables.
     * @return mixed The result of getPremiumServicesDatatables method from the repository.
     */
    public function getPremiumServicesDatatables()
    {
        return $this->handleRepositoryCall('getPremiumServicesDatatables');
    }

    /**
     * Retrieves validation rules.
     * @param mixed $request
     * @param int|null $serviceId
     * @return mixed The result of getRules method from the repository.
     */
    public function getRules($request, $serviceId = null)
    {
        return $this->handleRepositoryCall('getRules', [$request, $serviceId]);
    }

    /**
     * Retrieves validation messages.
     * @return mixed The result of getMessages method from the repository.
     */
    public function getMessages()
    {
        return $this->handleRepositoryCall('getMessages');
    }

    /**
     * Retrieves the attributes.
     * @return mixed The result of getAttributes method from the repository.
     */
    public function getAttributes()
    {
        return $this->handleRepositoryCall('getAttributes');
    }

    /**
     * Creates a new service.
     * @param array $request
     * @return mixed The result of storeNewService method from the repository.
     */
    public function storeNewService($request)
    {
        return $this->handleRepositoryCall('storeNewService', [$request]);
    }

    /**
     * Updates an existing service.
     * @param array $request
     * @param int $serviceId
     * @return mixed The result of updateService method from the repository.
     */
    public function updateService($request, $serviceId)
    {
        return $this->handleRepositoryCall('updateService', [$request, $serviceId]);
    }

    /**
     * Deletes a service and radgroupreply.
     * @param int $serviceId
     * @return mixed The result of deleteServiceAndRadGroupReply method from the repository.
     */
    public function deleteServiceAndRadGroupReply($serviceId)
    {
        return $this->handleRepositoryCall('deleteServiceAndRadGroupReply', [$serviceId]);
    }

    /**
     * Fetches all services.
     * @return mixed The result of getServices method from the repository.
     */
    public function getServices()
    {
        return $this->handleRepositoryCall('getServices');
    }

    /**
     * Fetches a service by its ID.
     * @param int $serviceId
     * @return mixed The result of getServiceById method from the repository.
     */
    public function getServiceById($serviceId)
    {
        return $this->handleRepositoryCall('getServiceById', [$serviceId]);
    }

    /**
     * Creates a hotel room service.
     * @param array $request
     * @return mixed The result of storeHotelRoomService method from the repository.
     */
    public function storeHotelRoomService($request)
    {
        return $this->handleRepositoryCall('storeHotelRoomService', [$request]);
    }

    /**
     * Deletes a service by its ID.
     * @param int $id
     * @return mixed The result of deleteService method from the repository.
     */
    public function deleteService($id)
    {
        return $this->handleRepositoryCall('deleteService', [$id]);
    }

    /**
     * Convert time to integer seconds based on the provided unit.
     * @param string $unit The unit of the time value, can be 'minutes', 'hours', or 'days'.
     * @return int The time in seconds.
     * @throws Exception If an invalid unit is provided.
     */
    public function timeToInt($unit)
    {
        return $this->handleRepositoryCall('timeToInt', [$unit]);
    }

}
