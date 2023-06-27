<?php

namespace App\Http\Livewire\Backend\Setup\Config\Form;

use App\Services\Nas\NasService;
use App\Traits\LivewireMessageEvents;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EditRouter extends Component
{
    use LivewireMessageEvents;

    // Public properties
    public $nas_id, $server_ip_address, $mikrotik_ip_address, $mikrotik_api_port, $ports, $secret, $temporary_username, $temporary_password;

    // Livewire properties
    protected $listeners = [
        'nasUpdated' => '$refresh',
        'resetForm' => 'resetForm',
    ];


    // Validation rules
    protected $rules = [
        // Nullable fields
        'server_ip_address'     => 'nullable|ip',
        'mikrotik_ip_address'   => 'nullable|ip',
        'temporary_password'    => 'nullable',

        // Required fields
        'mikrotik_api_port'     => 'required|integer|min:1|max:99999',
        'ports'                 => 'required|integer|min:1|max:99999',
        'secret'                => 'required',
        'temporary_username'    => 'required',
    ];

    // Validation messages
    protected $messages = [
        'server_ip_address.ip'          => 'Must be a valid Server IP address!',
        'mikrotik_ip_address.ip'        => 'Must be a valid Mikrotik IP address!',
        'mikrotik_api_port.required'    => 'API Port cannot be empty!',
        'mikrotik_api_port.integer'     => 'API Port must be an integer!',
        'mikrotik_api_port.min'         => 'API Port must be at least 1!',
        'mikrotik_api_port.max'         => 'API Port must be no more than 99999!',
        'ports.required'                => 'Radius Port cannot be empty!',
        'ports.integer'                 => 'Radius Port must be an integer!',
        'ports.min'                     => 'Radius Port must be at least 1!',
        'ports.max'                     => 'Radius Port must be no more than 99999!',
        'secret.required'               => 'Radius Secret cannot be empty!',
        'temporary_username.required'   => 'Temporary Username cannot be empty!',
    ];

    /**
     * Handles the component initialization.
     * @param  NasService $nasService
     * @return void
     */
    public function mount(NasService $nasService)
    {
        $this->resetForm($nasService);
    }

    /**
     * Handles updates to Livewire properties.
     * @param  string $property
     * @return void
     */
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    /**
     * Renders the component.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.setup.config.form.edit-router');
    }

    /**
     * Closes the modal window.
     * @return void
     */
    public function closeModal()
    {
        // Reset the form for the next client
        $this->resetFields();
        $this->dispatchBrowserEvent('closeModal');
    }

    /**
     * Handles the form submission.
     * @param  NasService $nasService
     * @return void
     */
    public function updateRouter(NasService $nasService)
    {
        // We first validate the form data against the specified rules
        $this->validate();

        // We get the current NAS parameters from the NasService
        $nas = $nasService->getNasParameters();

        // We prepare the data for the update process
        $data = $this->prepareData($nas);

        // We process the update, passing in the NasService instance, the current NAS, and the prepared data
        $this->processUpdate($nasService, $nas, $data);
    }

    /**
     * Resets the form.
     * @param  NasService $nasService
     * @return void
     */
    public function resetForm(NasService $nasService)
    {
        $nas = $nasService->getNasParameters();
        $this->setNasProperties($nas);
    }

    /**
     * Prepares the data for the update.
     * @param  $nas
     * @return array
     */
    protected function prepareData($nas): array
    {
        return [
            'id' => $this->nas_id,
            'mikrotikIP' => $this->mikrotik_ip_address,
            'mikrotikAPIPort' => $this->mikrotik_api_port,
            'serverIP' => $this->server_ip_address,
            'radiusPort' => $this->ports,
            'radiusSecret' => $this->secret,
            'tempUsername' => $this->temporary_username,
            'tempPassword' => $this->temporary_password,
            'username' => env('MIKROTIK_NAME'),
            'password' => Hash::make(env('MIKROTIK_NAME')),
            'groupname' => env('MIKROTIK_NAME'),
            'serverDomain' => env('MGL_SPLASH_DOMAIN'),
        ];
    }

    /**
     * Processes the form submission.
     * @param  NasService $nasService
     * @param  $nas
     * @param  array $data
     * @return void
     */
    protected function processUpdate(NasService $nasService, $nas, array $data): void
    {
        // We wrap the process in a try-catch block to handle any exceptions
        try {
            // Call the setupProcess method from NasService, passing in the current NAS and data
            $mikrotikStatus = $nasService->setupProcess($nas, $data);

            // If the Mikrotik setup process was successful...
            if ($mikrotikStatus['status']) {
                // ...we attempt to edit the NAS settings
                $status = $nasService->editNasProcess($data);

                // If the NAS settings were successfully updated...
                if ($status) {
                    // ...we handle the success case
                    $this->handleSuccess();
                } else {

                    $this->handleError('An error occurred while updating router settings.');
                    // ...otherwise, we handle the error case
                }
            } else {
                if ($mikrotikStatus['message']) {
                    // If the Mikrotik setup process was not successful, we handle the error case
                    $this->handleError('An error occurred : ' . $mikrotikStatus['message']);
                }
            }
        } catch (\Throwable $th) {
            // If any exceptions were thrown during the process, we handle the error case
            $this->handleError('An error occurred while updating router settings : ' . $th->getMessage());
        } finally {
            // Regardless of the outcome, we close the modal after the process
            $this->closeModal();
        }
    }

    /**
     * Sets the NAS properties.
     * @param  $nas
     * @return void
     */
    protected function setNasProperties($nas): void
    {
        $this->nas_id = $nas->id ? $nas->id : 1;
        $this->server_ip_address = $nas->server_ip ? $nas->server_ip : '';
        $this->mikrotik_ip_address = $nas->mikrotik_ip ? $nas->mikrotik_ip : '';
        $this->mikrotik_api_port = $nas->mikrotik_api_port ? $nas->mikrotik_api_port : '8728';
        $this->ports = $nas->ports;
        $this->secret = strtoupper(str()->random(8));
    }

    /**
     * Handles a successful form submission.
     * @return void
     */
    protected function handleSuccess(): void
    {
        $this->dispatchSuccessEvent('Router settings updated successfully.');
        $this->closeModal();
        $this->resetFields();
        $this->emitUp('nasUpdated', true);
    }

    /**
     * Handles an error during form submission.
     * @param  string $message
     * @return void
     */
    protected function handleError(string $message): void
    {
        $this->dispatchErrorEvent($message);
        $this->closeModal();
        $this->resetFields();
    }

    /**
     * Clears the form fields.
     * @return void
     */
    public function resetFields()
    {
        $this->server_ip_address = '';
        $this->mikrotik_ip_address = '';
        $this->temporary_username = '';
        $this->temporary_password = '';
    }
}
