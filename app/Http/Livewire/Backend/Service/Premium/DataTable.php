<?php

namespace App\Http\Livewire\Backend\Service\Premium;

use App\Services\ServiceMegalos\ServiceMegalosService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class DataTable extends Component
{
    // Listeners
    protected $listeners = [
        'confirmPremiumService' => 'deletePremiumService',
        'premiumServiceUpdated' => 'refreshDataTable',
    ];

    /**
     * Render the component `premium services data-table`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.service.premium.data-table');
    }

    /**
     * Get data `premium-services` for the DataTable.
     * @param ServiceMegalosService $serviceMegalosService Service service instance
     * @return mixed
     */
    public function getDataTable(ServiceMegalosService $serviceMegalosService)
    {
        return $serviceMegalosService->getPremiumServicesDatatables();
    }

    /**
     * Refresh the DataTable when an service is created, updated and deleted.
     */
    public function refreshDataTable()
    {
        $this->dispatchBrowserEvent('refreshDatatable');
    }
}
