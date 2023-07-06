<?php

namespace App\Http\Livewire\Backend\Client\UsersData;

use App\Exports\UsersDataExport;
use App\Services\Client\UsersData\UsersDataService;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class DataTable extends Component
{
    // Listeners
    protected $listeners = [
        'saveToExcel' => 'downloadExcel',
    ];

    /**
     * Render the component `data-table`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.users-data.data-table');
    }

    /**
     * Get data `users-data` for the DataTable.
     * @param UsersDataService $usersDataService Client service instance
     * @return mixed
     */
    public function getDataTable(UsersDataService $usersDataService)
    {
        return $usersDataService->getDatatables();
    }

    /**
     * Refresh the DataTable when an client is created, updated and deleted.
     */
    public function refreshDataTable()
    {
        $this->dispatchBrowserEvent('refreshDatatable');
    }

    /**
     * Exports a report of online users to a XlSX file.
     * @param UsersDataService $usersDataService Service to generate report data.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse XlSX file download response.
     */
    public function downloadExcel(UsersDataService $usersDataService)
    {
        return Excel::download(new UsersDataExport($usersDataService), 'users-data-' . date('Y-m-d') . '.xlsx');
    }
}
