<?php

namespace App\Repositories\Config\HotelRoom;

use App\Helpers\ActionButtonsBuilder;
use App\Models\Services;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Setting;
use App\Traits\DataTablesTrait;
use Yajra\DataTables\Facades\DataTables;

class HotelRoomRepositoryImplement extends Eloquent implements HotelRoomRepository
{
    use DataTablesTrait;
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;
    protected $servicesModel;

    public function __construct(Setting $model, Services $servicesModel)
    {
        $this->model = $model;
        $this->servicesModel = $servicesModel;
    }

    /**
     * Fetches hotel room parameters from the model's table.
     * @return Model The fetched Eloquent model instance.
     */
    public function getHotelRoomParameters()
    {
        // Get 2 line from setting table based on setting
        $settings = $this->model->whereIn('setting', ['hms_connect'])->firstOrFail();

        return $settings;
    }

    /**
     * Updates or creates hotel room settings based on the given data.
     * @param  array $settings The settings to update or create.
     */
    public function updateHotelRoomSettings($settings)
    {
        foreach ($settings as $key => $value) {
            $this->model->updateOrCreate(
                ['setting' => $key],
                ['value' => $value]
            );
        }
    }

    /**
     * Fetches data from the database and formats it for DataTables.
     * @return JsonResponse A JSON response suitable for DataTables.
     */
    public function getDatatables()
    {
        // Retrieve records from the database using the model, including the related 'Services' records, and sort by the latest records
        $data = $this->servicesModel->select('id', 'service_name', 'cron_type', 'cron')
        ->where('cron_type', '!=', null)
            ->where('cron', '!=', '')
            ->where('cron', '!=', 0)
            ->get();

        $deletePermission = 'delete_admin';
        $onclickDelete = 'confirmDeleteService';

        // Format the data for DataTables
        return $this->formatDataTablesResponse(
            $data,
            [
                'action' => function ($data) use ($deletePermission, $onclickDelete) {
                    return $this->getActionButtons($data, $deletePermission, $onclickDelete);
                }
            ]
        );
    }

    // 👇 **** PRIVATE FUNCTIONS **** 👇

    /**
     * Generate action buttons for the DataTables row.
     * @param $data
     * @param $deletePermission
     * @param $onclickDelete
     * @return string HTML string for the action buttons
     */
    private function getActionButtons($data, $deletePermission, $onclickDelete)
    {
        return (new ActionButtonsBuilder())
            ->setDeletePermission($deletePermission)
            ->setOnclickDelete($onclickDelete)
            ->setIdentity($data->id)
            ->build();
    }
}
