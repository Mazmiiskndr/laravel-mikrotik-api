<?php

namespace App\Repositories\Nas;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Nas;
use App\Models\RouterOsApi;
use App\Models\Setting;
use App\Services\Setting\SettingService;
use Illuminate\Support\Facades\DB;

class NasRepositoryImplement extends Eloquent implements NasRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;
    protected $setting;
    protected $routerOsApi;
    protected $settingService;

    public function __construct(Nas $model, Setting $setting, RouterOsApi $routerOsApi, SettingService $settingService)
    {
        $this->model = $model;
        $this->setting = $setting;
        $this->routerOsApi = $routerOsApi;
        $this->settingService = $settingService;
    }

    // 👇 🌟🌟🌟 PUBLIC FUNCTIONS 🌟🌟🌟 👇

    /**
     * Sets up a Mikrotik device process.
     * @param record Current user data.
     * @param data Required input data for the setup process.
     * @return array 'status' indicating success or failure, and 'message' for additional info.
     */
    public function setupProcess($record, $data)
    {
        try {
            // Define an array with the methods to be executed.
            $methods = [
                'connectToDevice',         // Method to establish a connection to the Mikrotik device.
                'setupRadiusServer',       // Method to setup the Radius server.
                'setupUserAndGroup',       // Method to setup the user and group.
                'setupWalledGarden',       // Method to setup the Walled Garden.
            ];

            // Iterate over the methods array and execute each method.
            foreach ($methods as $method) {
                // Execute the current method and store the result.
                $methodResult = $this->$method($data);

                // If the method execution failed, return the failure status and message.
                if (!$methodResult['status']) {
                    return ['status' => false, 'message' => $methodResult['message']];
                }
            }

            // If all operations were successful, return a success status.
            return ['status' => true];
        } catch (\Exception $e) {
            // If an exception occurred, return a failure status and the exception message.
            return ['status' => false, 'message' => "Error: " . $e->getMessage()];
        }
    }

    /**
     * Get NAS by its shortname
     * @param string $shortName
     * @return Nas|null
     */
    public function getNasByShortname($shortName)
    {
        return $this->model->where('shortname', $shortName)->first();
    }

    /**
     * Retrieve NAS parameters for the given shortname
     * @return Nas|null
     */
    public function getNasParameters()
    {
        // Get NAS by shortname 'megalos' using a separate function (getNasByShortname)
        $record = $this->getNasByShortname('megalos');

        // Array of settings we want to retrieve from the database
        $settings = ['mikrotik_api_username', 'mikrotik_ip', 'mikrotik_api_port', 'server_ip'];

        // For each setting in our array
        foreach ($settings as $setting) {
            // Retrieve the setting from the database using a separate function (getSetting)
            // And set it as a property of our $record object
            $record->$setting = $this->settingService->getSetting($setting, 'default');
        }

        // Return the $record object, now with its properties set according to the retrieved settings
        return $record;
    }

    /**
     * Edits the NAS process which includes updating the NAS table and mikrotik API parameters.=
     * @return bool|string Returns true on success, error message on exception.
     */
    public function editNasProcess($data)
    {
        // Start a new database transaction.
        DB::beginTransaction();
        try {
            // Updates NAS table and Mikrotik API parameters.
            $this->updateNasTable($data);
            $this->updateMikrotikApiParameters($data);
            // Commit the transaction (apply the changes).
            DB::commit();
        } catch (\Exception $e) {
            // If an exception occurred during the create process, rollback the transaction.
            DB::rollBack();
            // In case of exception, return the exception message.
            return $e->getMessage();
        }

        // If no exception, return true indicating successful operation.
        return true;
    }

    // 👇 🌟🌟🌟 PROTECTED FUNCTIONS 🌟🌟🌟 👇

    /**
     * Adds an IP address to the Walled Garden IP List.
     * @param string $ipAddress The IP address to be added.
     * @return array Contains status and optional error message.
     */
    protected function addWalledGardenIpList($ipAddress)
    {
        // Check if the IP address already exists in the Walled Garden IP List
        $existingIpList = $this->getWalledGardenIpListByAddress($ipAddress);
        if (!is_null($existingIpList)) {
            return ['status' => true, 'message' => ''];
        }
        // Initialize result array with default values.
        $result = ['status' => false, 'message' => ''];

        // Prepare the IP address data.
        $ipData = ["action" => "accept", "dst-address" => $ipAddress, "comment" => "Managed by AZMI. DO NOT EDIT!!!"];
        // Send a command to the RouterOS API to add the IP address to the Walled Garden IP List.
        $resultData = $this->routerOsApi->comm("/ip/hotspot/walled-garden/ip/add", $ipData);

        // If there's an error ('!trap') in the result data, set an error message.
        if (isset($resultData['!trap'])) {
            $result['message'] = "Error in adding Walled Garden IP: " . $resultData['!trap'][0]['message'];
        } else {
            // If no error was found, set the status to true.
            $result['status'] = true;
        }

        // Return the result of the operation.
        return $result;
    }

    /**
     * Adds a rule to the Walled Garden IP List with specific protocol and port.
     * @return array Contains status and optional error message.
     */
    protected function addWalledGardenListProtocolAndPort()
    {
        // Check if the rule already exists in the Walled Garden IP List
        $existingRule = $this->getWalledGardenIpListByProtocolAndPort("tcp", "5223");
        if (!is_null($existingRule)) {
            return ['status' => true, 'message' => ''];
        }
        // dd($existingRule);
        // Initialize result array with default values.
        $result = ['status' => false, 'message' => ''];

        // Prepare the protocol and port data.
        $ipData = [
            "action" => "accept",
            "protocol" => "6", // 6 refers to TCP
            "dst-port" => "5223", // The destination port
            "comment" => "Managed by AZMI. DO NOT EDIT!!!"
        ];

        // Send a command to the RouterOS API to add the rule to the Walled Garden IP List.
        $resultData = $this->routerOsApi->comm("/ip/hotspot/walled-garden/ip/add", $ipData);

        // If there's an error ('!trap') in the result data, set an error message.
        if (isset($resultData['!trap'])) {
            $result['message'] = "Error in adding Walled Garden rule: " . $resultData['!trap'][0]['message'];
        } else {
            // If no error was found, set the status to true.
            $result['status'] = true;
        }

        // Return the result of the operation.
        return $result;
    }

    /**
     * Get an existing Walled Garden IP List by IP address.
     * @param string $ipAddress The IP address to search for.
     * @return array|null The existing Walled Garden IP data if found, or null if not found.
     */
    protected function getWalledGardenIpListByAddress($ipAddress)
    {
        $walledGardenIps = $this->routerOsApi->comm("/ip/hotspot/walled-garden/ip/print", ["?dst-address" => $ipAddress]);
        return isset($walledGardenIps[0]) ? $walledGardenIps[0] : null;
    }

    /**
     * Get an existing Walled Garden IP List by protocol and port.
     * @param string $protocol The protocol to search for.
     * @param string $port The port to search for.
     * @return array|null The existing Walled Garden IP data if found, or null if not found.
     */
    protected function getWalledGardenIpListByProtocolAndPort($protocol, $port)
    {
        $walledGardenIps = $this->routerOsApi->comm("/ip/hotspot/walled-garden/ip/print", ["?protocol" => $protocol, "?dst-port" => $port]);
        return isset($walledGardenIps[0]) ? $walledGardenIps[0] : null;
    }

    /**
     * Adds or updates a RADIUS configuration in RouterOS.
     * @param string $radiusServer RADIUS server IP or hostname.
     * @param string $radiusSecret Secret key for RADIUS authentication.
     * @return array Contains status and optional error message.
     */
    protected function addRadiusConfiguration($radiusServer, $radiusSecret)
    {
        // Initialize result array with default values.
        $result = ['status' => false, 'message' => ''];

        // Retrieve the configuration ID corresponding to the given radius server.
        $configId = $this->getConfigId($radiusServer);

        // Prepare the configuration data for the RADIUS server.
        $configData = $this->prepareConfigData($radiusServer, $radiusSecret);

        // If no configuration exists for the given radius server, create a new one.
        if (is_null($configId)) {
            // Send a command to the RouterOS API to add a new configuration.
            $resultData = $this->routerOsApi->comm("/radius/add", $configData);

            // Update the result message based on the operation's outcome.
            $result['message'] = $this->getErrorMsg("adding", $resultData);
        } else {
            // Add the configuration ID to the data if a configuration exists.
            $configData[".id"] = $configId;

            // Send a command to the RouterOS API to update the existing configuration.
            $resultData = $this->routerOsApi->comm("/radius/set", $configData);

            // Update the result message based on the operation's outcome.
            $result['message'] = $this->getErrorMsg("updating", $resultData);
        }

        // If no error message was generated, update the status to true.
        if ($result['message'] == '') {
            $result['status'] = true;
        }

        // Return the result of the operation.
        return $result;
    }

    /**
     * Creates a new user group with specific policies.
     * @return array 'status' indicating success or failure, 'message' for error info.
     */
    protected function createUserGroup()
    {
        // Initialize result with default values
        $result = ['status' => false, 'message' => ''];

        // Check if the group already exists
        $groupExists = $this->routerOsApi->comm("/user/group/print", [
            "?name" => env('MIKROTIK_NAME')
        ]);

        // Create the group if it does not exist
        if (empty($groupExists)) {
            $groupResult = $this->routerOsApi->comm("/user/group/add", [
                "name"    => env('MIKROTIK_NAME'),
                "policy"  => "write,policy,read,test,api",
                "comment" => "Managed by AZMI. DO NOT EDIT!!!"
            ]);

            // If no error, set status to true
            if (!isset($groupResult['!trap'])) {
                $result['status'] = true;
            } else {
                // Set error message if group creation failed
                $result['message'] = "Error in adding user group: " . $groupResult['!trap'][0]['message'];
            }
        } else {
            // Group already exists, set status to true
            $result = ['status' => true, 'message' => 'User group already exists.'];
        }

        return $result;
    }

    /**
     * Creates a new user with specified username, password, and group, or updates an existing one.
     * @param string $password
     * @param string $username
     * @return array 'status' indicating success or failure, 'message' for error info.
     */
    protected function createUser($password, $username)
    {
        // Initialize result with default values
        $result = ['status' => false, 'message' => ''];

        // Check if the user already exists
        $userExists = $this->routerOsApi->comm("/user/print", ["?name" => $username]);

        // Create a user object for the add/update operation
        $user = [
            "name"     => $username,
            "password" => $password,
            "group"    => $username,
            "comment"  => "Managed by AZMI. DO NOT EDIT!!!"
        ];

        // Update the user if it exists, else add a new user
        $userResult = !empty($userExists)
            ? $this->routerOsApi->comm("/user/set", [".id" => $username] + $user)
            : $this->routerOsApi->comm("/user/add", $user);

        // If no error, set status to true
        if (!isset($userResult['!trap'])) {
            $result['status'] = true;
        } else {
            // Set error message if user operation failed
            $result['message'] = "Error in user operation: " . $userResult['!trap'][0]['message'];
        }

        return $result;
    }

    // 👇 🌟🌟🌟 PRIVATE FUNCTIONS 🌟🌟🌟 👇

    /**
     * Connects to the Mikrotik device.
     * @param array $data Contains the Mikrotik device login details.
     * @return array 'status' indicating success or failure, and 'message' for additional info.
     */
    private function connectToDevice($data)
    {
        // Extract the required data.
        $username = $data['tempUsername'];
        $password = $data['tempPassword'];
        $ipAddress = $data['mikrotikIP'];

        // Try to connect to the Mikrotik device.
        if (!$this->routerOsApi->connect($ipAddress, $username, $password)) {
            return ['status' => false, 'message' => "Unable to connect to the Mikrotik device."];
        }

        return ['status' => true];
    }

    /**
     * Sets up the Radius Server.
     * @param array $data Contains the Radius Server configuration details.
     * @return array 'status' indicating success or failure, and 'message' for additional info.
     */
    private function setupRadiusServer($data)
    {
        // Extract the required data.
        $radiusServer = $data['serverIP'];
        $radiusSecret = $data['radiusSecret'];

        // Add RADIUS configuration.
        $radiusResult = $this->addRadiusConfiguration($radiusServer, $radiusSecret);

        return $radiusResult;
    }

    /**
     * Sets up the User and Group.
     * @param array $data Contains the User and Group configuration details.
     * @return array 'status' indicating success or failure, and 'message' for additional info.
     */
    private function setupUserAndGroup($data)
    {
        // Extract the required data.
        $usernameForAddUser = $data['username'];
        $passwordForAddUser = $data['password'];

        // Create user group.
        $groupResult = $this->createUserGroup();
        if (!$groupResult['status']) {
            return $groupResult;
        }

        // Create user.
        $userResult = $this->createUser($passwordForAddUser, $usernameForAddUser);

        return $userResult;
    }

    /**
     * Sets up the Walled Garden.
     * @param array $data Contains the Walled Garden configuration details.
     * @return array 'status' indicating success or failure, and 'message' for additional info.
     */
    private function setupWalledGarden($data)
    {
        // Extract the required data.
        $radiusServer = $data['serverIP'];

        // Add Walled Garden IP List.
        $walledGardenIpListResult = $this->addWalledGardenIpList($radiusServer);
        if (!$walledGardenIpListResult['status']) {
            return $walledGardenIpListResult;
        }

        // Add Walled Garden IP List protocol and port.
        $wgListProtoPortResult = $this->addWalledGardenListProtocolAndPort();
        // If there's an error in adding the Walled Garden protocol and port, throw an exception.
        if (!$wgListProtoPortResult['status']) {
            return $wgListProtoPortResult;
        }

        return ['status' => true];
    }

    /**
     * Get Config ID of matching server address.
     * @param string $radiusServer
     * @return string|null
     */
    private function getConfigId($radiusServer)
    {
        // Fetch all current RADIUS configurations from the RouterOS
        $radiusConfigs = $this->routerOsApi->comm("/radius/print");

        // Loop through the fetched configurations.
        foreach ($radiusConfigs as $config) {
            // If a matching server address is found, return its configuration ID.
            if (isset($config['address']) && $config['address'] === $radiusServer) {
                return $config[".id"];
            }
        }

        // If no matching server address is found, return null.
        return null;
    }

    /**
     * Prepares the configuration data for RADIUS.
     * @param string $radiusServer
     * @param string $radiusSecret
     * @return array The prepared configuration data.
     */
    private function prepareConfigData($radiusServer, $radiusSecret)
    {
        // Creates and returns an array with the required configuration data
        return [
            "address" => $radiusServer,  // The RADIUS server address
            "secret" => $radiusSecret,  // The secret key for RADIUS authentication
            "domain" => env('MIKROTIK_NAME'),  // The Mikrotik domain name
            "service" => "hotspot",  // The service type, which is "hotspot" in this case
            "authentication-port" => env('MIKROTIK_AUTHENTICATION_PORT'),  // The port for authentication
            "accounting-port" => env('MIKROTIK_ACCOUNTING_PORT'),  // The port for accounting
            "timeout" => env('MIKROTIK_TIMEOUT'),  // The timeout value
            "comment" => "Managed by AZMI. DO NOT EDIT!!!"  // A comment for this configuration
        ];
    }

    /**
     * Get error message if operation fails.
     * @param string $operation
     * @param array $resultData
     * @return string The error message, or an empty string if no error occurred.
     */
    private function getErrorMsg($operation, $resultData)
    {
        // Checks if there is an error ('!trap') in the result data
        if (isset($resultData['!trap'])) {
            // Returns a formatted error message
            return "Error in {$operation} RADIUS configuration: " . $resultData['!trap'][0]['message'];
        }

        // If no error was found, returns an empty string
        return '';
    }

    /**
     * Updates NAS table with the provided data.
     * @param array $data The data to update.
     */
    private function updateNasTable($data)
    {
        // Maps provided data to the database column names.
        $nasData = [
            'ports' => $data['radiusPort'],
            'secret' => $data['radiusSecret']
        ];

        // Updates the NAS record in the database using the id in the provided data.
        $this->model->where('id', $data['id'])->update($nasData);
    }

    /**
     * Edits Mikrotik API parameters with the provided data.
     * @param array $data The data to update.
     */
    private function updateMikrotikApiParameters($data)
    {
        // Array of settings we want to update
        $settings = [
            'mikrotik_ip' => 'mikrotikIP',
            'mikrotik_api_port' => 'mikrotikAPIPort',
            'server_ip' => 'serverIP',
            'mikrotik_api_username' => 'username',
            'mikrotik_api_password' => 'password'
        ];

        // For each setting in our array
        foreach ($settings as $dbSetting => $providedSetting) {
            // Update the setting in the database using the data provided
            $this->settingService->updateSetting($dbSetting, 'default', $data[$providedSetting]);
        }
    }

}
