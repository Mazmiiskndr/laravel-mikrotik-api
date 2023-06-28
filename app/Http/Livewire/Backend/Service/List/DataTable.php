<?php

namespace App\Http\Livewire\Backend\Service\List;

use App\Services\ServiceMegalos\ServiceMegalosService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class DataTable extends Component
{
    use LivewireMessageEvents;

    // Listeners
    protected $listeners = [
        'confirmService' => 'deleteService',
        'serviceUpdated' => 'refreshDataTable',
    ];
    /**
     * Render the component `data-table`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.service.list.data-table');
    }

    /**
     * Get data `services` for the DataTable.
     * @param ServiceMegalosService $serviceMegalosService Service service instance
     * @return mixed
     */
    public function getDataTable(ServiceMegalosService $serviceMegalosService)
    {
        return $serviceMegalosService->getDatatables();
    }

    /**
     * Deletes a single service using its UID.
     * @param ServiceMegalosService $serviceMegalosService
     * @param string $serviceUid
     * @return void
     */
    public function deleteService(ServiceMegalosService $serviceMegalosService, $serviceId)
    {
        try {
            // Loop through all service UID and delete each service's data.
            $serviceMegalosService->deleteServiceAndRadGroupReply($serviceId);

            // Notify the frontend of success
            $this->dispatchSuccessEvent('Service successfully deleted.');

            // Refresh the data table
            $this->refreshDataTable();
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while deleting service : ' . $th->getMessage());
        }
    }

    /**
     * Refresh the DataTable when an service is created, updated and deleted.
     */
    public function refreshDataTable()
    {
        $this->dispatchBrowserEvent('refreshDatatable');
    }
}
