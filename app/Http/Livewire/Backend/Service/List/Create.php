<?php

namespace App\Http\Livewire\Backend\Service\List;

use App\Services\ServiceMegalos\ServiceMegalosService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class Create extends Component
{
    // Traits LivewireMessageEvents for show modal and toast message
    use LivewireMessageEvents;
    // Properties Public For Create New Service
    public $serviceName, $description, $downloadRate, $uploadRate, $idleTimeout, $sessionTimeout,
        $serviceCost, $currency = "IDR", $simultaneousUse, $downloadBurstRate, $uploadBurstRate,
        $downloadBurstTime, $uploadBurstTime, $priority, $limitType, $timeLimit, $unitTime = "minutes", $validFrom, $validityType = "none",
        $validity, $unitValidity = "days", $timeDuration, $unitTimeDuration = "hours", $enableFeature;

    // Listeners for refresh component
    protected $listeners = [
        'createdService' => '$refresh',
    ];

    /**
     * Handle property updates.
     * @param string $property
     * @return void
     */
    public function updated($property)
    {
        // Every time a property changes, this function will be called
        $serviceMegalosService = app(ServiceMegalosService::class);
        $this->validateOnly($property, $serviceMegalosService->getRules($this), $serviceMegalosService->getMessages());
    }

    /**
     * Render the component `create new service form`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.service.list.create');
    }

    /**
     * Stores a new service, validates the form, resets fields, and emits 'serviceCreated' event.
     * @param ServiceMegalosService $serviceMegalosService - Service for handling service-related logic.
     * @return redirect - On success, redirects to 'list-services' route with success message.
     */
    public function storeNewService(ServiceMegalosService $serviceMegalosService)
    {
        // Validate Form Request
        $newService = $this->validate($serviceMegalosService->getRules($this), $serviceMegalosService->getMessages());

        // Format serviceName: remove spaces and capitalize each word
        $newService['serviceName'] = ucwords(strtolower($newService['serviceName']));
        try {
            // Call the storeNewService function in the repository
            $serviceMegalosService->storeNewService($newService);
            // Reset the form fields
            $this->resetFields();
            // Emit the 'serviceCreated' event with a true status
            $this->emit('serviceCreated', true);
            return redirect()->route('backend.services.list-services')->with('success', 'Service was created successfully.');
        } catch (\Throwable $th) {
            // Show Message Error
            $this->dispatchErrorEvent('An error occurred while creating service : ' . $th->getMessage());
        }
    }

    /**
     * Reset all fields to their default state.
     * @return void
     */
    public function resetFields()
    {
        // Reset the form fields
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
