<?php

namespace App\Http\Livewire\Backend\Client\Voucher\List;

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
    public $services, $idService, $charactersLength, $quantity, $notes;

    // Validation Rules
    protected $rules = [
        'idService'         => 'required',
        'charactersLength'  => 'required',
        'quantity'          => 'required',
        'notes'             => 'nullable'
    ];

    // Validation Messages
    protected $messages = [
        'idService.required'          => 'Service cannot be empty!',
        'charactersLength.required'   => 'Characters Length cannot be empty!',
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
     * Render the component `create new voucher-batch modal`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.voucher.list.create');
    }

    public function storeNewVoucherBatch()
    {
        $this->validate();
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
}
