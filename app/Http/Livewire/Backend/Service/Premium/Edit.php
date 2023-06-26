<?php

namespace App\Http\Livewire\Backend\Service\Premium;

use App\Services\ServiceMegalos\ServiceMegalosService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class Edit extends Component
{
    // Traits LivewireMessageEvents for show modal and toast message
    use LivewireMessageEvents;
    // Properties Public For Create New Service
    public $serviceId, $serviceName, $description, $downloadRate, $uploadRate, $idleTimeout, $sessionTimeout,
        $serviceCost, $currency = "IDR", $simultaneousUse, $downloadBurstRate, $uploadBurstRate,
        $downloadBurstTime, $uploadBurstTime, $priority, $limitType, $timeLimit, $unitTime = "minutes", $validFrom, $validityType = "none",
        $validity, $unitValidity = "days", $timeDuration, $unitTimeDuration = "hours", $enableFeature;

    /**
     * Mount the component.
     */
    public function mount(ServiceMegalosService $serviceMegalosService)
    {
        $this->showDetailService($this->serviceId, $serviceMegalosService);
    }

    /**
     * Handle property updates.
     * @param string $property
     * @return void
     */
    public function updated($property)
    {
        // Every time a property changes, this function will be called
        $serviceMegalosService = app(ServiceMegalosService::class);
        $this->validateOnly($property, $serviceMegalosService->getRules($this, $this->serviceId), $serviceMegalosService->getMessages());
    }

    /**
     * Render the component `premium services form-edit`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.service.premium.edit');
    }

    /**
     * Updates a service using data validated by the provided ServiceMegalosService instance.
     * @param ServiceMegalosService $serviceMegalosService The service used to validate and update the service data
     * @return \Illuminate\Http\Response Returns a redirect response to the services list route on successful update.
     * @throws \Throwable If there is an error during the update process, it is caught and an error event is dispatched.
     */
    public function updatePremiumService(ServiceMegalosService $serviceMegalosService)
    {
        // Validate Form Request
        $newService = $this->validate($serviceMegalosService->getRules($this, $this->serviceId), $serviceMegalosService->getMessages());

        // Format serviceName: remove spaces and capitalize each word
        $newService['serviceName'] = ucwords(strtolower($newService['serviceName']));

        try {
            // Call the storeNewPremiumService function in the repository
            $serviceMegalosService->updateService($newService, $this->serviceId);
            // Reset the form fields
            $this->resetFields();
            // Emit the 'premiumServiceUpdated' event with a true status
            $this->emit('premiumServiceUpdated', true);
            return redirect()->route('backend.services.premium-services')->with('success', 'Premium Service was updated successfully.');
            // // Redirect to the premium.service.index page with a success message
        } catch (\Throwable $th) {
            // Show Message Error
            $this->dispatchErrorEvent('An error occurred while updating premium service: ' . $th->getMessage());
        }
    }

    /**
     * Retrieves a service by its ID using the provided `ServiceMegalosService` and assigns the service attributes
     * to the properties of this component for further processing or display.
     * @param int $serviceId The ID of the service to be retrieved.
     * @param ServiceMegalosService $serviceMegalosService The service used to interact with the services data.
     */
    public function showDetailService($serviceId, ServiceMegalosService $serviceMegalosService)
    {
        // Get the service by its ID
        $service = $serviceMegalosService->getServiceById($serviceId);
        // If the service exists, set the attributes
        if ($service) {
            $this->setAttributes($service);
        }
    }

    /**
     * Sets the attributes based on the provided service.
     * @param Service $service The service to extract attributes from
     */
    private function setAttributes($service)
    {
        // Get the fields to be set
        $fields = $this->getAttributes();

        // Iterate over each property and set the corresponding value
        foreach ($fields as $property => $field) {
            $this->$property = $this->formatValue($service, $field);
        }
        // Handle 'validFrom' separately because it needs to be formatted as a date
        $this->validFrom = ($service->validfrom == 0 || empty($service->validfrom)) ? null : date('Y-m-d H:i', $service->validfrom);
    }

    /**
     * Formats a value based on whether it is the 'cost' attribute and whether it is empty.
     * @param Service $service The service to extract the value from
     * @param string $field The field to extract the value from
     * @return mixed The formatted value
     */
    private function formatValue($service, $field)
    {
        // Checking if the field value is 0 or empty and returning null if it is
        return ($service->$field == 0 || empty($service->$field)) ? null : $service->$field;
    }
    /**
     * Reset all fields to their default state.
     * @return void
     */
    public function resetFields()
    {
        // Reset the form fields
        $this->serviceId = null;
        $this->serviceName = null;
        $this->description = null;
        $this->downloadRate = null;
        $this->uploadRate = null;
        $this->idleTimeout = null;
        $this->sessionTimeout = null;
        $this->serviceCost = null;
        $this->currency = null;
        $this->simultaneousUse = null;
        $this->downloadBurstRate = null;
        $this->uploadBurstRate = null;
        $this->downloadBurstTime = null;
        $this->uploadBurstTime = null;
        $this->priority = null;
        $this->limitType = null;
        $this->timeLimit = null;
        $this->unitTime = null;
        $this->validFrom = null;
        $this->validityType = null;
        $this->validity = null;
        $this->unitValidity = null;
        $this->timeDuration = null;
        $this->unitTimeDuration = null;
        $this->enableFeature = null;
    }

    /**
     * Get the attributes based on the provided service.
     */
    private function getAttributes()
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
}
