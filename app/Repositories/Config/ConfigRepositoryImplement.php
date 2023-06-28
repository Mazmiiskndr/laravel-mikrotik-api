<?php

namespace App\Repositories\Config;

use App\Helpers\AccessControlHelper;
use App\Models\Module;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Setting;
use App\Services\Setting\SettingService;
use Yajra\DataTables\Facades\DataTables;

class ConfigRepositoryImplement extends Eloquent implements ConfigRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;
    protected $settingService;

    public function __construct(Setting $model, SettingService $settingService)
    {
        $this->model = $model;
        $this->settingService = $settingService;
    }

    /**
     * Get DataTables response with modules information.
     * @return \Yajra\DataTables\DataTables
     */
    public function getDatatables()
    {
        // Retrieve distinct flag_module where it is not null
        $flagModules = $this->model
            ->select('flag_module')
            ->whereNotNull('flag_module')
            ->groupBy('flag_module')
            ->get()
            ->pluck('flag_module');

        // Retrieve modules data where their names are in flag_modules
        $data = Module::select('name', 'title', 'id')
            ->whereIn('name', $flagModules)
            ->get();

        // Convert retrieved data to a collection
        $data = $data->collect();

        // Add Router and Log Activities row into data
        $this->addRowToData($data, -1, 'Router', 'edit_router');
        $this->addRowToData($data, -2, 'Log Activities', 'edit_log_activity');

        // Convert data back to array
        $rawData = $data->toArray();

        // Prepare DataTables
        $dataTables = DataTables::of($rawData)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return $this->generateActionButton($data);
            })
            ->make(true);

        return $dataTables;
    }

    /**
     * Get setting 'url_redirect'.
     * @return Setting
     */
    public function getUrlRedirect()
    {
        // Retrieve setting 'url_redirect'
        return $this->model->where('setting', 'url_redirect')->firstOrFail();
    }

    /**
     * Update or create setting 'url_redirect'.
     * @param  array $request
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
     * Add a row into data.
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

    /**
     * Generate action button based on data.
     * @param array $data
     * @return string
     */
    private function generateActionButton($data)
    {
        $button = "";

        // Generate appropriate button based on data
        switch ($data['name']) {
            case 'hotel_rooms':
                if (AccessControlHelper::isAllowedToPerformAction('config_hotel_rooms')) {
                    $routeDetailHotelRooms = route('backend.setup.config.hotel_rooms');
                    $button .= '<a href="' . $routeDetailHotelRooms . '" aria-label="Detail Button" name="' . $data['name'] . '" class="edit btn btn-info btn-sm mb-1"> <i class="fas fa-eye"></i></a> &nbsp;&nbsp;';
                }
                $button .= $this->generateEditButton($data);
                break;
            case 'edit_log_activity':
                $button = $this->generateFormSwitchButton($data);
                break;
            default:
                $button = $this->generateEditButton($data);
                break;
        }

        return $button;
    }

    /**
     * Generate edit button.
     * @param array $data
     * @return string
     */
    private function generateEditButton($data)
    {
        if($data['name'] == 'hotel_rooms'){
            return '<button type="button" aria-label="Edit Button" name="' . $data['name'] . '" class="edit btn btn-primary btn-sm mb-1" onclick="showModalByName(\'' . $data['name'] . '\')"> <i class="fas fa-edit"></i></button>';
        }
        return '<button type="button" aria-label="Edit Button" name="' . $data['name'] . '" class="edit btn btn-primary btn-sm" onclick="showModalByName(\'' . $data['name'] . '\')"> <i class="fas fa-edit"></i></button>';
    }

    /**
     * Generate form switch button.
     * @param array $data
     * @return string
     */
    private function generateFormSwitchButton($data)
    {
        $logData = $this->settingService->getSetting('log_activities', '0');
        $checked = $logData ? 'checked' : '';
        $label = $logData ? 'On' : 'Off';

        // FORM EDIT LOG ACTIVITIES BUTTON AND SHOW MODAL :
        // return '<button type="button" aria-label="Edit Button" name="' . $data['name'] . '" class="edit btn btn-primary btn-sm" onclick="showModalByName(\'' . $data['name'] . '\')"> <i class="fas fa-edit"></i></button>';

        // FORM EDIT LOG ACTIVITIES SWITCH  :
        return '<div class="form-check form-switch">
                    <label class="form-check-label" for="logActivitySwitch" id="labelLogActivity">' . $label . '</label>
                    <span data-bs-toggle="tooltip" data-bs-placement="right"
                        title="This setting to control activity logging. When activated, all activity logs will be stored in the database.
                        When deactivated, activity logs will not be recorded.">
                        <span class="badge badge-center rounded-pill bg-warning bg-glow" style="width: 15px;height:15px;">
                        <i class="ti ti-question-mark" style="font-size: 0.8rem;"></i>
                        </span>
                    </span>
                    <input ' . $checked . ' onchange="updateActivity(\'' . $data['name'] . '\', this.checked)" class="form-check-input" type="checkbox"
                        id="logActivitySwitch">
                </div>
                ';
    }
}
