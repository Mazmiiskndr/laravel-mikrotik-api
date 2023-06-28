<?php

namespace App\Http\Livewire\Backend\Dashboard;

use App\Helpers\MikrotikConfigHelper;
use App\Jobs\FetchMikrotikLeasesJob;
use App\Services\MikrotikApi\MikrotikApiService;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class DataTable extends Component
{
    // Mikrotik API service instance variable.
    public $leasesData = [];

    /**
     * Render the associated view for this component.
     * @return View The view instance for 'livewire.backend.dashboard.data-table'.
     */
    public function render()
    {
        return view('livewire.backend.dashboard.data-table');
    }

    /**
     * Retrieves DHCP leases data using the provided MikrotikApiService instance.
     * @param MikrotikApiService $mikrotikApiService The Mikrotik API service instance.
     * @return mixed|null The DHCP leases data, or null if the data is empty.
     */
    public function getDatatable(MikrotikApiService $mikrotikApiService)
    {
        try {
            // Retrieve the Mikrotik configuration settings
            $config = MikrotikConfigHelper::getMikrotikConfig();

            // Load the data from the Mikrotik API service.
            $leasesData = $mikrotikApiService->getDhcpLeasesDatatables($config['ip'], $config['username'], $config['password']);

            // If the leases data is empty, emit a 'leasesDataEmpty' Livewire event and return empty data structure
            if (empty($leasesData)) {
                $this->emit('leasesDataEmpty');
                return response()->json(['data' => []]); // Return empty data structure
            }

            // If the leases data is not empty, return it
            return $leasesData;
        } catch (\Exception $e) {
            // Handle error and send a valid DataTables response
            return response()->json([
                'draw' => intval(request()->get('draw')),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ]);
        }
    }


}
