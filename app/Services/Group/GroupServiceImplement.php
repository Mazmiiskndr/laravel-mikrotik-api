<?php

namespace App\Services\Group;

use LaravelEasyRepository\Service;
use App\Repositories\Group\GroupRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class GroupServiceImplement extends Service implements GroupService
{
    protected $mainRepository;
    /**
     * Constructor.
     * @param GroupRepository $mainRepository The main repository for settings.
     */
    public function __construct(GroupRepository $mainRepository)
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
     * Retrieves data from the database and formats it for DataTables.
     * @return mixed The result suitable for DataTables.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function getDatatables()
    {
        return $this->handleRepositoryCall('getDatatables');
    }

    /**
     * Retrieves the data permissions.
     * @return mixed The data permissions.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function getDataPermissions()
    {
        return $this->handleRepositoryCall('getDataPermissions');
    }

    /**
     * Retrieves the group and associated pages by ID.
     * @param mixed $id The group ID.
     * @return mixed The group and pages data.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function getGroupAndPagesById($id)
    {
        return $this->handleRepositoryCall('getGroupAndPagesById', [$id]);
    }

    /**
     * Stores a new group with the given name and permissions.
     * @param mixed $groupName The name of the group.
     * @param mixed $permissions The permissions of the group.
     * @return mixed The newly created group.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function storeNewGroup($groupName, $permissions)
    {
        return $this->handleRepositoryCall('storeNewGroup', [$groupName, $permissions]);
    }

    /**
     * Updates an existing group with the given name, permissions, and ID.
     * @param mixed $groupName The name of the group.
     * @param mixed $permissions The permissions of the group.
     * @param mixed $id The ID of the group.
     * @return mixed The updated group.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function updateGroup($groupName, $permissions, $id)
    {
        return $this->handleRepositoryCall('updateGroup', [$groupName, $permissions, $id]);
    }
}
