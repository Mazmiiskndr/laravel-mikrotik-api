<?php

namespace App\Http\Livewire\Backend\Report\ListOnlineUser;

use App\Exports\ListOnlineUsersExport;
use App\Services\Report\ReportService;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class SaveToExcel extends Component
{
    /**
     * Render the component list-online-users `export-csv`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.report.list-online-user.save-to-excel');
    }

    /**
     * Exports a report of online users to a XlSX file.
     * @param ReportService $reportService Service to generate report data.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse XlSX file download response.
     */
    public function saveToExcel(ReportService $reportService)
    {
        return Excel::download(new ListOnlineUsersExport($reportService), 'list-online-users-' . date('Y-m-d') . '.xlsx');
    }
}
