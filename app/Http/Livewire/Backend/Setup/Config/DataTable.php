<?php

namespace App\Http\Livewire\Backend\Setup\Config;

use App\Services\Config\ConfigService;
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

}
