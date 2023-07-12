<?php

namespace App\Http\Livewire\Backend\Client\Voucher\List;

use App\Services\Client\Voucher\VoucherService;
use App\Services\ServiceMegalos\ServiceMegalosService;
use App\Traits\CloseModalTrait;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class Create extends Component
{
    // Traits LivewireMessageEvents and CloseModalTrait
    use LivewireMessageEvents, CloseModalTrait;

    // Properties Public For Create Clients
    public $services, $idService, $charactersLength, $quantity, $notes;

    // Listeners
    protected $listeners = [
        'voucherBatchCreated' => '$refresh',
    ];

    // Validation Rules
    protected $rules = [
        'idService'         => 'required',
        'charactersLength'  => 'required',
        'quantity'          => 'required|min:1|max:10|numeric',
        'notes'             => 'nullable'
    ];

    // Validation Messages
    protected $messages = [
        'idService.required'          => 'Service cannot be empty!',
        'charactersLength.required'   => 'Characters Length cannot be empty!',
        'quantity.min'                => 'Quantity must be at least 1!',
        'quantity.max'                => 'Quantity must be no more than 10!',
        'quantity.numeric'            => 'Quantity must be numeric!',
        'quantity.required'           => 'Quantity cannot be empty!'
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
        $this->validateOnly($property);
    }

    /**
     * Render the component `create new voucher-batch modal`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.voucher.list.create');
    }

    public function storeNewVoucherBatch(VoucherService $voucherService)
    {
        // Validate the form data before submit
        $this->validate();

        // List of properties to include in the voucher batch
        $newVoucherBatch = $this->prepareVoucherBatchData();

        try {
            // Attempt to create the new voucher batch
            $voucherBatch = $voucherService->storeNewVoucherBatch($newVoucherBatch);

            // Check if the voucher batch was created successfully
            if ($voucherBatch === null) {
                throw new \Exception('Failed to create the voucher batch');
            }
            // Notify the frontend of success
            $this->dispatchSuccessEvent('Voucher batch was created successfully.');
            // Let other components know that an voucher batch was created
            $this->emit('voucherBatchCreated', true);
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while creating voucher batch: ' . $th->getMessage());
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
        $this->charactersLength = null;
        $this->quantity = null;
        $this->notes = null;
    }

    /**
     * Prepares the voucher batch data for the update operation.
     * @return array
     */
    protected function prepareVoucherBatchData(): array
    {
        // List of properties to include in the new voucher batch
        $properties = ['idService', 'charactersLength', 'quantity', 'notes'];

        // Collect property values into an associative array
        return array_reduce($properties, function ($carry, $property) {
            $carry[$property] = $this->$property;
            return $carry;
        }, []);
    }
}
