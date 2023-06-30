<?php

namespace App\Http\Livewire\Backend\Client\List;

use App\Services\Client\ClientService;
use App\Services\ServiceMegalos\ServiceMegalosService;
use App\Traits\CloseModalTrait;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class Create extends Component
{
    // Traits LivewireMessageEvents and CloseModalTrait
    use LivewireMessageEvents;
    use CloseModalTrait;

    // Properties Public For Create Clients
    public $idService, $username, $password, $simultaneousUse, $validFrom, $validTo,
            $identificationNo, $emailAddress, $firstName, $lastName, $placeOfBirth,
            $dateOfBirth, $phone, $address, $notes;

    // For Services Selected In Create Clients
    public $services;

    // Listeners
    protected $listeners = [
        'clientCreated' => '$refresh',
    ];

    /**
     * Mount the component.
     * @param ServiceMegalosService $serviceMegalosService
     */
    public function mount(ServiceMegalosService $serviceMegalosService)
    {
        // Get services from the database
        $this->services = $serviceMegalosService->getServices();
    }

    /**
     * Handle property updates.
     * @param string $property
     * @return void
     */
    public function updated($property)
    {
        // Every time a property changes, this function will be called
        $clientService = app(ClientService::class);
        $this->validateOnly($property, $clientService->getRules(), $clientService->getMessages());
    }

    /**
     * Render the component `client create form modal`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.list.create');
    }

    /**
     * Validates the request and attempts to store a new client using the provided ClientService.
     * Also handles events, form reset, and modal closure post operation.
     * @param  \App\Services\ClientService  $clientService
     * @throws \Throwable If there is an error while creating the client.
     * @return void
     */
    public function storeNewClient(ClientService $clientService)
    {
        // Validate the form data before submit
        $this->validate($clientService->getRules(), $clientService->getMessages());

        // List of properties to include in the new client
        $properties = [
            'idService', 'username', 'password', 'simultaneousUse', 'validFrom', 'validTo',
            'identificationNo', 'emailAddress', 'firstName', 'lastName', 'placeOfBirth',
            'dateOfBirth', 'phone', 'address', 'notes'
        ];

        // Collect property values into an associative array
        $newClient = array_reduce($properties, function ($carry, $property) {
            $carry[$property] = $this->$property;
            return $carry;
        }, []);

        try {
            // Attempt to create the new client
            $client = $clientService->storeNewClient($newClient);

            // Check if the client was created successfully
            if ($client === null) {
                throw new \Exception('Failed to create the client');
            }

            // Notify the frontend of success
            $this->dispatchSuccessEvent('Client was created successfully.');

            // Reset the form for the next client
            $this->resetFields();

            // Let other components know that an client was created
            $this->emit('clientCreated', true);
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while creating client: ' . $th->getMessage());
        } finally {
            // Ensure the modal is closed
            $this->closeModal();
        }
    }

    /**
     * Reset all fields to their default state.
     * @return void
     */
    public function resetFields()
    {
        $this->idService = null;
        $this->username = null;
        $this->password = null;
        $this->simultaneousUse = null;
        $this->validFrom = null;
        $this->validTo = null;
        $this->identificationNo = null;
        $this->emailAddress = null;
        $this->firstName = null;
        $this->lastName = null;
        $this->placeOfBirth = null;
        $this->dateOfBirth = null;
        $this->phone = null;
        $this->address = null;
        $this->notes = null;
    }
}
