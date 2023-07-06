<?php

namespace App\Http\Livewire\Backend\Client\UsersData;

use App\Services\Client\UsersData\UsersDataService;
use Livewire\Component;

class DataTable extends Component
{
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
}
