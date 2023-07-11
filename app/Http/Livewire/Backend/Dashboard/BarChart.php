<?php

namespace App\Http\Livewire\Backend\Dashboard;

use App\Services\Client\UsersData\UsersDataService;
use Livewire\Component;
use Carbon\Carbon;

class BarChart extends Component
{
    /**
     * @var array Contains the users data for chart.
     */
    public $usersData = 0;

    /**
     * Called when the component is ready to render.
     * Initializes the users data.
     *
     * @param UsersDataService $usersDataService Service to fetch users data.
     *
     * @return void
     */
    public function mount(UsersDataService $usersDataService)
    {
        // Fetch initial users data for the last 30 days.
        $this->updateChartData($usersDataService, now()->subMonth()->format('Y-m-d'), now()->format('Y-m-d'));
    }

    /**
     * Render the view for this component.
     *
     * @return \Illuminate\Contracts\View\View The view instance.
     */
    public function render()
    {
        return view('livewire.backend.dashboard.bar-chart');
    }

    /**
     * Updates the users data based on a date range.
     *
     * @param UsersDataService $usersDataService Service to fetch users data.
     * @param string|null $fromDate Start date for the data range.
     * @param string|null $toDate End date for the data range.
     *
     * @return void
     */
    public function updateChartData(UsersDataService $usersDataService, $fromDate, $toDate)
    {
        // Fetch users data based on the date range.
        $rawData = $usersDataService->getUsersData(
            null,
            ['*'],
            ['from_date' => $fromDate, 'to_date' => $toDate]
        )['data'];

        // Process the raw data and update the usersData property.
        $this->processRawData($rawData);

        // Emit an event to inform the frontend about the updated data.
        $this->emit('updatedChartData', $this->usersData);
    }

    /**
     * Processes the raw data fetched from the UsersDataService.
     * Groups the data by date and counts the number of entries per date.
     *
     * @param \Illuminate\Support\Collection $rawData The raw data from UsersDataService.
     *
     * @return void
     */
    private function processRawData($rawData)
    {
        // Group the raw data by date, and count the number of entries for each date.
        $groupedData = $rawData->groupBy('date')->map->count();

        // Format the grouped data and assign it to the usersData property.
        $this->usersData = $groupedData->mapWithKeys(function ($value, $key) {
            // Convert the key (date string) to a formatted date string.
            $formattedDate = Carbon::parse($key)->format('Y-m-d');

            return [$formattedDate => $value];
        })->toArray();
    }
}
