<?php

namespace App\Services\Admin;

use LaravelEasyRepository\Service;
use App\Repositories\Admin\AdminRepository;
use App\Traits\HandleRepositoryCall;
use Exception;

class AdminServiceImplement extends Service implements AdminService
{
    use HandleRepositoryCall;

    protected $mainRepository;
    /**
     * Constructor.
     * @param AdminRepository $mainRepository The main repository for settings.
     */
    public function __construct(AdminRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Validates an admin user.
     * @param string $username The username of the admin user.
     * @param string $password The password of the admin user.
     * @return mixed The result of the validateAdmin repository method call.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function validateAdmin($username, $password)
    {
        return $this->handleRepositoryCall('validateAdmin', [$username, $password]);
    }

    /**
     * Logs out the current user.
     * @return mixed The result of the logout repository method call.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function logout()
    {
        return $this->handleRepositoryCall('logout');
    }

    /**
     * Retrieves all admins for use with DataTables.
     * @return mixed The result of the getDatatables repository method call.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function getDatatables()
    {
        return $this->handleRepositoryCall('getDatatables');
    }

    /**
     * Stores a new admin user.
     * @param array $request The data used to create the new admin.
     * @return mixed The result of the storeNewAdmin repository method call.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function storeNewAdmin($request)
    {
        return $this->handleRepositoryCall('storeNewAdmin', [$request]);
    }

    /**
     * Updates an existing admin user.
     * @param int $admin_uid The unique identifier of the admin to update.
     * @param array $request The data used to update the admin.
     * @return mixed The result of the updateAdmin repository method call.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function updateAdmin($admin_uid, $request)
    {
        return $this->handleRepositoryCall('updateAdmin', [$admin_uid, $request]);
    }

    /**
     * Deletes an existing admin user.
     * @param int $admin_uid The unique identifier of the admin to delete.
     * @return mixed The result of the deleteAdmin repository method call.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function deleteAdmin($admin_uid)
    {
        return $this->handleRepositoryCall('deleteAdmin', [$admin_uid]);
    }

    /**
     * Retrieves a specific admin user by UID.
     * @param int $uid The unique identifier of the admin to retrieve.
     * @return mixed The result of the getAdminByUid repository method call.
     * @throws \Exception if an error occurs during the repository method call.
     */
    public function getAdminByUid($uid)
    {
        return $this->handleRepositoryCall('getAdminByUid', [$uid]);
    }
}
