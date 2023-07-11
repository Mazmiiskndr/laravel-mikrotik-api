<?php

namespace App\Http\Livewire\Backend\Client\BypassMacs;

use App\Services\Client\BypassMacs\BypassMacsService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class DataTableBypassedMacs extends Component
{
    // Import trait for displaying messages from Livewire's events
    use LivewireMessageEvents;

    // Listeners
    protected $listeners = [
        'bypassMacCreated' => 'refreshDataTable',
        'bypassMacUpdated' => 'refreshDataTable',
        'confirmMac' => 'deleteMac',
        'deleteBatch'   => 'deleteBatchMac',
    ];

    /**
     * Render the component `data-table-bypassed-macs`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.bypass-macs.data-table-bypassed-macs');
    }

    /**
     * Get data `list-bypassed-macs` for the DataTable.
     * @param BypassMacsService $bypassMacsService Bypass Mac service instance
     * @return mixed
     */
    public function getDataTable(BypassMacsService $bypassMacsService)
    {
        return $bypassMacsService->getDatatableListBypassed();
    }

    /**
     * Refresh the DataTable when an bypass mac is created, updated and deleted.
     */
    public function refreshDataTable()
    {
        $this->dispatchBrowserEvent('refreshDatatable');
    }

}
