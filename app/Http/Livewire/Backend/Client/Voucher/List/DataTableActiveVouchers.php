<?php

namespace App\Http\Livewire\Backend\Client\Voucher\List;

use App\Services\Client\Voucher\VoucherService;
use Livewire\Component;

class DataTableActiveVouchers extends Component
{

    // Listeners
    protected $listeners = [
        // TODO:
        // 'clientCreated' => 'refreshDataTable',
        // 'clientUpdated' => 'refreshDataTable',
        // 'confirmClient' => 'deleteClient',
        // 'deleteBatch'   => 'deleteBatchClient',
    ];

    /**
     * Render the component `data-table`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.voucher.list.data-table-active-vouchers');
    }

    /**
     * Get data `list-voucher-batches` for the DataTable.
     * @param VoucherService $voucherService Client service instance
     * @return mixed
     */
    public function getDataTable(VoucherService $voucherService)
    {
        return $voucherService->getDatatableActiveVouchers();
    }
}
