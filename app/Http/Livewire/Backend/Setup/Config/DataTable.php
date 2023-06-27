<?php

namespace App\Http\Livewire\Backend\Setup\Config;

use App\Services\Config\ConfigService;
use App\Services\Setting\SettingService;
use Livewire\Component;

class DataTable extends Component
{
    // Listen for the 'nasUpdated' event from other Livewire components
    protected $listeners = [
        'nasUpdated'                => 'handleUpdate',
        'clientUpdated'             => 'handleUpdate',
        'hotelRoomUpdatedUpdated'   => 'handleUpdate',
        'userDataUpdated'           => 'handleUpdate',
        'socialPluginUpdated'       => 'handleUpdate',
        'logActivityUpdated'       => 'handleUpdate',
    ];

    /**
     * Renders the dataTable for configuration.
     * @return \Illuminate\View\View The form view
     */
    public function render()
    {
        return view('livewire.backend.setup.config.data-table');
    }

    /**
     * Fetch data for the DataTable using the ConfigService
     * @param  mixed $configService
     */
    public function getDataTable(ConfigService $configService)
    {
        return $configService->getDatatables();
    }

    /**
     * Handle any update event, refreshing the datatable in each case.
     */
    public function handleUpdate()
    {
        $this->dispatchBrowserEvent('refreshDatatable');
    }

    /**
     * Updates the "LOG ACTIVITY" settings based on the provided $element value.
     * @param SettingService $settingService Service to handle settings operations.
     * @param boolean $element The value that determines the status of the setting.
     */
    public function updateActivity(SettingService $settingService, $element)
    {
        // Determine the status based on the $element value. If $element is false, set status to 0. Otherwise, set status to 1.
        $status = $element ? 1 : 0;

        // Call the SettingService to update the 'log_activities' setting with the determined status.
        $settingService->updateSetting('log_activities', 0, $status);
    }


}
