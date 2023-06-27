<?php

namespace App\Services\Config\UserData;

use LaravelEasyRepository\Service;
use App\Repositories\Config\UserData\UserDataRepository;

class UserDataServiceImplement extends Service implements UserDataService
{
    protected $mainRepository;
    /**
     * Constructor.
     * @param UserDataRepository $mainRepository The main repository for settings.
     */
    public function __construct(UserDataRepository $mainRepository)
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
     * Retrieves the parameters for the user data.
     * @return mixed The user data parameters.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function getUserDataParameters()
    {
        return $this->handleRepositoryCall('getUserDataParameters');
    }

    /**
     * Updates or creates user data settings based on the given data.
     * @param mixed $settings The settings to update or create.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function updateUserDataSettings($settings)
    {
        return $this->handleRepositoryCall('updateUserDataSettings', [$settings]);
    }
}
