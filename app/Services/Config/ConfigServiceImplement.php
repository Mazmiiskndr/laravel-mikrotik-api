<?php

namespace App\Services\Config;

use LaravelEasyRepository\Service;
use App\Repositories\Config\ConfigRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class ConfigServiceImplement extends Service implements ConfigService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(ConfigRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Returns a DataTables response with all module information for non-null 'flag_module' fields.
     * @return \Yajra\DataTables\DataTables JSON response for the DataTables.
     */
    public function getDatatables()
    {
        try {
            return $this->mainRepository->getDatatables();
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
            return [];
            //throw $th;
        }
    }

    /**
     * Retrieves the 'url_redirect' setting from the current model's table.
     * @return Model The Eloquent model instance for the 'url_redirect' setting.
     */
    public function getUrlRedirect()
    {
        try {
            return $this->mainRepository->getUrlRedirect();
        } catch (Exception $exception) {
            throw new Exception("Error getting URL Redirect : " . $exception->getMessage());
        }
    }

    /**
     * Updates or creates 'url_redirect' setting based on the given request data.
     * @param  mixed $request The request data to update or create settings with.
     */
    public function updateUrlRedirect($request)
    {
        try {
            return $this->mainRepository->updateUrlRedirect($request);
        } catch (Exception $exception) {
            throw new Exception("Error updating URL Redirect : " . $exception->getMessage());
        }
    }
}
