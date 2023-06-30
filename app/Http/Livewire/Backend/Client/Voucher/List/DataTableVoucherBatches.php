<?php

namespace App\Http\Livewire\Backend\Client\Voucher\List;

use App\Services\Client\Voucher\VoucherService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class DataTableVoucherBatches extends Component
{
    // Import trait for displaying messages from Livewire's events
    use LivewireMessageEvents;

    // Listeners
    protected $listeners = [
        // TODO:
        // 'clientCreated' => 'refreshDataTable',
        // 'clientUpdated' => 'refreshDataTable',
        // 'confirmClient' => 'deleteClient',
        // 'deleteBatch'   => 'deleteBatchClient',
    ];

    /**
     * Render the component `data-table-voucher-batches`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.voucher.list.data-table-voucher-batches');
    }

    /**
     * Get data `list-voucher-batches` for the DataTable.
     * @param VoucherService $voucherService Voucher service instance
     * @return mixed
     */
    public function getDataTable(VoucherService $voucherService)
    {
        return $voucherService->getDatatableVoucherBatches();
    }
}
