<?php

namespace App\Repositories\Admin;

use App\Helpers\ActionButtonsBuilder;
use App\Helpers\SessionKeyHelper;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Admin;
use App\Traits\DataTablesTrait;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\DataTables;

class AdminRepositoryImplement extends Eloquent implements AdminRepository
{
    use SessionKeyHelper;
    use DataTablesTrait;
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     */
    protected $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    /**
     * Validate an Admin
     * This function checks if the provided admin credentials are correct, if the admin is active, and generates a session and a cookie if they are.
     * @param string $username The admin's username.
     * @param string $password The admin's password.
     * @return array|bool An array containing the session key, session data and the cookie, or false if the credentials are not valid.
     */
    public function validateAdmin($username, $password)
    {
        try {
            // Get Admin
            $admin = $this->model->where('username', strtolower($username))->first();

            // Check if admin data is found, password is correct
            if ($admin && Hash::check($password, $admin->password)) {

                // Check if admin status is 1
                if ($admin->status != 1) {
                    // Return a message if the account is no longer active
                    return ['success' => false, 'message' => 'Your account is no longer active'];
                }

                // Prepare session data
                $sessionData = $this->prepareSessionData($admin);

                // Save session data to Redis
                list($sessionKey, $redisKey) = $this->saveSessionDataToRedis($sessionData);

                // Create a new cookie with session key
                $cookie = $this->createCookie($sessionKey);

                // Save login log
                $this->saveLoginLog($username);

                // Return session key, session data, and cookie
                return ['success' => true, 'session_key' => $sessionKey, 'session_data' => $sessionData, 'cookie' => $cookie];
            }
        } catch (\Exception $e) {
            // Log the exception message for debugging and return false
            Log::error("Error in Validate Account : " . $e->getMessage());
            throw $e;
        }
        // Invalid login credentials or an error occurred
        return ['success' => false, 'message' => 'Invalid Username or Password!.'];
    }

    /**
     * logout
     */
    public function logout()
    {
        // get session key from cookie or queued cookies
        $sessionKey = Cookie::get('session_key') ?? $this->getQueuedSessionKey();
        $redisKey = '_redis_key_prefix_' . $sessionKey;

        // Delete data Redis
        if (Redis::exists($redisKey)) {
            Redis::del($redisKey);
        }

        // Delete existing cookies and create new cookies with expiration time in the past
        $cookie = Cookie::forget('session_key');

        // Redirect to the login page or home page
        return $cookie;
    }

    /**
     * Retrieves records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response.
     */
    public function getDatatables()
    {
        // Retrieve records from the database using the model, including the related 'admin' records, and sort by the latest records
        $data = $this->model->with('group')->latest()->get();

        $editPermission = 'edit_admin';
        $deletePermission = 'delete_admin';
        $onclickEdit = 'showAdmin';
        $onclickDelete = 'confirmDeleteAdmin';
        $editButton = 'button';

        // Format the data for DataTables
        return $this->formatDataTablesResponse(
            $data,
            [
                'status' => function ($data) {
                    return $data->status == 1 ? '<span class="badge bg-label-success">Active</span>' : '<span class="badge bg-label-danger">Non Active</span>';
                },
                'action' => function ($data) use ($editPermission, $deletePermission, $editButton, $onclickEdit, $onclickDelete) {
                    return $this->getActionButtons($data, $editPermission, $deletePermission, $editButton, $onclickEdit, $onclickDelete);
                }
            ]
        );
    }

    /**
     * Stores a new admin in the database with the provided information.
     * @param  Illuminate\Http\Request $request Request object containing the admin data.
     * @return App\Models\Admin|null The newly created admin or null if an exception occurs.
     */
    public function storeNewAdmin($request)
    {
        try {
            // Create a new admin with the provided information
            $admin = $this->model->create([
                'group_id'    => $request['groupId'],
                'username'    => strtolower($request['username']),
                'password'    => Hash::make($request['password']),
                'status'      => $request['status'],
                'fullname'    => $request['fullName'],
                'email'       => $request['emailAddress'],
            ]);

            // Return the newly created admin
            return $admin;
        } catch (\Exception $e) {
            // If an exception occurred during the create process, log the error message.
            Log::error("Error in storeNewAdmin: " . $e->getMessage());

            // Rethrow the exception to be caught in the Livewire component.
            throw $e;
        }
    }

