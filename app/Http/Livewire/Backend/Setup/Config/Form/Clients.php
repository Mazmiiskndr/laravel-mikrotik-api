<?php

namespace App\Http\Livewire\Backend\Setup\Config\Form;

use App\Services\Config\Client\ClientService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class Clients extends Component
{
    use LivewireMessageEvents;

    // Declare public variables
    public $clientsVouchersPrinter = null, $createVouchersType = null;

    // Livewire properties
    protected $listeners = [
        'clientUpdated' => '$refresh',
        'resetForm' => 'resetForm',
    ];

    // Validation rules
    protected $rules = [
        // Required fields
        'clientsVouchersPrinter'  => 'required',
        'createVouchersType'      => 'required',
    ];


    // Validation messages
    protected $messages = [
        'clientsVouchersPrinter.required'   => 'Vouchers Printer cannot be empty!',
        'createVouchersType.required'       => 'Create Vouchers Type cannot be empty!',
    ];

    /**
     * Retrieves the CLIENT parameters using the ClientService and stores them
     * in the corresponding Livewire properties. Renders the edit-router view.
     *
     * @param  ClientService $clientService
     * @return \Illuminate\View\View
     */
    public function mount(ClientService $clientService)
    {
        $this->resetForm($clientService);
    }

    public function render()
    {
        return view('livewire.backend.setup.config.form.clients');
    }

    /**
     * updateClient
     *
     * @return void
     */
    public function updateClient(ClientService $clientService)
    {

        // Validate the form
        $this->validate();

        // Declare the public variable names
        $settings = [
            'clients_vouchers_printer' => $this->clientsVouchersPrinter,
            'create_vouchers_type' => $this->createVouchersType,
        ];

        try {
            // Update the client settings
            $clientService->updateClientSettings($settings);

            // Show Message Success
            $this->dispatchSuccessEvent('Client settings updated successfully.');
            // Emit the 'clientUpdated' event with a true status
            $this->emitUp('clientUpdated', true);
        } catch (\Throwable $th) {
            // Show Message Error
            $this->dispatchErrorEvent('An error occurred while updating client settings: ' . $th->getMessage());
        }

        // Close Modal
        $this->closeModal();
    }

    /**
     * closeModal
     *
     * @return void
     */
    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }

    /**
     * Retrieves the CLIENT parameters using the ClientService and stores them
     * in the corresponding Livewire properties. Renders the edit-router view.
     * @param  mixed $clientService
     * @return void
     */
    public function resetForm(ClientService $clientService)
    {
        // Get the CLIENT parameters using the ClientService
        $clients = $clientService->getClientParameters();

        // Convert the received data into an associative array and fill it into a Livewire variable
        foreach ($clients as $client) {
            switch ($client->setting) {
                case 'clients_vouchers_printer':
                    $this->clientsVouchersPrinter = $client->value;
                    break;
                case 'create_vouchers_type':
                    $this->createVouchersType = $client->value;
                    break;
            }
        }
    }

    /**
     * resetFields
     *
     * @return void
     */
    public function resetFields()
    {
        $this->clientsVouchersPrinter = null;
        $this->createVouchersType = null;
    }


}
