<?php

namespace App\Http\Livewire\Backend\Report\ListOnlineUser;

use App\Services\Report\ReportService;
use Livewire\Component;

class DataTable extends Component
{

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

}
