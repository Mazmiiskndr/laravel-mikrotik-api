<?php

namespace App\Http\Livewire\Backend\Setup\Administrator\Group;

use App\Services\Group\GroupService;
use Livewire\Component;

class DataTable extends Component
{
    /**
     * render
     */
    public function render()
    {
        return view('livewire.backend.setup.administrator.group.data-table');
    }

    /**
     * getDataTable
     * @param  mixed $groupService
     */
    public function getDataTable(GroupService $groupService)
    {
        return $groupService->getDatatables();
    }
}