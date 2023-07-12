<?php

namespace App\Http\Livewire\Backend\Report\ListOnlineUser;

use App\Services\Report\ReportService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;

class DataTable extends Component
{
    // Import trait for displaying messages from Livewire's events
    use LivewireMessageEvents;

    // Listeners
    protected $listeners = [
        'blockBatch' => 'blockedMacAddresses',
        // TODO:
        // 'blockedMacUpdated' => 'refreshDataTable',
        // 'confirmMac' => 'deleteMac',
        // 'deleteBatch'   => 'deleteBatchMacs',
    ];

    /**
     * Render the component list-online-users `data-table`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.report.list-online-user.data-table');
    }

    /**
     * Get data `list-online-users` for the DataTable.
     * @param ReportService $reportService Service service instance
     * @return mixed
     */
    public function getDataTableListOnlineUsers(ReportService $reportService)
    {
        return $reportService->getDatatables();
    }

    /**
     * Blocked multiple online users using their IDs.
     * @param ReportService $reportService
     * @param array $radAcctIds
     * @return void
     */
    public function blockedMacAddresses(ReportService $reportService, $radAcctIds)
    {
        try {
            // Loop through all rad acct IDs and delete each rad acct's data.
            foreach ($radAcctIds as $radAcctId) {
                $radAcctData = $reportService->getRadAcctById($radAcctId);
                $reportService->blockedMacAddresses($radAcctData);
            }
            // Notify the frontend of success
            $this->dispatchSuccessEvent('Mac Addresses successfully blocked.');

            // Refresh the data table
            $this->refreshDataTable();
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while Blocked Mac Addresses : ' . $th->getMessage());
        }
    }


}