    /**
     * Updates an admin record in the database.
     * @param string $admin_uid The unique identifier of the admin.
     * @param Illuminate\Http\Request $request The request object containing the updated admin data.
     * @return App\Models\Admin|null The updated admin object, or null if the admin was not found or an error occurred.
     * @throws InvalidArgumentException If no admin_uid is provided.
     */
    public function updateAdmin($admin_uid, $request)
    {
        // Check if the admin UID provided is empty.
        if (empty($admin_uid)) {
            // If it is, throw an exception.
            throw new \InvalidArgumentException("Admin UID is required");
        }

        try {
            // Get the admin from the database using the provided UID.
            $admin = $this->model->where('admin_uid', $admin_uid)->first();

            // Check if the admin was found in the database.
            if (!$admin) {
                // If not, throw an exception.
                throw new \RuntimeException("Admin with UID {$admin_uid} not found");
            }

            // Prepare the admin data for update. Using the request array to get the new data.
            $adminData = [
                'username' => strtolower($request['username']),
                'fullname' => $request['fullname'],
                'email' => $request['email'],
                'group_id' => $request['group_id'],
                'status' => $request['status'],
            ];

            // Check if a new password was provided.
            if (!empty($request['password'])) {
                // If it was, hash it and add it to the update data.
                $adminData['password'] = Hash::make($request['password']);
            }

            // Update the admin with the prepared data.
            $admin->update($adminData);

            // After updating the admin, return it.
            return $admin;
        } catch (\Exception $e) {
            // If an exception occurred during the update process, log the error message.
            Log::error("Error in updateAdmin: " . $e->getMessage());

            // Rethrow the exception to be caught in the Livewire component.
            throw $e;
        }
    }

    /**
     * Deletes an admin user by their unique identifier.
     * @param  string $admin_uid The unique identifier of the admin.
     * @return bool Returns true if deletion is successful, false otherwise.
     */
    public function deleteAdmin($admin_uid)
    {
        try {
            // Find the admin by uid
            $admin = $this->model->where('admin_uid', $admin_uid)->first();

            if ($admin) {
                // Delete the admin
                $admin->delete();

                // Return a success indicator
                return true;
            }

            // Admin not found
            return false;
        } catch (\Exception $e) {
            Log::error("Error in deleteAdmin: " . $e->getMessage());

            // Rethrow the exception to be caught in the Livewire component.
            throw $e;
        }
    }

    /**
    * This PHP function retrieves an admin user by their unique identifier.
     * @param  mixed $uid
     * @return void
     */
    public function getAdminByUid($uid)
    {
        $admin = $this->model->with('group')->where('admin_uid', $uid)->first();
        return $admin;
    }

    // 👇 **** PRIVATE FUNCTIONS **** 👇

    /**
     * Generate action buttons for the DataTables row.
     * @param $data
     * @param $editPermission
     * @param $deletePermission
     * @param $editButton
     * @param $onclickEdit
     * @param $onclickDelete
     * @return string HTML string for the action buttons
     */
    private function getActionButtons($data, $editPermission, $deletePermission, $editButton, $onclickEdit, $onclickDelete)
    {
        return (new ActionButtonsBuilder())
            ->setEditPermission($editPermission)
            ->setDeletePermission($deletePermission)
            ->setOnclickDelete($onclickDelete)
            ->setOnclickEdit($onclickEdit)
            ->setType($editButton)
            ->setIdentity($data->admin_uid)
            ->build();
    }

