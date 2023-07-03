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
        'voucherBatchCreated' => 'refreshDataTable',
        'confirmVoucherBatch' => 'deleteVoucherBatch',
        'deleteBatches' => 'deleteVoucherBatches',
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

    /**
     * Refresh the DataTable when an voucher batches is created, updated and deleted.
     */
    public function refreshDataTable()
    {
        $this->dispatchBrowserEvent('refreshDatatable');
    }

    /**
     * Deletes multiple voucher batches using their UIDs.
     * @param VoucherService $voucherService
     * @param array $voucherBatchIds
     * @return void
     */
    public function deleteVoucherBatches(VoucherService $voucherService, $voucherBatchIds)
    {
        try {
            // Loop through all voucher batch IDs and delete each voucher's data.
            foreach ($voucherBatchIds as $voucherBatchId) {
                $voucherService->deleteVoucherBatch($voucherBatchId);
            }

            // Notify the frontend of success
            $this->dispatchSuccessEvent('Voucher Batches successfully deleted.');

            // Refresh the data table
            $this->refreshDataTable();
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while deleting voucher batches : ' . $th->getMessage());
        }
    }

    /**
     * Deletes a single voucher batches using its UID.
     * @param VoucherService $voucherService
     * @param string $voucherBatchId
     * @return void
     */
    public function deleteVoucherBatch(VoucherService $voucherService, $voucherBatchId)
    {
        try {
            // Loop through all voucher batch id and delete each voucher's data.
            $voucherService->deleteVoucherBatch($voucherBatchId);

            // Notify the frontend of success
            $this->dispatchSuccessEvent('Voucher Batch successfully deleted.');

            // Refresh the data table
            $this->refreshDataTable();
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while deleting voucher batch : ' . $th->getMessage());
        }
    }
}
