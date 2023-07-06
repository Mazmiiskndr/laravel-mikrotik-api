<?php

namespace App\Services\Config\UserData;

use LaravelEasyRepository\Service;
use App\Repositories\Config\UserData\UserDataRepository;
use App\Traits\HandleRepositoryCall;

class UserDataServiceImplement extends Service implements UserDataService
{
    use HandleRepositoryCall;

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