    /**
     * Prepare session data.
     * This function creates the session data for the admin.
     * @param object $admin The admin object.
     * @return array The session data.
     */
    private function prepareSessionData($admin)
    {
        // Return the session data. This data will be saved to Redis.
        return [
            'user_uid' => $admin->admin_uid,
            'group_id' => $admin->group_id,
            'role' => $admin->group->name,
            'login_status' => 'Active',
            'fullname' => $admin->fullname,
            'username' => $admin->username
        ];
    }

    /**
     * Save session data to Redis.
     * This function saves the session data to Redis.
     * @param array $sessionData The session data.
     * @return array The session key and the Redis key.
     */
    private function saveSessionDataToRedis($sessionData)
    {
        // Generate a random session key.
        $sessionKey = str()->random();

        // Create a Redis key by appending a prefix to the session key.
        $redisKey = '_redis_key_prefix_' . $sessionKey;

        // Save the session data to Redis.
        Redis::hMSet($redisKey, $sessionData);

        // Set the TTL of the Redis key to 7200 seconds (or 2 hours).
        Redis::expire($redisKey, 7200);

        // Return the session key and the Redis key.
        return [$sessionKey, $redisKey];
    }

    /**
     * Create a cookie.
     * This function creates a cookie with the session key.
     * @param string $sessionKey The session key.
     * @return \Illuminate\Support\Facades\Cookie The created cookie.
     */
    private function createCookie($sessionKey)
    {
        // Create a cookie named 'session_key' with a value equal to the session key and an expiration time of 120 minutes.
        $cookie = Cookie::make('session_key', $sessionKey, 120);

        // Queue the cookie for sending with the next response.
        Cookie::queue($cookie);

        // Return the cookie.
        return $cookie;
    }

    /**
     * Save Login Log
     * This function saves the login log for an admin.
     * @param string $username The admin's username.
     * @return void
     */
    private function saveLoginLog($username)
    {
        // Define a list of log keys.
        $logKeys = ['daily_login', 'monthly_login', 'total_login'];
        // Define a prefix for the Redis log keys.
        $privateRedisLog = "mglanalytic|";
        // Iterate over the log keys.
        foreach ($logKeys as $logKey) {

            // Generate a date string for the log key.
            $setDate = $this->getDateFormatForLogKey($logKey);

            // Create a Redis log key by concatenating the prefix, the log key, the username, and the date string.
            $redisLog = $privateRedisLog . $logKey . '|' . $username . $setDate;

            // Create a log entry in Redis with the Redis log key and the username.
            $this->createRedisLogEntry($redisLog, $username);
        }
    }

    /**
     * Get date format for log key.
     * This function gets the correct date format for a log key.
     * @param string $logKey The log key.
     * @return string The date format.
     */
    private function getDateFormatForLogKey($logKey)
    {
        switch ($logKey) {
            case 'daily_login':
                // If the log key is 'daily_login', return a string representing the current date in 'Y-m-d' format.
                return date('|Y-m-d', time());
            case 'monthly_login':
                // If the log key is 'monthly_login', return a string representing the current date in 'Y-m' format.
                return date('|Y-m', time());
            default:
                // If the log key is neither 'daily_login' nor 'monthly_login', return an empty string.
                return '';
        }
    }

    /**
     * This function creates a log entry in Redis for a specific key.
     * @param string $redisLog The Redis log key.
     * @param string $username The admin's username.
     * @return void
     */
    private function createRedisLogEntry($redisLog, $username)
    {
        // Create an associative array with the keys 'username' and 'time' and the corresponding values.
        $data = ['username' => $username, 'time' => time()];

        // Create a Redis increment key by appending '|count' to the Redis log key.
        $redisInc = $redisLog . '|count';

        // Increment the value associated with the Redis increment key in Redis by 1.
        Redis::incrBy($redisInc, 1);

        // Add a new member with a score of 1 and the JSON-encoded associative array as the member to a sorted set stored at the Redis log key.
        Redis::zAdd($redisLog, 1, json_encode($data));
    }

}
