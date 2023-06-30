<?php

namespace App\Http\Livewire\Backend\Report\ListOnlineUser;

use App\Exports\ListOnlineUsersExport;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Report\ReportService;

class ExportCsv extends Component
{
    /**
     * Render the component list-online-users `export-csv`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.report.list-online-user.export-csv');
    }

    public function exportToCSV(ReportService $reportService)
    {
        return Excel::download(new ListOnlineUsersExport($reportService), 'list-online-users-' . date('Y-m-d') . '-.xlsx');
    }

}
