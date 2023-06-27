<?php

namespace App\Http\Livewire\Backend\Setup\Config\Form;

use App\Services\Setting\SettingService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class LogActivity extends Component
{
    use LivewireMessageEvents;

    // Declare public variables
    public $logActivity = null;

    // Livewire properties
    protected $listeners = [
        'logActivityUpdated' => '$refresh',
        'resetForm' => 'resetForm',
    ];

    // Validation rules
    protected $rules = [
        // Required fields
        'logActivity'  => 'required',
    ];

    // Validation messages
    protected $messages = [
        'logActivity.required'   => 'Log Activities cannot be empty!',
    ];

    /**
     * Mount the component.
     * @param SettingService $settingService
     * @return void
     */
    public function mount(SettingService $settingService)
    {
        $this->loadForm($settingService);
    }

    /**
     * Render the component.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.setup.config.form.log-activity');
    }

    /**
     * Updates the log activity settings.
     * @param  SettingService $settingService
     * @return void
     */
    public function updateActivity(SettingService $settingService)
    {
        $this->validate();
        try {
            // Update the LOG ACTIVITY settings
            $settingService->updateSetting('log_activities', 0, $this->logActivity);
            // Show Message Success
            $this->dispatchSuccessEvent('Log activities settings updated successfully.');
            // Emit the 'logActivityUpdated' event with a true status
            $this->emitUp('logActivityUpdated', true);
        } catch (\Throwable $th) {
            // Show Message Error
            $this->dispatchErrorEvent('An error occurred while updating log activities settings: ' . $th->getMessage());
        } finally {
            // Close Modal
            $this->closeModal();
        }
    }

    /**
     * Closes the modal window.
     * @return void
     */
    public function closeModal()
    {
        // Reset the form for the next client
        $this->resetFields();
        $this->emit('closeModal');
    }

    /**
     * Initializes the form using values from the SettingService.
     * @param  mixed $settingService
     * @return void
     */
    public function loadForm(SettingService $settingService)
    {
        // Get the Log Activities Parameters using the SettingService
        $this->logActivity = $settingService->getSetting('log_activities', '0');
    }

    /**
     * Resets the form fields.
     * @return void
     */
    public function resetFields()
    {
        $this->logActivity = null;
    }
}
