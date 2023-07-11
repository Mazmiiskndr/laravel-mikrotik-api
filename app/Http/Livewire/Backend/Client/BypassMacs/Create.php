<?php

namespace App\Http\Livewire\Backend\Client\BypassMacs;

use App\Helpers\MikrotikConfigHelper;
use App\Services\Client\BypassMacs\BypassMacsService;
use App\Services\MikrotikApi\MikrotikApiService;
use App\Traits\CloseModalTrait;
use App\Traits\LivewireMessageEvents;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Create extends Component
{
    // Traits LivewireMessageEvents and CloseModalTrait
    use LivewireMessageEvents;
    use CloseModalTrait;
    // Default Status for Bypassed Macs
    public $defaulStatus;
    // Properties Public For Create Bpassed Macs
    public $mikrotikId, $macAddress, $status, $description, $server = 'all';
    // For servers Selected In Create Bpassed Macs
    public $servers;

    // Listeners
    protected $listeners = [
        'bypassedMacCreated' => '$refresh',
        'blockedMacCreated' => '$refresh',
    ];

    /**
     * Mount the component.
     * @param MikrotikApiService $mikrotikApiService
     */
    public function mount(MikrotikApiService $mikrotikApiService)
    {
        $this->status = $this->defaulStatus;
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
        $this->validateOnly($property, $bypassMacsService->getRules(), $bypassMacsService->getMessages());
    }

    /**
     * Render the component `bypass-macs create form modal`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.bypass-macs.create');
    }

    /**
     * Store a new IP binding.
     * @param MikrotikApiService $mikrotikApiService
     * @return void
     */
    public function storeNewMac(MikrotikApiService $mikrotikApiService, BypassMacsService $bypassMacsService)
    {
        // Validate the form data before submit
        $this->validate($bypassMacsService->getRules(), $bypassMacsService->getMessages());

        // List of properties to include in the bypassMac
        $newBypassMac = $this->prepareBypassData();

        try {
            // Fetch and Validate Mikrotik Config
            $config = $this->fetchAndValidateMikrotikConfig();

            // Create the IP binding
            $this->mikrotikId = $mikrotikApiService->createMikrotikIpBinding(
                $config['ip'],
                $config['username'],
                $config['password'],
                $newBypassMac
            );
            $newBypassMac['mikrotikId'] = $this->mikrotikId;

            // Check for unsuccessful Mikrotik IpBinding Creation
            if (!$this->mikrotikId) {
                throw new \Exception('Failed to create Mikrotik IP binding');
            }

            // Attempt to create the new bypass mac
            $bypassMac = $bypassMacsService->storeNewBypassMac($newBypassMac);

            // Check if the bypass mac was created successfully
            if ($bypassMac === null) {
                throw new \Exception('Failed to create the bypass mac');
            }
            // Notify the frontend of success
            $this->dispatchSuccessEvent('Bypass mac was created successfully.');
            // Let other components know that an bypass mac was created
            if($this->defaulStatus == 'blocked'){
                $this->emit('blockedMacCreated', true);
            }else{
                $this->emit('bypassedMacCreated', true);
            }
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while creating bypass mac: ' . $th->getMessage());
        } finally {
            // Ensure the modal is closed
            $this->closeModal();
        }
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
        $this->mikrotikId = null;
        $this->macAddress = null;
        $this->description = null;
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
    protected function prepareBypassData(): array
    {
        // List of properties to include in the new bypass mac
        $properties = ['macAddress', 'status', 'description', 'server'];

        // Collect property values into an associative array
        return array_reduce($properties, function ($carry, $property) {
            $carry[$property] = $this->$property;
            return $carry;
        }, []);
    }
}
