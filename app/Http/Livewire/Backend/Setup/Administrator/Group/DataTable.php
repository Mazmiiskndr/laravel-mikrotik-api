<?php

namespace App\Http\Livewire\Backend\Setup\Administrator\Group;

use App\Services\Group\GroupService;
use Livewire\Component;

class DataTable extends Component
{
    // Listeners
    protected $listeners = [
        'groupCreated' => 'handleGroupCreated',
    ];
    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.setup.administrator.group.data-table');
    }

    /**
     * Get data for the DataTable.
     * @param GroupService $groupService Group service instance
     * @return mixed
     */
    public function getDataTable(GroupService $groupService)
    {
        return $groupService->getDatatables();
    }

    /**
     * Called when the 'refreshCreateDataTable' event is received
     * Dispatches the 'refreshDatatable' browser event to reload the DataTable
     * @return void
     */
    public function handleGroupCreated()
    {
        $this->dispatchBrowserEvent('refreshDatatable');
    }
}
