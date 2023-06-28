<?php

namespace App\Services\Config;

use LaravelEasyRepository\Service;
use App\Repositories\Config\ConfigRepository;
use Exception;

class ConfigServiceImplement extends Service implements ConfigService
{
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
     * Handles the method call to the repository and manages exceptions.
     * @param string $method The method to call.
     * @param array $parameters The parameters to pass to the method.
     * @throws \Exception If there is an error when calling the method.
     * @return mixed The result of the method call.
     */
    private function handleRepositoryCall(string $method, array $parameters = [])
    {
        try {
            return $this->mainRepository->{$method}(...$parameters);
        } catch (\Exception $exception) {
            $errorMessage = "Error when calling $method: " . $exception->getMessage();
            throw new \Exception($errorMessage);
        }
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
