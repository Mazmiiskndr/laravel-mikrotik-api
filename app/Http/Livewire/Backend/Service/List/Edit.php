<?php

namespace App\Http\Livewire\Backend\Service\List;

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
        $this->validateOnly($property, $serviceMegalosService->getRules($this,$this->serviceId), $serviceMegalosService->getMessages());
    }

    /**
     * Render the component `edit form service`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.service.list.edit');
    }

    /**
     * Updates a service using data validated by the provided ServiceMegalosService instance.
     * @param ServiceMegalosService $serviceMegalosService The service used to validate and update the service data
     * @return \Illuminate\Http\Response Returns a redirect response to the services list route on successful update.
     * @throws \Throwable If there is an error during the update process, it is caught and an error event is dispatched.
     */
    public function updateService(ServiceMegalosService $serviceMegalosService)
    {
        // Validate Form Request
        $newService = $this->validate($serviceMegalosService->getRules($this, $this->serviceId), $serviceMegalosService->getMessages());

        try {
            // Call the storeNewService function in the repository
            $serviceMegalosService->updateService($newService, $this->serviceId);
            // Reset the form fields
            $this->resetFields();
        // Emit the 'serviceUpdated' event with a true status
            $this->emit('serviceUpdated', true);
            return redirect()->route('backend.services.list-services')->with('success', 'Service was updated successfully.');
            // // Redirect to the service.index page with a success message
        } catch (\Throwable $th) {
            // Show Message Error
            $this->dispatchErrorEvent('An error occurred while updating service: ' . $th->getMessage());
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
            $this->setAttributes($serviceMegalosService, $service);
        }
    }

    /**
     * Sets the attributes based on the provided service.
     * @param Service $service The service to extract attributes from
     */
    private function setAttributes(ServiceMegalosService $serviceMegalosService, $service)
    {
        // Get the fields to be set
        $fields = $serviceMegalosService->getAttributes();

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

}
