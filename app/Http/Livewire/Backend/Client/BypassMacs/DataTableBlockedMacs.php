<?php

namespace App\Http\Livewire\Backend\Client\BypassMacs;

use App\Services\Client\BypassMacs\BypassMacsService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class DataTableBlockedMacs extends Component
{
    // Import trait for displaying messages from Livewire's events
    use LivewireMessageEvents;

    // Listeners
    protected $listeners = [
        'blockedMacCreated' => 'refreshDataTable',
        'blockedMacUpdated' => 'refreshDataTable',
        'confirmMac' => 'deleteMac',
        'deleteBatch'   => 'deleteBatchMacs',
    ];

    /**
     * Render the component `data-table-blocked-macs`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.bypass-macs.data-table-blocked-macs');
    }

    /**
     * Get data `list-blocked-macs` for the DataTable.
     * @param BypassMacsService $bypassMacsService Bypass Mac service instance
     * @return mixed
     */
    public function getDataTable(BypassMacsService $bypassMacsService)
    {
        return $bypassMacsService->getDatatable('blocked');
    }

    /**
     * Refresh the DataTable when an bypass mac is created, updated and deleted.
     */
    public function refreshDataTable()
    {
        $this->dispatchBrowserEvent('refreshDatatable');
    }

    /**
     * Deletes multiple bypass macs using their UIDs.
     * @param BypassMacsService $bypassMacsService
     * @param array $bypassMacIds
     * @return void
     */
    public function deleteBatchMacs(BypassMacsService $bypassMacsService, $bypassMacIds)
    {
        try {
            // Loop through all bypass mac UIDs and delete each bypass mac's data.
            foreach ($bypassMacIds as $bypassMacId) {
                $bypassMacsService->deleteBypassMac($bypassMacId);
            }

            // Notify the frontend of success
            $this->dispatchSuccessEvent('Bypass macs successfully deleted.');

            // Refresh the data table
            $this->refreshDataTable();
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while deleting bypass macs : ' . $th->getMessage());
        }
    }

    /**
     * Deletes a single bypass mac using its UID.
     * @param BypassMacsService $bypassMacsService
     * @param string $bypassMacId
     * @return void
     */
    public function deleteMac(BypassMacsService $bypassMacsService, $bypassMacId)
    {
        try {
            // Loop through all bypass mac UID and delete each bypass mac's data.
            $bypassMacsService->deleteBypassMac($bypassMacId);

            // Notify the frontend of success
            $this->dispatchSuccessEvent('Bypass Mac successfully deleted.');

            // Refresh the data table
            $this->refreshDataTable();
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while deleting bypass mac : ' . $th->getMessage());
        }
    }
}
