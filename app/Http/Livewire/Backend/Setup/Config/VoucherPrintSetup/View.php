<?php

namespace App\Http\Livewire\Backend\Setup\Config\VoucherPrintSetup;

use App\Services\Setting\SettingService;
use Livewire\Component;

class View extends Component
{
    // Public property for storing invoice instructions
    public $invoice = [], $logo = null;

    // Other properties
    public $vouchers_type;
    public $username = 'username';
    public $password = 'password';
    public $access_code = 'access_code';
    public $valid_until;
    public $time_limit = '2 Hours';
    public $serial_number = 'MGL00000001';

    // Event listener
    protected $listeners = [
        'voucherUpdated' => 'onVoucherUpdated',
        'logoUpdated' => 'onLogoUpdated',
    ];

    /**
     * Initializes the component.
     * Retrieves the setting 'how_to_use_voucher', 'voucher_logo_filename' and 'create_vouchers_type' using SettingService
     * and sets up the 'invoice', 'logo' and 'voucher_type properties.
     * @param SettingService $settingService The service used for retrieving application settings.
     * @return void
     */
    public function mount(SettingService $settingService)
    {
        $this->valid_until = date('d F Y', strtotime('+5 years'));
        $this->setupInvoice($settingService);
        $this->setupLogo($settingService);
        $this->setupType($settingService);
    }

    /**
     * Update the invoice data when the 'voucherUpdated' event is emitted
     * @param  array  $invoice  The updated invoice data
     * @return void
     */
    public function onVoucherUpdated($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Render the view for the component.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.setup.config.voucher-print-setup.view');
    }

    /**
     * Retrieves the setting 'how_to_use_voucher' using SettingService and sets up the 'invoice' property.
     * @param SettingService $settingService The service used for retrieving application settings.
     * @return void
     */
    protected function setupInvoice(SettingService $settingService)
    {
        // Retrieve the setting 'how_to_use_voucher'
        $howToUse = $settingService->getSetting('how_to_use_voucher', null);

        // Explode the string into an array based on comma
        $howToUseArray = explode(',', $howToUse);

        // Map the array into the desired format for invoice
        $this->invoice = array_map(function ($item) {
            return ['name' => $item];
        }, $howToUseArray);
    }

    /**
     * Retrieves the setting 'voucher_logo_filename' using SettingService and sets up the 'logo' property.
     * @param SettingService $settingService The service used for retrieving application settings.
     * @return void
     */
    protected function setupLogo(SettingService $settingService)
    {
        $this->logo = $settingService->getSetting('voucher_logo_filename', null);
    }

    /**
     * Retrieves the setting 'create_vouchers_type' using SettingService and sets up the 'logo' property.
     * @param SettingService $settingService The service used for retrieving application settings.
     * @return void
     */
    protected function setupType(SettingService $settingService)
    {
        $this->vouchers_type = $settingService->getSetting('create_vouchers_type', null);
    }

    /**
     * Updates the 'logo' property when the 'logoUpdated' event is emitted
     * @param SettingService $settingService The service used for retrieving application settings.
     * @return void
     */
    public function onLogoUpdated(SettingService $settingService)
    {
        $this->setupLogo($settingService);
    }
}
