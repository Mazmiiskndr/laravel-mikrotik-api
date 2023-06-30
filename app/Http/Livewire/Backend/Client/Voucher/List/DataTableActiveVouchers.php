<?php

namespace App\Http\Livewire\Backend\Client\Voucher\List;

use App\Services\Client\Voucher\VoucherService;
use Livewire\Component;

class DataTableActiveVouchers extends Component
{
    /**
     * Render the component `data-table-active-vouchers`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.voucher.list.data-table-active-vouchers');
    }

    /**
     * Get data `list-active-vouchers` for the DataTable.
     * @param VoucherService $voucherService Voucher service instance
     * @return mixed
     */
    public function getDataTable(VoucherService $voucherService)
    {
        return $voucherService->getDatatableActiveVouchers();
    }
}
