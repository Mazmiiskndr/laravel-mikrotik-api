<?php

namespace App\Http\Livewire\Backend\Client\BypassMacs;

use App\Helpers\MikrotikConfigHelper;
use App\Services\Client\BypassMacs\BypassMacsService;
use App\Services\MikrotikApi\MikrotikApiService;
use App\Traits\CloseModalTrait;
use App\Traits\LivewireMessageEvents;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Edit extends Component
{
    // Traits LivewireMessageEvents and CloseModalTrait
    use LivewireMessageEvents;
    use CloseModalTrait;
    // Default Status for Bypassed Macs
    public $defaulStatus;
    // Properties Public For Create Bpassed Macs
    public $bypassMacId, $mikrotikId, $macAddress, $status, $description, $server;
    // For servers Selected In Create Bpassed Macs
    public $servers;

    // Listeners
    protected $listeners = [
        'getBypassMac' => 'showBypassMac',
        'bypassedMacUpdated' => '$refresh',
    ];

    /**
     * Mount the component.
     * @param MikrotikApiService $mikrotikApiService
     */
    public function mount(MikrotikApiService $mikrotikApiService)
    {
        $this->servers = $this->getServers($mikrotikApiService);
    }

    /**
     * Handle property updates.
     * @param string $property
     * @return void
     */
    public function updated($property)
    {
        // Every time a property changes, this function will be called
        $bypassMacsService = app(BypassMacsService::class);
        $this->validateOnly($property, $bypassMacsService->getRules($this->bypassMacId), $bypassMacsService->getMessages());
    }

    /**
     * Render the component `bypass-mac edit form modal`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.bypass-macs.edit');
    }

    /**
     * Validates the request and attempts to update bypass mac using the provided BypassMacsService.
     * Also handles events, form reset, and modal closure post operation.
     * @param  \App\Services\BypassMacsService $bypassMacsService
     * @throws \Throwable If there is an error while creating the bypass mac.
     * @return void
     */
    public function updateMac(BypassMacsService $bypassMacsService)
    {
        // Validate the form data before submit
        $this->validate($bypassMacsService->getRules($this->bypassMacId), $bypassMacsService->getMessages());

        // List of properties to include in the bypass mac
        $bypassMacData = $this->prepareBypassMacData();

        try {
            // Attempt to update the bypass mac
            $bypassMac = $bypassMacsService->updateBypassMac($this->bypassMacId, $bypassMacData);

            // Check if the bypass mac was updated successfully
            if ($bypassMac === null) {
                throw new \Exception('Failed to update the bypass mac');
            }
            // Notify the frontend of success
            $this->dispatchSuccessEvent('Bypass mac was successfully updated.');
            if($this->defaulStatus == 'blocked'){
                // Let other components know that an bypass mac was updated
                $this->emit('blockedMacUpdated', true);
            }else{
                // Let other components know that an bypass mac was updated
                $this->emit('bypassedMacUpdated', true);
            }
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while updating bypass mac: ' . $th->getMessage());
        } finally {
            // Ensure the modal is closed
            $this->closeModal();
        }
    }

    /**
     * Load bypass mac data into the component.
     * This function is called when the 'showBypassMac' event is mounted.
     * @param  \App\Services\BypassMacsService  $bypassMacsService The service to use to fetch the bypass mac.
     * @param  int  $bypassMacId The ID of the bypass mac to load.
     * @return void
     */
    public function showBypassMac(BypassMacsService $bypassMacsService,$bypassMacId)
    {
        // Fetch the bypass mac using the provided service
        $bypassMac = $bypassMacsService->getBypassMacId($bypassMacId);
        // If a bypass mac was found, load the bypass mac's data into the component's properties
        if ($bypassMac) {
            $this->populateBypassMacData($bypassMac);
        }
        $this->dispatchBrowserEvent('show-modal');
    }

    /**
     * Method to retrieve Mikrotik servers using Mikrotik API service.
     * @param MikrotikApiService $mikrotikApiService
     * @return array
     */
    public function getServers(MikrotikApiService $mikrotikApiService)
    {
        try {
            // Fetch and Validate Mikrotik Config
            $config = $this->fetchAndValidateMikrotikConfig();

            // Retrieve data servers from Mikrotik router using Mikrotik API Router Os Api servers.
            $serverNames = $mikrotikApiService->getMikrotikHotspotServers($config['ip'], $config['username'], $config['password']);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Failed to get Mikrotik hotspot servers data: ' . $e->getMessage());

            // If no servers are found, initialize an empty array
            $serverNames = [];
        }

        // Combine the keys and values to form an associative array
        $serverNames = array_combine($serverNames, $serverNames);

        // Make sure 'all' is always the first element.
        $serverNames = ['all' => 'All'] + $serverNames;

        return $serverNames;
    }

    /**
     * Reset all fields to their default state.
     * @return void
     */
    public function resetFields()
    {
        $this->bypassMacId = null;
        $this->mikrotikId = null;
        $this->macAddress = null;
        $this->description = null;
    }

    /**
     * Populate the component's properties with the bypass mac's data.
     * @param  object  $bypassMac
     */
    protected function populateBypassMacData($bypassMac)
    {
        $this->bypassMacId = $bypassMac->id;
        $this->server = $bypassMac->server;
        $this->description = $bypassMac->description;
        $this->status = $bypassMac->status;
        $this->macAddress = $bypassMac->mac_address;
        $this->mikrotikId = $bypassMac->mikrotik_id;
    }

    /**
     * Fetches Mikrotik configuration settings and validates them.
     * @throws \Exception if the Mikrotik configuration settings are invalid.
     * @return array An associative array containing Mikrotik configuration settings if they are valid.
     */
    protected function fetchAndValidateMikrotikConfig()
    {
        // Retrieve the Mikrotik configuration settings.
        $config = MikrotikConfigHelper::getMikrotikConfig();

        // Check if the configuration exists and no values are empty.
        if (!$config || in_array("", $config, true)) {
            throw new \Exception("Invalid Mikrotik configuration settings.");
        }

        return $config;
    }

    /**
     * Prepares the bypass macs data for the update operation.
     * @return array
     */
    protected function prepareBypassMacData(): array
    {
        // List of properties to include in the new bypass mac
        $properties = ['mikrotikId','macAddress', 'status', 'description', 'server'];

        // Collect property values into an associative array
        return array_reduce($properties, function ($carry, $property) {
            $carry[$property] = $this->$property;
            return $carry;
        }, []);
    }
}
