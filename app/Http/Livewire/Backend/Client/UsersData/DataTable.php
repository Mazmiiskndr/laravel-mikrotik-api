<?php

namespace App\Http\Livewire\Backend\Client\UsersData;

use App\Exports\UsersDataExport;
use App\Services\Client\UsersData\UsersDataService;
use App\Traits\LivewireMessageEvents;
use Illuminate\Http\Request;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class DataTable extends Component
{
    use LivewireMessageEvents;
    public $data = [
        'fromDate' => '',
        'toDate' => '',
    ];

    // Listeners
    protected $listeners = [
        'dateUpdated' => 'onDateUpdated',
        'saveToExcel' => 'downloadExcel',
        'saveToPdf' => 'downloadPdf',
        'confirmUserData' => 'deleteUsersData',
        'confirmUserDataBatch' => 'deleteUsersDataBatch',
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
     * Retrieves `users-data` for the DataTable from a given service.
     * @param Request $request Instance of the Request.
     * @return mixed The response from the getDatatables method of the UsersDataService.
     */
    public function getDataTable(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $usersDataService = app(UsersDataService::class);
        return $usersDataService->getDatatables($fromDate, $toDate);
    }

    /**
     * Event listener for 'dateUpdated' events. It updates the component's fromDate and toDate properties
     * @param string $fromDate The 'from' date passed from the event.
     * @param string $toDate The 'to' date passed from the event.
     * @return void
     */
    public function onDateUpdated($data)
    {
        $this->data = $data;
        $this->dispatchBrowserEvent('dateUpdated', $data);
        $this->refreshDataTable();
    }

    /**
     * Refresh the DataTable when an client is created, updated and deleted.
     */
    public function refreshDataTable()
    {
        $this->dispatchBrowserEvent('refreshDatatable');
    }

    /**
     * Exports a report of users data to a XlSX file.
     * @param UsersDataService $usersDataService Service to generate report data.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse XlSX file download response.
     */
    public function downloadExcel(UsersDataService $usersDataService)
    {
        return Excel::download(new UsersDataExport($usersDataService), 'users-data-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Deletes multiple users data using their UIDs.
     * @param UsersDataService $usersDataService
     * @param array $usersDataIds
     * @return void
     */
    public function deleteUsersDataBatch(UsersDataService $usersDataService, $usersDataIds)
    {
        try {
            // Loop through all users data IDs and delete each voucher's data.
            foreach ($usersDataIds as $usersDataId) {
                $usersDataService->deleteUsersData($usersDataId);
            }

            // Notify the frontend of success
            $this->dispatchSuccessEvent('Users data successfully deleted.');

            // Refresh the data table
            $this->refreshDataTable();
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while deleting users data : ' . $th->getMessage());
        }
    }

    /**
     * Deletes a single users data using its UID.
     * @param UsersDataService $usersDataService
     * @param string $usersDataId
     * @return void
     */
    public function deleteUsersData(UsersDataService $usersDataService, $usersDataId)
    {
        try {
            // Loop through all users data id and delete each voucher's data.
            $usersDataService->deleteUsersData($usersDataId);

            // Notify the frontend of success
            $this->dispatchSuccessEvent('Users Data successfully deleted.');

            // Refresh the data table
            $this->refreshDataTable();
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while deleting users data : ' . $th->getMessage());
        }
    }
}
