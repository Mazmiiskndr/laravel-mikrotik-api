<?php

namespace App\Http\Livewire\Backend\Setup\Administrator\Admin;

use App\Services\Admin\AdminService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;
use Illuminate\Http\Request;

class DataTable extends Component
{
    use LivewireMessageEvents;

    // Admin unique identifier
    public $adminId;

    // Event listeners
    protected $listeners = [
        'adminCreated' => 'refreshDataTable',
        'adminUpdated' => 'refreshDataTable',
        'confirmAdmin' => 'deleteAdmin',
    ];

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.setup.administrator.admin.data-table');
    }

    /**
     * Get data for the DataTable.
     * @param AdminService $adminService Admin service instance
     * @return mixed
     */
    public function getDataTable(AdminService $adminService)
    {
        return $adminService->getDatatables();
    }

    /**
     * Refresh the DataTable when an admin is created or updated.
     */
    public function refreshDataTable()
    {
        $this->dispatchBrowserEvent('refreshDatatable');
    }

    /**
     * Delete an admin.
     * @param AdminService $adminService Admin service instance
     * @param string $adminId Admin unique identifier
     */
    public function deleteAdmin(AdminService $adminService, $adminId)
    {
        try {
            // Attempt to delete the admin
            $adminService->deleteAdmin($adminId);

            // Notify the frontend of success
            $this->dispatchSuccessEvent('Admin successfully deleted.');

            // Refresh the data table
            $this->refreshDataTable();
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent('An error occurred while deleting admin: ' . $th->getMessage());
        }
    }
}
