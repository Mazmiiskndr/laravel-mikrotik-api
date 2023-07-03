<?php

namespace App\Http\Livewire\Backend\Client\Voucher\List;

use App\Exports\VoucherBatchDetailExport;
use App\Services\Client\Voucher\VoucherService;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class SaveToExcel extends Component
{
    public $voucherBatchId;

    public function render()
    {
        return view('livewire.backend.client.voucher.list.save-to-excel');
    }

    /**
     * Exports a report of online users to a XlSX file.
     * @param VoucherService $voucherService Service to generate report data.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse XlSX file download response.
     */
    public function saveToExcel(VoucherService $voucherService)
    {
        return Excel::download(new VoucherBatchDetailExport($voucherService,$this->voucherBatchId), 'list-of-vouchers-detail-batch-' . date('Y-m-d') . '.xlsx');
    }
}
