<?php

namespace App\Http\Livewire\Backend\Setup\Config\VoucherPrintSetup;

use App\Services\Setting\SettingService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class Form extends Component
{
    use LivewireMessageEvents;

    // Public property for storing invoice instructions
    public $invoice = [];

    // Listeners
    protected $listeners = [
        'voucherUpdated' => '$refresh',
    ];

    // Validation rules for the invoice property
    protected $rules = [
        // Each item in the invoice array must have a 'name' property that is required and a string
        'invoice.0.name' => ['required', 'string', 'max:30'],
        'invoice.*.name' => ['string', 'max:30'],
    ];

    // Validation messages for the invoice property
    protected $messages = [
        // Each item in the invoice array must have a 'name' property that is required and a string
        'invoice.0.name.required' => "The invoice field is required",
        'invoice.*.name.string'   => "The invoice field must be a string",
        'invoice.*.name.max'      => "The invoice field may not be greater than 30 characters",
    ];

    /**
     * Initializes the component.
     * Retrieves the setting 'how_to_use_voucher' using SettingService and sets up the 'invoice' property.
     * @param SettingService $settingService The service used for retrieving application settings.
     * @return void
     */
    public function mount(SettingService $settingService)
    {
        $howToUse = $settingService->getSetting('how_to_use_voucher', null);

        // Explode the string into an array based on comma
        $howToUseArray = explode(',', $howToUse);

        // Map the array into the desired format for invoice
        $this->invoice = array_map(function ($item) {
            return ['name' => $item];
        }, $howToUseArray);
        // Emit the event with default data
        $this->emit('voucherUpdated', $this->invoice);
    }

    /**
     * Handle property updates.
     * @param string $property
     * @return void
     */
    public function updated($property)
    {
        // Every time a property changes
        // (only `text` for now), validate it
        $this->validateOnly($property);
    }

    /**
     * Renders the component's view.
     * @return \Illuminate\View\View The view of the component
     */
    public function render()
    {
        return view('livewire.backend.setup.config.voucher-print-setup.form');
    }

    /**
     * Function to add a new invoice field to the list.=
     */
    public function addInvoiceField()
    {
        // Check if the current count of invoice fields is less than 5
        if (count($this->invoice) < 5) {
            // Add a new invoice field with an empty name
            $this->invoice[] = ['name' => ''];
        } else {
            // Flash an error message indicating the maximum number of fields has been reached
            session()->flash('error', 'Maximum of 5 invoices reached');
        }
    }

    /**
     * Function to remove an invoice field at a specific index.=
     * @param integer $index The index of the field to remove
     */
    public function removeInvoiceField($index)
    {
        // Remove the invoice field at the provided index
        unset($this->invoice[$index]);

        // Reindex the invoice fields to maintain sequential keys
        $this->invoice = array_values($this->invoice);
    }

    /**
     * Validates and updates the voucher.
     * @param SettingService $settingService The service used for updating table settings.
     * @return void
     */
    public function updateVoucher(SettingService $settingService)
    {
        // Validate the 'invoice' property using the defined validation rules
        $this->validate();

        try {
            // Convert the 'invoice' array back into a string
            $howToUseString = implode(',', array_map(function ($item) {
                return $item['name'];
            }, $this->invoice));

            // Use the SettingService to update the 'how_to_use_voucher' setting in the database
            $settingService->updateSetting('how_to_use_voucher',null,$howToUseString);

            // Emit a 'voucherUpdated' event with the new 'invoice' data
            $this->emit('voucherUpdated', $this->invoice);
            // Show Success Message
            $this->dispatchSuccessEvent('Voucher updated successfully.');
        } catch (\Exception $e) {
            // Show Error Message
            $this->dispatchErrorEvent('An error occurred while updating voucher: ' . $e->getMessage());
        }
    }

    /**
     * This PHP function emits an event called "voucherUpdated" with the invoice data as a parameter.
     */
    public function updatedInvoice()
    {
        $this->emit('voucherUpdated', $this->invoice);
    }
}
