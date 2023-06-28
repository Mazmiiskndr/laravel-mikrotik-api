<?php

namespace App\Http\Livewire\Backend\Setup\Config\Form;

use App\Services\Config\Ads\AdsService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class Ads extends Component
{
    use LivewireMessageEvents;

    // Declare Public Variables
    public $ads_max_width, $ads_max_height, $ads_max_size, $ads_upload_folder, $ads_thumb_width,
            $ads_thumb_height, $mobile_ads_max_width, $mobile_ads_max_height, $mobile_ads_max_size;

    // Livewire properties
    protected $listeners = [
        'nasUpdated' => '$refresh',
        'resetForm' => 'resetForm',
    ];

    /**
     * Get the validation rules.
     * @return array
     */
    protected function rules()
    {
        $numericRules = 'required|numeric|min:1|max:9999';
        return [
            'ads_max_width' => $numericRules,
            'ads_max_height' => $numericRules,
            'ads_max_size' => $numericRules,
            'ads_upload_folder' => 'required',
            'ads_thumb_width' => $numericRules,
            'ads_thumb_height' => $numericRules,
            'mobile_ads_max_width' => $numericRules,
            'mobile_ads_max_height' => $numericRules,
            'mobile_ads_max_size' => $numericRules,
        ];
    }

    /**
     * Get the validation messages.
     * @return array
     */
    protected function messages()
    {
        $defaultMessages = [
            'required' => 'The :attribute field is required.',
            'numeric' => 'The :attribute field must be a number.',
            'min' => 'The :attribute field must be at least :min.',
            'max' => 'The :attribute field may not be greater than :max.',
        ];

        $customMessages = [
            'ads_upload_folder.required' => 'The Ads Upload Folder field is required.',
        ];

        return array_merge($defaultMessages, $customMessages);
    }

    /**
     * Mount the component.
     * @param AdsService $adsService
     * @return void
     */
    public function mount(AdsService $adsService)
    {
        // Reset the form and retrieve the ADS parameters
        $this->resetForm($adsService);
    }

    /**
     * Handle property updates.
     * @param mixed $property
     * @return void
     */
    public function updated($property)
    {
        // Validate the updated property
        $this->validateOnly($property);
    }

    /**
     * Render the component.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Render the view for the component
        return view('livewire.backend.setup.config.form.ads');
    }

    /**
     * Update the ADS settings.
     * @param AdsService $adsService
     * @return void
     */
    public function updateAds(AdsService $adsService)
    {
        // Validate the form fields
        $this->validate();

        // Declare the public variable names
        $variables = [
            'ads_max_width', 'ads_max_height', 'ads_max_size', 'ads_upload_folder', 'ads_thumb_width', 'ads_thumb_height',
            'mobile_ads_max_width', 'mobile_ads_max_height', 'mobile_ads_max_size'
        ];

        // Declare the settings
        $settings = [];

        // Fill the settings array with public variable values
        foreach ($variables as $variable) {
            $settings[$variable] = $this->$variable;
        }

        try {
            // Update the ads settings
            $adsService->updateAdsSettings($settings);
            // Show success message
            $this->dispatchSuccessEvent('Ads settings updated successfully.');
            // Emit the 'adsUpdated' event with a true status
            $this->emitUp('adsUpdated', true);
        } catch (\Throwable $th) {
            // Show error message
            $this->dispatchErrorEvent('An error occurred while updating ads settings: ' . $th->getMessage());
        } finally {
            // Close the modal
            $this->closeModal();
        }
    }

    /**
     * Close the modal.
     * @return void
     */
    public function closeModal()
    {
        // Reset the form for the next client
        $this->resetFields();
        // Emit the 'closeModal' event
        $this->emit('closeModal');
    }

    /**
     * Reset the form fields and retrieve the ADS parameters.
     * @param AdsService $adsService
     * @return void
     */
    public function resetForm(AdsService $adsService)
    {
        // Retrieve the ADS parameters using the AdsService
        /**
         * @var Ads $ads
         */
        $adsParameters = $adsService->getAdsParameters();

        // Convert the received data into an associative array and fill it into Livewire variables
        $this->setLivewireVariables($adsParameters);
    }

    /**
     * Reset the form fields.
     * @return void
     */
    public function resetFields()
    {
        $this->ads_max_width = '';
        $this->ads_max_height = '';
        $this->ads_max_size = '';
        $this->ads_upload_folder = '';
        $this->ads_thumb_width = '';
        $this->ads_thumb_height = '';
        $this->mobile_ads_max_width = '';
        $this->mobile_ads_max_height = '';
        $this->mobile_ads_max_size = '';
    }

    /**
     * Fill Livewire variables with ADS parameters.
     * @param mixed $adsParameters
     * @return void
     */
    private function setLivewireVariables($adsParameters)
    {
        foreach ($adsParameters as $ads) {
            if (property_exists($this, $ads->setting)) {
                $this->{$ads->setting} = $ads->value;
            }
        }
    }

}
