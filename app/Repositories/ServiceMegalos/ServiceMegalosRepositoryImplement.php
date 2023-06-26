<?php

namespace App\Repositories\ServiceMegalos;

use App\Helpers\AccessControlHelper;
use App\Models\RadGroupCheck;
use App\Models\RadGroupReply;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Services;
use Exception;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ServiceMegalosRepositoryImplement extends Eloquent implements ServiceMegalosRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;
    protected $radGroupReply;
    protected $radGroupCheck;

    public function __construct(Services $model, RadGroupReply $radGroupReply, RadGroupCheck $radGroupCheck)
    {
        $this->model = $model;
        $this->radGroupReply = $radGroupReply;
        $this->radGroupCheck = $radGroupCheck;
    }

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables()
    {
        // Retrieve records from the database using the model, including the related 'services' records, and sort by the latest records
        $data = $this->model->select('id', 'service_name', 'cost', 'currency', 'idle_timeout', 'ul_rate', 'dl_rate')->orderBy('id', 'DESC')->get();

        // Initialize DataTables and add columns to the table
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('currency_cost', function ($data) {
                return $data->currency . ' ' . number_format($data->cost, 2);
            })
            ->addColumn('idle_timeout', function ($data) {
                return $data->idle_timeout . ' Seconds';
            })
            ->addColumn('upload_rate', function ($data) {
                return $data->ul_rate . ' Kbps';
            })
            ->addColumn('download_rate', function ($data) {
                return $data->dl_rate . ' Kbps';
            })
            ->addColumn('action', function ($data) {
                $editButton = '';
                $deleteButton = '';

                // Check if the current service is allowed to edit
                if (AccessControlHelper::isAllowedToPerformAction('edit_service')) {
                    // If service is allowed, show edit button
                    $editButton = '<a href="' . route('backend.services.edit-service', $data->id) . '" class="edit btn btn-primary btn-sm" > <i class="fas fa-edit"></i></a>';
                }
                // If the current service is not the DefaultService
                if($data->id != 1){
                    // Check if the current service is allowed to delete
                    if (AccessControlHelper::isAllowedToPerformAction('delete_service')) {
                        // If service is allowed, show delete button
                        $deleteButton = '&nbsp;&nbsp;<button type="button" class="delete btn btn-danger btn-sm" onclick="confirmDeleteService(\'' . $data->id . '\')"> <i class="fas fa-trash"></i></button>';
                    }
                }

                return $editButton . $deleteButton;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Retrieves records from a database, initializes DataTables Premium Services, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getPremiumServicesDatatables()
    {
        // Retrieve records from the database using the model, including the related 'services' records, and sort by the latest records
        $data = $this->model->where('for_purchase', 1)->select('id', 'service_name', 'ul_rate', 'dl_rate', 'purchase_duration','unit_time_purchase')->orderBy('id', 'DESC')->get();

        // Initialize DataTables and add columns to the table
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('upload_rate', function ($data) {
                return $data->ul_rate . ' Kbps';
            })
            ->addColumn('download_rate', function ($data) {
                return $data->dl_rate . ' Kbps';
            })
            ->addColumn('purchase_duration', function ($data) {
                return $data->purchase_duration . ' ' . ucwords($data->unit_time_purchase);
            })
            ->addColumn('action', function ($data) {
                $editButton = '';
                $deleteButton = '';

                // Check if the current service is allowed to edit
                if (AccessControlHelper::isAllowedToPerformAction('edit_premium_service')) {
                    // If service is allowed, show edit button
                    $editButton = '<a href="' . route('backend.services.edit-premium-service', $data->id) . '" class="edit btn btn-primary btn-sm" > <i class="fas fa-edit"></i></a>';
                }

                return $editButton . $deleteButton;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Define validation rules for service creation.
     * @param object $request The rules data used to create the new service.
     * @param string|null $serviceId Service ID for uniqueness checks. If not provided, a create operation is assumed.
     * @return array Array of validation rules
     */
    public function getRules($request, $serviceId = null)
    {
        // Defining the validation rule for the service name.
        $serviceNameRule = 'required|string|min:3|max:40|unique:services,service_name';
        $serviceNameRule .= $serviceId ? ',' . $serviceId . ',id' : '';

        // Defining the validation rule for the validity.
        $validityTypeRule = (isset($request->validity)) ? 'required|string' : 'nullable|string';

        // Defining the validation rule for the time limit.
        $limitTypeRule = (isset($request->timeLimit)) ? 'required|string' : 'nullable|string';

        // Defining the validation rule for the burst.
        $burstRule = (isset($request->downloadBurstRate) || isset($request->uploadBurstRate) || isset($request->downloadBurstTime) || isset($request->uploadBurstTime) ) ? 'required' : 'nullable';
        // TODO: Still need to check
        // || $request->priority

        // Defining the validation rule for the priority.
        $priorityRule = (isset($request->downloadBurstRate)) ? 'required|integer|between:1,8' : 'nullable|integer|between:1,8';

        // Defining the validation rule for the purchase duration and unit time purchase.
        $timeDurationRule = (isset($request->enableFeature)) == '1' ? 'required|numeric|max:9999999999' : 'nullable|numeric|max:9999999999';
        $unitTimeDurationRule = (isset($request->enableFeature)) == '1' ? 'required|string' : 'nullable|string';

        return [
            'serviceName'           => $serviceNameRule,
            'description'           => 'nullable|string|max:200',
            'downloadRate'          => 'required|numeric|max:9999999',
            'uploadRate'            => 'required|numeric|max:9999999',
            'idleTimeout'           => 'nullable|numeric|max:9999999',
            'sessionTimeout'        => 'nullable|numeric|max:9999999',
            'serviceCost'           => 'nullable|numeric',
            'currency'              => 'nullable|string',
            'simultaneousUse'       => 'nullable|integer|gt:0',
            'downloadBurstRate'     => "$burstRule|numeric|max:9999999|gt:downloadRate",
            'uploadBurstRate'       => "$burstRule|numeric|max:9999999|gt:uploadRate",
            'downloadBurstTime'     => "$burstRule|numeric|gt:0|max:9999999",
            'uploadBurstTime'       => "$burstRule|numeric|gt:0|max:9999999",
            'priority'              => $priorityRule,
            'timeLimit'             => 'nullable|numeric|max:9999999999',
            'unitTime'              => 'nullable|string',
            'limitType'             => $limitTypeRule,
            'validFrom'             => "nullable|date_format:Y-m-d H:i",
            'validityType'          => $validityTypeRule,
            'validity'              => 'nullable|numeric|max:9999999999',
            'unitValidity'          => 'nullable|string',
            'enableFeature'         => 'nullable|boolean',
            'timeDuration'          => $timeDurationRule,
            'unitTimeDuration'      => $unitTimeDurationRule,
        ];
    }

    /**
     * Define validation messages for service creation.
     * @return array Array of validation messages
     */
    public function getMessages()
    {
        return [
            'required'      => 'The :attribute cannot be empty!',
            'string'        => 'The :attribute must be a string!',
            'min'           => 'The :attribute field must be at least :min characters',
            'max'           => 'The :attribute field may not be greater than :max characters!',
            'unique'        => 'The :attribute already exists!',
            'numeric'       => 'The :attribute must be a number!',
            'between'       => 'The :attribute must be between :min and :max.',
            'gt'            => 'The :attribute must be greater than :value.',
            'nullable'      => 'The :attribute field is optional.',
            'boolean'       => 'The :attribute field must be true or false.',
            'date_format'   => 'The :attribute must be a valid datetime (YYYY-MM-DD HH:MM:SS)!',
        ];
    }

    /**
     * Get the attributes based on the provided service.
     */
    public function getAttributes()
    {
        // Mapping from class property to service attribute
        return [
            'serviceId' => 'id',
            'serviceName' => 'service_name',
            'description' => 'description',
            'downloadRate' => 'dl_rate',
            'uploadRate' => 'ul_rate',
            'idleTimeout' => 'idle_timeout',
            'sessionTimeout' => 'session_timeout',
            'serviceCost' => 'cost',
            'currency' => 'currency',
            'simultaneousUse' => 'simultaneous_use',
            'downloadBurstRate' => 'dl_br_rate',
            'uploadBurstRate' => 'ul_br_rate',
            'downloadBurstTime' => 'dl_br_time',
            'uploadBurstTime' => 'ul_br_time',
            'priority' => 'priority',
            'limitType' => 'time_limit_type',
            'timeLimit' => 'time_limit',
            'unitTime' => 'unit_time',
            'validityType' => 'validity_type',
            'validity' => 'validity',
            'unitValidity' => 'unit_validity',
            'timeDuration' => 'purchase_duration',
            'unitTimeDuration' => 'unit_time_purchase',
            'enableFeature' => 'for_purchase'
        ];
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
            // Prepare the service data
            $serviceData = $this->prepareDataServices($request);
            // Create new service entry
            $service = $this->model->create($serviceData);

            // Set rate limit according to 'for_purchase' value
            $this->setRateLimit($service);

            // Call the other methods with the updated service
            $this->setServiceParameters($service);

            return $service;
        } catch (\Exception $e) {
            // If an exception occurred during the create process, log the error message.
            Log::error("Failed to store new client : " . $e->getMessage());
            // Rethrow the exception to be caught in the Livewire component.
            throw $e;
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
            // Check if the service exists
            $service = $this->getServiceById($serviceId);
            // Delete the related records from the 'radGroupReply' table.
            $this->deleteRadGroupReplyRecords($service);
            // Delete the service.
            $service->delete();
        } catch (\Exception $e) {
            // If an exception occurred during the delete process, log the error message.
            Log::error("Failed to delete the service with id " . $serviceId . " : " . $e->getMessage());
            // Rethrow the exception.
            throw $e;
        }
    }

    /**
     * Updates an existing service using the provided request data.
     * @param object $request The data used to update the service.
     * @param int $serviceId Service ID for uniqueness checks. If not provided, a create operation is assumed.
     * @return Model|mixed The updated service.
     * @throws \Exception if an error occurs while updating the service.
     */
    public function updateService($request, $serviceId)
    {
        try {
            // Check if the service exists
            $service = $this->getServiceById($serviceId);
            // Prepare the service data
            $serviceData = $this->prepareDataServices($request);
            // Update service entry
            $service->update($serviceData);
            // Set rate limit according to 'for_purchase' value
            $this->setRateLimit($service);
            // Call the other methods with the updated service
            $this->setServiceParameters($service);

            return $service;
        } catch (\Exception $e) {
            // If an exception occurred during the update process, log the error message.
            Log::error("Failed to update service : " . $e->getMessage());
            // Rethrow the exception to be caught in the Livewire component.
            throw $e;
        }
    }

    /**
     * Get a collection of services with non-null 'cron_type' field and non-empty 'cron' field.
     * @return \Illuminate\Support\Collection Collection of services with selected fields ('id', 'service_name', 'cron_type', 'cron')
     */
    public function getServices()
    {
        return $this->model->select('id', 'service_name', 'cron_type', 'cron')->get();
    }

    /**
     * Retrieves a service by its ID.
     * @param int $serviceId Unique identifier of the service.
     * @return mixed Single record of the service from the database.
     */
    public function getServiceById($serviceId)
    {
        $service = $this->model->find($serviceId);
        if (!$service) {
            throw new \Exception('Service not found');
        }

        return $service;
    }

    /**
     * Store service for a hotel room.
     * @param  array $request Input data for updating the service.
     * @throws \InvalidArgumentException if 'idService' is not present in the request
     * @throws \RuntimeException if the service does not exist
     * @return \Illuminate\Database\Eloquent\Model|null Updated service instance
     */
    public function storeHotelRoomService($request)
    {
        // Check if idService is in the request
        if (!array_key_exists('idService', $request)) {
            throw new \InvalidArgumentException("idService is empty in the request");
        }

        // Update the service
        $service = $this->model->where('id', $request['idService'])
            ->update([
                'cron' => 1,
                'cron_type' => $request['cronType'],
            ]);

        // Check if service exists
        if (!$service) {
            throw new \RuntimeException("Service with id {$request['idService']} not found");
        }

        // Return the updated service
        return $service;
    }

    /**
     * Delete a service by setting 'cron' to 0 and 'cron_type' to empty.
     * @param  int $id The ID of the service to be deleted
     * @throws \RuntimeException if the service does not exist
     * @return \Illuminate\Database\Eloquent\Model|null Updated service instance
     */
    public function deleteService($id)
    {
        // Delete the service
        $service = $this->model->where('id', $id)
            ->update([
                'cron' => 0,
                'cron_type' => "",
            ]);

        // Check if service exists
        if (!$service) {
            throw new \RuntimeException("Service with id {$id} not found");
        }

        // Return the updated service
        return $service;
    }

    // ***** 👇 PRIVATE FUNCTIONS 👇 *****

    /**
     * Define logic for setting idle timeout.
     * @param array $service The data of the service.
     */
    private function idleTimeout($service)
    {
        $param = [
            'attribute' => 'Idle-Timeout',
            'value' => $service['idle_timeout'],
            'service_name' => $service['service_name'],
            'service_id' => $service['id']
        ];

        // Call the method to manage RADIUS records
        $this->radiusRecord($param);
    }

    /**
     * Define logic for setting session timeout.
     * @param array $service The data of the service.
     */
    private function sessionTimeout($service)
    {
        $param = [
            'attribute' => 'Session-Timeout',
            'value' => $service['session_timeout'],
            'service_name' => $service['service_name'],
            'service_id' => $service['id']
        ];

        // Call the method to manage RADIUS records
        $this->radiusRecord($param);
    }

    /**
     * Define logic for setting simultaneous use.
     * @param array $service The data of the service.
     */
    private function simultaneousUse($service)
    {
        $param = [
            'attribute' => 'Simultaneous-Use',
            'value' => $service['simultaneous_use'],
            'service_name' => $service['service_name'],
            'service_id' => $service['id']
        ];

        // Call the method to manage RADIUS records
        $this->radiusRecord($param);
    }

    /**
     * Define logic for setting time limit.
     * @param array $service The data of the service.
     */
    private function timeLimit($service)
    {
        $value = $service['time_limit'] * $this->timeToInt($service['unit_time']);
        $attribute = $this->getAttributeForTimeLimit($service['time_limit_type']);
        $param = [
            'attribute' => $attribute,
            'value' => $value,
            'service_name' => $service['service_name'],
            'service_id' => $service['id'],
            'find_existing_record_callback' => 'getExistingTimeLimitRecord',
            'delete_callback' => 'deleteAllTimeLimitRecord'
        ];

        // Call the method to manage RADIUS records
        $this->radiusRecord($param);
    }

    /**
     * Convert time to integer seconds based on the provided unit.
     * @param string $unit The unit of the time value, can be 'minutes', 'hours', or 'days'.
     * @return int The time in seconds.
     * @throws Exception If an invalid unit is provided.
     */
    private function timeToInt($unit)
    {
        $array = [
            "minutes"     => 60,
            "hours"        => 3600,
            "days"        => 86400
        ];

        return (array_key_exists($unit, $array)) ? $array[$unit] : 0;
    }

    /**
     * Delete all time limit records for the provided service name.
     * @param string $serviceName The name of the service.
     */
    private function deleteAllTimeLimitRecord($serviceName)
    {
        $attributes = ['Max-Weekly-Session', 'Max-Monthly-Session', 'Expire-After', 'Max-All-Session'];

        foreach ($attributes as $attribute) {
            // For each attribute, delete the corresponding record.
            $this->radGroupCheck->where(['groupname' => $serviceName, 'attribute' => $attribute])->delete();
        }
    }

    /**
     * Get the existing time limit record for the provided service name.
     * @param string $serviceName The name of the service.
     * @return mixed The existing record, or false if none exists.
     */
    private function getExistingTimeLimitRecord($serviceName)
    {
        $attributes = ['Max-Weekly-Session', 'Max-Monthly-Session', 'Expire-After', 'Max-All-Session'];

        foreach ($attributes as $attribute) {
            // For each attribute, try to find the corresponding record.
            $data = $this->radGroupCheck->where(['groupname' => $serviceName, 'attribute' => $attribute])->first();
            if ($data != null) return $data;
        }

        // If no record is found, return false.
        return false;
    }

    /**
     * Get the attribute for the time limit based on the provided type.
     * @param string $timeLimitType The type of the time limit, can be 'monthly_reset', 'weekly_reset', 'one_time_gradually', or 'one_time_continuous'.
     * @return string The attribute corresponding to the time limit type.
     */
    private function getAttributeForTimeLimit($timeLimitType)
    {
        switch ($timeLimitType) {
            case 'monthly_reset':
                return 'Max-Monthly-Session';
            case 'weekly_reset':
                return 'Max-Weekly-Session';
            case 'one_time_gradually':
                return 'Max-All-Session';
            case 'one_time_continuous':
            default:
                return 'Expire-After';
        }
    }

    /**
     * Prepares service data based on provided request.
     * @param array $request The data used to prepare the service data.
     * @return array The prepared service data.
     * @throws Exception If the data is invalid.
     */
    private function prepareDataServices($request)
    {

        // If 'id' is set, get the existing service
        $service = null;
        if (isset($request['id']) && $request['id'] > 0) {
            $service = $this->model->find($request['id']);
            if (!$service) {
                throw new Exception('Service not found for the given id');
            }
        }

        $defaultUnitTimeDuration = "hours";
        $none = "none";
        $defaultValidFrom = 0;

        $data = [
            'id'                    => $request['id'] ?? 0,
            'service_name'          => $service ? $service->service_name : $request['serviceName'] ?? '',
            'description'           => $request['description'] ?? '',
            'dl_rate'               => (int) ($request['downloadRate'] ?? 0),
            'ul_rate'               => (int) ($request['uploadRate'] ?? 0),
            'idle_timeout'          => (int) ($request['idleTimeout'] ?? 0),
            'session_timeout'       => (int) ($request['sessionTimeout'] ?? 0),
            'cost'                  => (int) ($request['serviceCost'] ?? 0),
            'currency'              => $request['currency'] ?? '',
            'validfrom'             => !empty($request['validFrom']) ? strtotime($request['validFrom']) : $defaultValidFrom,
            'simultaneous_use'      => (int) ($request['simultaneousUse'] ?? 0),
            'dl_br_rate'            => (int) ($request['downloadBurstRate'] ?? 0),
            'ul_br_rate'            => (int) ($request['uploadBurstRate'] ?? 0),
            'dl_br_trh'             => round((int) ($request['downloadRate'] ?? 0) * 0.75),
            'ul_br_trh'             => round((int) ($request['uploadRate'] ?? 0) * 0.75),
            'dl_br_time'            => (int) ($request['downloadBurstTime'] ?? 0),
            'ul_br_time'            => (int) ($request['uploadBurstTime'] ?? 0),
            'priority'              => (int) ($request['priority'] ?? 0),
            'time_limit'            => (int) ($request['timeLimit'] ?? 0),
            'unit_time'             => $request['unitTime'] ?? '',
            'time_limit_type'       => (!empty($request['timeLimit'])) ? $request['limitType'] : $none,
            'validity'              => (int) ($request['validity'] ?? 0),
            'validity_type'         => (!empty($request['validity'])) ? $request['validityType'] : $none,
            'unit_validity'         => $request['unitValidity'] ?? '',
            'for_purchase'          => (int) ($request['enableFeature'] ?? 0),
            'purchase_duration'     => (int) ($request['timeDuration'] ?? 0),
            'unit_time_purchase'    => $request['unitTimeDuration'] ?? $defaultUnitTimeDuration,
        ];

        return $data;
    }

    /**
     * Define logic for adding rate limit.
     * @param array $service The data of the service.
     */
    private function rateLimitAddLimitAt($service)
    {
        // Construct the base value from the upload rate (ul_rate) and download rate (dl_rate)
        $value = $service['ul_rate'] . 'k/' . $service['dl_rate'] . 'k';

        // Check if the service has a defined download burst rate (dl_br_rate)
        if (!empty($service['dl_br_rate'])) {
            // If it does, append the burst rates, thresholds, times, priority, and a constant value to the existing value
            $value .= ' ' . $service['ul_br_rate'] . 'k/' . $service['dl_br_rate'] . 'k ' . $service['ul_br_trh'] . 'k/' . $service['dl_br_trh'] . 'k ' . $service['ul_br_time'] . '/' . $service['dl_br_time'] . ' ' . $service['priority'] . ' 32k/32k';
        } else {
            // If it doesn't, append the upload and download rates, burst thresholds, a constant time value, the priority, and another constant value to the existing value
            $value .= ' ' . $service['ul_rate'] . 'k/' . $service['dl_rate'] . 'k ' . $service['ul_br_trh'] . 'k/' . $service['dl_br_trh'] . 'k 60/60 ' . $service['priority'] . ' 32k/32k';
        }

        // Construct the parameters for the radius record/
        $attributes = [
            'attribute' => 'Mikrotik-Rate-Limit',
            'value' => $value,
            'service_name' => $service['service_name'],
            'service_id' => $service['id'],
        ];
        $this->radiusRecord($attributes);
    }

    /**
     * Define logic for rate limit.
     * @param array $service The data of the service.
     */
    private function rateLimit($service)
    {
        // Construct the base value from the upload rate (ul_rate) and download rate (dl_rate)
        $value = $service['ul_rate'] . 'k/' . $service['dl_rate'] . 'k';

        // Check if the service has a defined download burst rate (dl_br_rate)
        if (!empty($service['dl_br_rate'])) {
            // If it does, append the burst rates, thresholds, times, and priority to the existing value
            $value .= ' ' . $service['ul_br_rate'] . 'k/' . $service['dl_br_rate'] . 'k ' . $service['ul_br_trh'] . 'k/' . $service['dl_br_trh'] . 'k ' . $service['ul_br_time'] . '/' . $service['dl_br_time'] . ' ' . $service['priority'];
        }

        // Construct the parameters for the radius record
        $attributes = [
            'attribute' => 'Mikrotik-Rate-Limit',
            'value' => $value,
            'service_name' => $service['service_name'],
            'service_id' => $service['id'],
        ];
        // Call the method to manage RADIUS records
        $this->radiusRecord($attributes);
    }


    /**
     * Method to manage RADIUS records.
     * You need to implement this method.
     * @param array $param Parameters for managing the record
     */
    private function radiusRecord($param)
    {
        // Prepare data if 'value' is valid
        if ((is_int($param['value']) && $param['value'] > 0) || (is_string($param['value']) && $param['value'] != "")) {
            $dataPrepare = $this->prepareDataRadgroup($param['service_name'], $param['attribute'], $param['value']);

            // Fetch the existing record if 'service_id' is set
            if ($param['service_id'] > 0) {
                $data = $this->radGroupReply->where([
                    'groupname' => $param['service_name'],
                    'attribute' => $param['attribute'],
                ])->first();

                // Add 'id' to the prepared data if record exists
                if (!empty($data->id))
                    $dataPrepare['id'] = $data->id;
            }

            // Save or update the record
            isset($dataPrepare['id'])
                ? $this->radGroupReply->where('id', $dataPrepare['id'])->update($dataPrepare)
                : $this->radGroupReply->insert($dataPrepare);
        } else {
            // Delete the record if 'value' is not valid
            $this->radGroupReply->where([
                'groupname' => $param['service_name'],
                'attribute' => $param['attribute']
            ])->delete();
        }
    }

    /**
     * Prepare data for the radgroup.
     * @param string $service_name The name of the service
     * @param string $attribute The attribute
     * @param mixed $value The value
     * @return array The prepared data for the radgroup
     */
    private function prepareDataRadgroup($service_name, $attribute, $value)
    {
        // Prepare the data for the radgroup
        return [
            'groupname' => $service_name,
            'attribute' => $attribute,
            'op' => ':=',
            'value' => $value
        ];
    }

    /**
     * Delete the related records from the 'radGroupReply' table.
     * @param Model $service The service model instance.
     */
    private function deleteRadGroupReplyRecords($service)
    {
        // Define the attributes for the records to delete.
        $attributes = [
            'Idle-Timeout',
            'Session-Timeout',
            'Simultaneous-Use',
            $this->getAttributeForTimeLimit($service['time_limit_type']),
            'Mikrotik-Rate-Limit'
        ];

        // Delete the records
        foreach ($attributes as $attribute) {
            $this->radGroupReply->where([
                'groupname' => $service['service_name'],
                'attribute' => $attribute
            ])->delete();
        }
    }

    /**
     * Helper function to set service parameters.
     * @param array $service
     */
    private function setServiceParameters($service)
    {
        $this->IdleTimeout($service);
        $this->SessionTimeout($service);
        $this->SimultaneousUse($service);
        $this->TimeLimit($service);
    }

    /**
     * Helper function to set rate limit.
     * @param array $service
     */
    private function setRateLimit($service)
    {
        if ($service['for_purchase'] > 0) {
            $this->rateLimitAddLimitAt($service);
        } else {
            $this->rateLimit($service);
        }
    }
}
