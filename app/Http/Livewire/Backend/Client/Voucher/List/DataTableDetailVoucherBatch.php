<?php

namespace App\Http\Livewire\Backend\Client\Voucher\List;

use App\Services\Client\Voucher\VoucherService;
use Livewire\Component;

class DataTableDetailVoucherBatch extends Component
{
    // Public properties
    public $voucherBatchId;

    public function mount($voucherBatchId)
    {
        $this->voucherBatchId = $voucherBatchId;
    }

    /**
     * Render the component `data-table-detail-voucher-batch`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.voucher.list.data-table-detail-voucher-batch');
    }

    /**
     * Get data `vouchers in batch` for the DataTable.
     * @param VoucherService $voucherService Voucher service instance
     * @return mixed
     */
    public function getDataTable(VoucherService $voucherService)
    {
        $this->voucherBatchId = request()->get('voucherBatchId');
        return $voucherService->getDatatableDetailVoucherBatch($this->voucherBatchId);
    }

}
