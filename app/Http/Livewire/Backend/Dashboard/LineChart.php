<?php

namespace App\Http\Livewire\Backend\Dashboard;

use App\Helpers\MikrotikConfigHelper;
use App\Jobs\UpdateMikrotikTraffic;
use App\Services\MikrotikApi\MikrotikApiService;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class LineChart extends Component
{
    // Arrays for storing upload and download traffic data.
    public $uploadTraffic = 0;
    public $downloadTraffic = 0;

    // Associative array for mapping event listeners to their handling methods.
    protected $listeners = ['getLoadTrafficData' => 'loadTrafficData'];
    /**
     * This function loads traffic data using a Mikrotik API service when the application boots up.
     */
    public function booted()
    {
        $this->loadTrafficData();
    }

    /**
     * Render the associated view for this component.
     * @return View The view instance for 'livewire.backend.dashboard.line-chart'.
     */
    public function render()
    {
        // Return the specific view for this component.
        return view('livewire.backend.dashboard.line-chart');
    }

    /**
     * Load traffic data using the provided MikrotikApiService instance.
     */
    public function loadTrafficData()
    {
        // Dispatch the UpdateMikrotikStats job to update the data in cache.
        dispatch(new UpdateMikrotikTraffic());
        // Load the data from cache
        $this->uploadTraffic = Cache::get('mikrotik.uploadTraffic', 0);
        $this->downloadTraffic = Cache::get('mikrotik.downloadTraffic', 0);
        // Emit an event to update the traffic data.
        $this->emit('updateTrafficData', $this->uploadTraffic, $this->downloadTraffic);

    }
}
