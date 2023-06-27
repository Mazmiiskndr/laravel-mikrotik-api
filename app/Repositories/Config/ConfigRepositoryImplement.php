<?php

namespace App\Repositories\Config;

use App\Helpers\AccessControlHelper;
use App\Models\Module;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Setting;
use Yajra\DataTables\Facades\DataTables;

class ConfigRepositoryImplement extends Eloquent implements ConfigRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    /**
     * Returns a DataTables response with all module information for non-null 'flag_module' fields.
     * @return \Yajra\DataTables\DataTables JSON response for the DataTables.
     */
    public function getDatatables()
    {
        // Use Eloquent to retrieve data from the database
        $flagModules = $this->model
            ->select('flag_module')
            ->whereNotNull('flag_module')
            ->groupBy('flag_module')
            ->get()
            ->pluck('flag_module');

        // Retrieve module data with matching flag_modules
        $data = Module::select('name', 'title', 'id')
            ->whereIn('name', $flagModules)
            ->get();

        // Get the raw data and convert it to a collection
        $data = $data->collect();

        // Add the 'Router' and Log Activities row to the end of the rawData collection
        $this->addRowToData($data, -1, 'Log Activities', 'edit_log_activity');
        $this->addRowToData($data, -2, 'Router', 'edit_router');

        // Convert it back to an array
        $rawData = $data->toArray();

        // Initialize DataTables using the rawData array
        $dataTables = DataTables::of($rawData)
            // Add an index column to the DataTable for easier reference
            ->addIndexColumn()
            // Add a new 'action' column to the DataTable, including edit and delete buttons with their respective icons
            ->addColumn('action', function ($data) {
                if ($data['id'] > 0) {
                    $button = "";
                    // For non-Router rows, use the edit and delete buttons with Names and classes
                    if ($data['name'] == 'hotel_rooms') {
                        if (AccessControlHelper::isAllowedToPerformAction('config_hotel_rooms')) {
                            $routeDetailHotelRooms = route('backend.setup.config.hotel_rooms');
                            $button = '<a href="' . $routeDetailHotelRooms . '" aria-label="Detail Button" name="' . $data['name'] . '" class="edit btn btn-info btn-sm"> <i class="fas fa-eye"></i></a> &nbsp;&nbsp;';
                        }
                        $button .= '<button type="button" aria-label="Edit Button" name="' . $data['name'] . '" class="edit btn btn-primary btn-sm" onclick="showModalByName(\'' . $data['name'] . '\')"> <i class="fas fa-edit"></i></button>';
                    } else {
                        $button = '<button type="button" aria-label="Edit Button" name="' . $data['name'] . '" class="edit btn btn-primary btn-sm" onclick="showModalByName(\'' . $data['name'] . '\')"> <i class="fas fa-edit"></i></button>';
                    }
                } elseif ($data['name'] == 'edit_log_activity') {
                $button = '<button type="button" aria-label="Edit Button" name="' . $data['name'] . '" class="edit btn btn-primary btn-sm" onclick="showModalByName(\'' . $data['name'] . '\')"> <i class="fas fa-edit"></i></button>';
                // TODO:
                // $button = '<div class="form-check form-switch">
                //             <livewire:backend.setup.config.form.log-activity />
                //         </div>
                //         ';

                } else {
                    $button = '<button type="button" aria-label="Edit Button" name="' . $data['name'] . '" class="edit btn btn-primary btn-sm" onclick="showModalByName(\'' . $data['name'] . '\')"> <i class="fas fa-edit"></i></button>';
                }
                return $button;
            })
            // Create and return the DataTables response as a JSON object
            ->make(true);

        // Return the DataTables JSON response
        return $dataTables;
    }

    /**
     * Retrieves the 'url_redirect' setting from the current model's table.
     * @return Model The Eloquent model instance for the 'url_redirect' setting.
     */
    public function getUrlRedirect()
    {
        // Use Eloquent to retrieve data from the database
        $data = $this->model->whereIn('setting', ['url_redirect'])->firstOrFail();
        // Return the data
        return $data;
    }

    /**
     * Updates or creates 'url_redirect' setting based on the given request data.
     * @param  mixed $request The request data to update or create settings with.
     */
    public function updateUrlRedirect($request)
    {
        foreach ($request as $key => $value) {
            $this->model->updateOrCreate(
                ['setting' => $key],
                ['value' => $value]
            );
        }
    }

    /**
     * Adds a new row to the data collection.
     * @param \Illuminate\Support\Collection $data
     * @param int $id
     * @param string $title
     * @param string $name
     */
    protected function addRowToData($data, $id, $title, $name)
    {
        $data->push([
            'id' => $id,
            'title' => $title,
            'name' => $name,
        ]);
    }
}
