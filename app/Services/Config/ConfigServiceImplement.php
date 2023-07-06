<?php

namespace App\Services\Config;

use LaravelEasyRepository\Service;
use App\Repositories\Config\ConfigRepository;
use App\Traits\HandleRepositoryCall;
use Exception;

class ConfigServiceImplement extends Service implements ConfigService
{
    use HandleRepositoryCall;
    protected $mainRepository;
    /**
     * Constructor.
     * @param ConfigRepository $mainRepository The main repository for settings.
     */
    public function __construct(ConfigRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Returns a DataTables response with all module information for non-null 'flag_module' fields.
     * @return mixed The DataTables JSON response.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function getDatatables()
    {
        return $this->handleRepositoryCall('getDatatables');
    }

    /**
     * Retrieves the 'url_redirect' setting from the current model's table.
     * @return mixed The Eloquent model instance for the 'url_redirect' setting.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function getUrlRedirect()
    {
        return $this->handleRepositoryCall('getUrlRedirect');
    }

    /**
     * Updates or creates 'url_redirect' setting based on the given request data.
     * @param mixed $request The request data to update or create settings with.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function updateUrlRedirect($request)
    {
        return $this->handleRepositoryCall('updateUrlRedirect', [$request]);
    }
}
