<?php

namespace App\Http\Livewire\Backend\Client\List;

use App\Services\Client\ClientService;
use App\Services\ServiceMegalos\ServiceMegalosService;
use App\Traits\CloseModalTrait;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class Edit extends Component
{
    // Traits LivewireMessageEvents and CloseModalTrait
    use LivewireMessageEvents;
    use CloseModalTrait;

    // Properties Public For Create Clients
    public $clientId, $idService, $username, $password, $simultaneousUse, $validFrom, $validTo,
        $identificationNo, $emailAddress, $firstName, $lastName, $placeOfBirth,
        $dateOfBirth, $phone, $address, $notes;

    // For Services Selected In Create Clients
    public $services;

    // Listeners
    protected $listeners = [
        'getClient' => 'showClient',
        'clientUpdated' => '$refresh',
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
        $this->validateOnly($property, $clientService->getRules($this->clientId), $clientService->getMessages());
    }

    /**
     * Render the component `client edit form modal`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.list.edit');
    }

    /**
     * Validates the request and attempts to update client using the provided ClientService.
     * Also handles events, form reset, and modal closure post operation.
     * @param  \App\Services\ClientService  $clientService
     * @throws \Throwable If there is an error while creating the client.
     * @return void
     */
    public function updateClient(ClientService $clientService)
    {
        // Validate the form data before submit
        $this->validate($clientService->getRules($this->clientId), $clientService->getMessages());

        // List of properties to include in the client
        $clientData = $this->prepareClientData();

        try {
            // Attempt to update the client
            $client = $clientService->updateClient($this->clientId, $clientData);

            // Check if the client was updated successfully
            if ($client === null) {
                throw new \Exception('Failed to update the client');
            }
            // Notify the frontend of success
            $this->dispatchSuccessEvent('Client was successfully updated.');
            // Let other components know that an client was updated
            $this->emit('clientUpdated',true);
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while updating client: ' . $th->getMessage());
        } finally {
            // Ensure the modal is closed
            $this->closeModal();
        }
    }

    /**
     * Reset all fields to their default state.
     *
     * @return void
     */
    public function resetFields()
    {
        $this->clientId = null;
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

    /**
     * Load client data into the component.
     * This function is called when the 'showClient' event is mounted.
     * @param  \App\Services\ClientService  $clientService The service to use to fetch the client.
     * @param  int  $clientId The ID of the client to load.
     * @return void
     */
    public function showClient(ClientService $clientService, $clientId)
    {
        // Fetch the client using the provided service
        $client = $clientService->getClientById($clientId);
        // If a client was found, load the client's data into the component's properties
        if ($client) {
            $this->populateClientData($client);
        }
        $this->dispatchBrowserEvent('show-modal');
    }

    /**
     * Prepares the client data for the update operation.
     * @return array
     */
    protected function prepareClientData(): array
    {
        // List of properties to include in the update client
        $clientProperties = [
            'idService', 'username', 'password', 'simultaneousUse', 'validFrom', 'validTo',
            'identificationNo', 'emailAddress', 'firstName', 'lastName', 'placeOfBirth',
            'dateOfBirth', 'phone', 'address', 'notes'
        ];

        // Return Collect property values into an associative array
        return array_reduce($clientProperties, function ($carry, $property) {
            $carry[$property] = $this->$property;
            return $carry;
        }, []);
    }

    /**
     * Populate the component's properties with the client's data.
     * @param  object  $client
     */
    protected function populateClientData($client)
    {
        $this->clientId = $client->id;
        $this->idService = $client->service_id;
        $this->username = $client->username;
        $this->password = $client->password;
        $this->simultaneousUse = ($client->simultaneous_use != 0 || !empty($client->simultaneous_use)) ? $client->simultaneous_use : null;
        $this->validFrom = ($client->validfrom != 0 || !empty($client->validfrom)) ? date('Y-m-d H:i', $client->validfrom) : null;
        $this->validTo = ($client->valid_until != 0 || !empty($client->valid_until)) ? date('Y-m-d H:i', $client->valid_until) : null;
        $this->identificationNo = $client->identification;
        $this->emailAddress = $client->email;
        $this->firstName = $client->first_name;
        $this->lastName = $client->last_name;
        $this->placeOfBirth = $client->birth_place;
        $this->dateOfBirth = (strtotime($client->birth_date) != 0 || !empty($client->birth_date)) ? date('Y-m-d', strtotime($client->birth_date)) : null;
        $this->phone = $client->phone;
        $this->address = $client->address;
        // dd($client->note);
        $this->notes = $client->note;
    }

}
