<?php

namespace App\Http\Livewire\Backend\Setup\Ads;

use App\Services\Config\Ads\AdsService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class DataTable extends Component
{
    use LivewireMessageEvents;
    // Listeners
    protected $listeners = [
        'adCreated' => 'refreshDataTable',
        'adUpdated' => 'refreshDataTable',
        'confirmAd' => 'deleteAd',
    ];

    /**
     * Render the component `data-table`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.setup.ads.data-table');
    }

    /**
     * getDataTable
     * @param  mixed $adsService
     */
    public function getDataTable(AdsService $adsService)
    {
        return $adsService->getDatatables();
    }

    /**
     * handleAdCreated
     * Called when the 'refreshCreateDataTable' event is received
     * Dispatches the 'refreshDatatable' browser event to reload the DataTable
     * @return void
     */
    public function refreshDataTable()
    {
        $this->dispatchBrowserEvent('refreshDatatable');
    }

    /**
     * Delete an admin.
     *
     * @param AdsService $adsService Admin service instance
     * @param string $id Admin unique identifier
     */
    public function deleteAd(AdsService $adsService, $id)
    {

        try {
            // Attempt to delete the admin
            $adsService->deleteAd($id);

            // Notify the frontend of success
            $this->dispatchSuccessEvent('Admin successfully deleted.');

            // Refresh the data table
            $this->refreshDataTable();
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while deleting admin: ' . $th->getMessage());
        }
    }
}
