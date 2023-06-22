<?php

namespace App\Http\Livewire\Backend\Client\List;

use App\Services\Client\ClientService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class DataTable extends Component
{
    // Import trait for displaying messages from Livewire's events
    use LivewireMessageEvents;

    // Listeners
    protected $listeners = [
        'clientCreated' => 'refreshDataTable',
        'clientUpdated' => 'refreshDataTable',
        'confirmClient' => 'deleteClient',
        'deleteBatch'   => 'deleteBatchClient',
    ];

    /**
     * Render the component `data-table`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.list.data-table');
    }

    /**
     * Get data `clients` for the DataTable.
     * @param ClientService $clientService Client service instance
     * @return mixed
     */
    public function getDataTable(ClientService $clientService)
    {
        return $clientService->getDatatables();
    }

    /**
     * Refresh the DataTable when an client is created or updated.
     */
    public function refreshDataTable()
    {
        $this->dispatchBrowserEvent('refreshDatatable');
    }

    /**
     * Deletes multiple clients using their UIDs.
     * @param ClientService $clientService
     * @param array $clientUids
     * @return void
     */
    public function deleteBatchClient(ClientService $clientService, $clientUids)
    {
        try {
            // Loop through all client UIDs and delete each client's data.
            foreach ($clientUids as $clientUid) {
                $clientService->deleteClientData($clientUid);
            }

            // Notify the frontend of success
            $this->dispatchSuccessEvent('Clients successfully deleted.');

            // Refresh the data table
            $this->refreshDataTable();
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while deleting clients : ' . $th->getMessage());
        }
    }

    /**
     * Deletes a single client using its UID.
     * @param ClientService $clientService
     * @param string $clientUid
     * @return void
     */
    public function deleteClient(ClientService $clientService, $clientUid)
    {
        try {
            // Loop through all client UID and delete each client's data.
            $clientService->deleteClientData($clientUid);

            // Notify the frontend of success
            $this->dispatchSuccessEvent('Client successfully deleted.');

            // Refresh the data table
            $this->refreshDataTable();
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while deleting client : ' . $th->getMessage());
        }
    }
}
