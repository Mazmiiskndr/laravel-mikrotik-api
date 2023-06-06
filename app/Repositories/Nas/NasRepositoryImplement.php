<?php

namespace App\Repositories\Nas;

use App\Libraries\Tiny;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Nas;
use App\Models\RouterOsApi;
use App\Models\Setting;

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

    public function __construct(Nas $model, Setting $setting, RouterOsApi $routerOsApi)
    {
        $this->model = $model;
        $this->setting = $setting;
        $this->routerOsApi = $routerOsApi;
    }


    /**
     * The function sets up a process by connecting to a Mikrotik device, adding RADIUS configuration,
     * creating a user group and user, and returning the result of the operation.
     *
     * @param record It is a variable that contains the current record or data of a user in the system.
     * It is used to check if the server IP address has changed or not.
     * @param data The  parameter is an array that contains input data required for the setup
     * process. It includes the temporary username and password, Mikrotik IP address, RADIUS server IP
     * address, and RADIUS secret.
     *
     * @return array with two keys: 'status' and 'message'. The 'status' key indicates whether the
     * setup process was successful or not, and the 'message' key provides additional information about
     * the status of the process.
     */
    public function setupProcess($record, $data)
    {
        // Initialize the result array
        $result = [
            'status' => false,
            'message' => ''
        ];

        // Check if the server IP address has changed
        if ($record->server_ip_address != $data['serverIP']) {
            // Extract required data from the input
            $username = $data['tempUsername'];
            $password = $data['tempPassword'];
            $ipAdress = $data['mikrotikIP'];
            $radiusServer   = $data['mikrotikIP'];
            $radiusSecret   = $data['radiusSecret'];

            try {
                // Attempt to connect to the Mikrotik device
                if ($this->routerOsApi->connect($ipAdress, $username, $password)) {
                    // Add RADIUS configuration and check if successful
                    $radiusResult = $this->addRadiusConfiguration($radiusServer, $radiusSecret);
                    if ($radiusResult['status']) {
                        // Create user group and check if successful
                        $groupResult = $this->createUserGroup();
                        if ($groupResult['status']) {
                            // Create user and check if successful
                            $userResult = $this->createUser();
                            if ($userResult['status']) {
                                // If all operations are successful, update the result status
                                $result['status'] = true;
                            } else {
                                // Set error message for user creation
                                $result['message'] = $userResult['message'];
                            }
                        } else {
                            // Set error message for group creation
                            $result['message'] = $groupResult['message'];
                        }
                    } else {
                        // Set error message for RADIUS configuration
                        $result['message'] = $radiusResult['message'];
                    }
                } else {
                    // Set error message if unable to connect to Mikrotik device
                    $result['message'] = "Unable to connect to the Mikrotik device.";
                }
            } catch (\Exception $e) {
                // Set error message if an exception occurs
                $result['message'] = "Error: " . $e->getMessage();
            }
        }

        // Return the result of the operation
        return $result;
    }


    /**
     * Adds or updates a RADIUS configuration in RouterOS.
     *
     * @param string $radiusServer RADIUS server IP or hostname.
     * @param string $radiusSecret Secret key for RADIUS authentication.
     * @return array Contains status and optional error message.
     */
    public function addRadiusConfiguration($radiusServer, $radiusSecret)
    {
        // Prepare the result with initial values
        $result = [
            'status' => false,
            'message' => ''
        ];

        // Retrieve all current RADIUS configurations
        $radiusConfigs = $this->routerOsApi->comm("/radius/print");

        // If there is at least one configuration present, update it
        if (count($radiusConfigs) > 0) {
            // Iterate through each existing configuration for updating
            foreach ($radiusConfigs as $config) {
                // Update the configuration with the provided parameters
                $updateResult = $this->routerOsApi->comm("/radius/set", array(
                    ".id"                   => $config[".id"],  // Use existing configuration id
                    "address"               => $radiusServer,  // Set server address
                    "secret"                => $radiusSecret,  // Set secret key
                    // The following values are from the environment variables
                    "domain"                => env('MIKROTIK_NAME'),
                    "service"               => "hotspot",
                    "authentication-port"   => env('MIKROTIK_AUTHENTICATION_PORT'),
                    "accounting-port"       => env('MIKROTIK_ACCOUNTING_PORT'),
                    "timeout"               => env('MIKROTIK_TIMEOUT'),
                    // Comment for configuration
                    "comment"               => "Managed by AZMI. DO NOT EDIT!!!"
                ));

                // If there was an error, set the error message and return the result
                if (isset($updateResult['!trap'])) {
                    $result['message'] = "Error in updating RADIUS configuration: " . $updateResult['!trap'][0]['message'];
                    return $result;
                }
            }

            // If updates were successful, set status to true
            $result['status'] = true;
        } else {
            // If there were no existing configurations, add a new one
            $addResult = $this->routerOsApi->comm("/radius/add", array(
                // Same parameters as the update operation above
                "address"               => $radiusServer,
                "secret"                => $radiusSecret,
                "domain"                => env('MIKROTIK_NAME'),
                "service"               => "hotspot",
                "authentication-port"   => env('MIKROTIK_AUTHENTICATION_PORT'),
                "accounting-port"       => env('MIKROTIK_ACCOUNTING_PORT'),
                "timeout"               => env('MIKROTIK_TIMEOUT'),
                "comment"               => "Managed by AZMI. DO NOT EDIT!!!"
            ));

            // If there was an error in adding, set the error message
            if (isset($addResult['!trap'])) {
                $result['message'] = "Error in adding RADIUS configuration: " . $addResult['!trap'][0]['message'];
            } else {
                // If addition was successful, set status to true
                $result['status'] = true;
            }
        }

        // Return the result (success or failure, with any error message)
        return $result;
    }


    /**
     * The function creates a new user group with specific policies and returns a result indicating
     * success or failure.
     *
     * @return array with two keys: 'status' and 'message'. The 'status' key indicates whether the
     * user group creation was successful or not, and the 'message' key contains an error message if
     * the creation was not successful.
     */
    public function createUserGroup()
    {
        // Initialize the result array
        $result = [
            'status' => false,
            'message' => ''
        ];

        // Check if the group already exists
        $groupExists = $this->routerOsApi->comm("/user/group/print", array(
            "?name" => env('MIKROTIK_NAME')
        ));

        // If the group does not exist, create the group
        if (empty($groupExists)) {
            // Create the new group with the required policies
            $groupResult = $this->routerOsApi->comm("/user/group/add", array(
                "name"     => env('MIKROTIK_NAME'),
                "policy"   => "write,policy,read,test,api",
                "comment"  => "Managed by AZMI. DO NOT EDIT!!!"
            ));

            // Check if the group creation was successful
            if (isset($groupResult['!re']) && $groupResult['!re'] === 0) {
                $result['status'] = true;
            } else {
                // Handle errors during group creation
                if (isset($groupResult['!trap'])) {
                    $result['message'] = "Error in adding user group: " . $groupResult['!trap'][0]['message'];
                } else {
                    $result['status'] = true;
                }
            }
        } else {
            $result['status'] = true;
            $result['message'] = "User group already exists.";
        }

        return $result;
    }

    /**
     * The function creates a new user with a specified username, password, and group, and returns a
     * result array indicating whether the creation was successful or not.
     *
     * @return array with two keys: 'status' and 'message'. The 'status' key indicates whether the
     * user creation was successful or not, and the 'message' key contains an error message if the user
     * creation was not successful.
     */
    public function createUser()
    {
        // Initialize the result array
        $result = [
            'status' => false,
            'message' => ''
        ];

        // Check if the user already exists
        $userExists = $this->routerOsApi->comm("/user/print", array(
            "?name" => env('MIKROTIK_NAME')
        ));

        // If the user does not exist, create the user
        if (empty($userExists)) {
            // Add the new user with the specified username, password, and group
            $userResult = $this->routerOsApi->comm("/user/add", array(
                "name"     => env('MIKROTIK_NAME'),
                "password" => env('MIKROTIK_NAME'),
                "group"    => env('MIKROTIK_NAME'),
                "comment"  => "Managed by AZMI. DO NOT EDIT!!!"
            ));

            // Check if the user creation was successful
            if (isset($userResult['!re']) && $userResult['!re'] === 0) {
                $result['status'] = true;
            } else {
                // Handle errors during user creation
                if (isset($userResult['!trap'])) {
                    $result['message'] = "Error in adding user: " . $userResult['!trap'][0]['message'];
                } else {
                    $result['status'] = true;
                }
            }
        } else {
            $result['status'] = true;
            $result['message'] = "User already exists.";
        }

        return $result;
    }


    /**
     * Get NAS by its shortname
     *
     * @param string $shortName
     * @return Nas|null
     */
    public function getNasByShortname($shortName)
    {
        return $this->model->where('shortname', $shortName)->first();
    }

    /**
     * Retrieve NAS parameters for the given shortname
     *
     * @return Nas|null
     */
    public function getNasParameters()
    {
        // Retrieve NAS record by its shortname
        $record = $this->getNasByShortname('megalos');

        // Get settings for mikrotik_ip, mikrotik_api_port, and server_ip
        $mikrotik_api_username = $this->getSetting('mikrotik_api_username', '0');
        $mikrotik_ip = $this->getSetting('mikrotik_ip', '0');
        $mikrotik_api_port = $this->getSetting('mikrotik_api_port', '0');
        $server_ip = $this->getSetting('server_ip', '0');

        // Assign the retrieved settings to the NAS record properties
        $record->mikrotik_api_username = $mikrotik_api_username;
        $record->mikrotik_ip_address = $mikrotik_ip;
        $record->mikrotik_api_port = $mikrotik_api_port;
        $record->server_ip_address = $server_ip;
        return $record;
    }

    /**
     * Edit NAS process (updating NAS table and mikrotik API parameters)
     *
     * @param array $data
     * @return bool
     */
    public function editNasProcess($data)
    {
        try {
            $this->_updateNasTable($data);
            $this->_editMikrotikApiParameters($data);
        } catch (\Exception $e) {
            return $e->getMessage(); // Return the error message on failure
        }

        return true; // Return true on success
    }

    /**
     * Update NAS table with the given data
     *
     * @param array $data
     * @return void
     */
    private function _updateNasTable($data)
    {
        $nas = array(
            'ports' => $data['radiusPort'],
            'secret' => $data['radiusSecret']
        );
        $this->model->where('id', $data['id'])->update($nas);
    }

    /**
     * Edit Mikrotik API parameters with the given data
     *
     * @param array $data
     * @return void
     */
    private function _editMikrotikApiParameters($data)
    {
        $this->updateSetting('mikrotik_ip', '0', $data['mikrotikIP']);
        $this->updateSetting('mikrotik_api_port', '0', $data['mikrotikAPIPort']);
        $this->updateSetting('server_ip', '0', $data['serverIP']);
        $this->updateSetting('mikrotik_api_username', '0', $data['username']);
        $this->updateSetting('mikrotik_api_password', '0', $data['password']);
    }

    /**
     * Retrieve the setting value based on the setting name and module ID
     *
     * @param string $settingName
     * @param int $moduleId
     * @return mixed
     */
    public function getSetting($settingName, $moduleId)
    {
        $query = $this->setting
            ->where('module_id', $moduleId)
            ->where('setting', $settingName)
            ->first();
        return (!empty($query->value)) ? $query->value : "";
    }

    /**
     * Update the setting value based on the setting name, module ID, and new value
     *
     * @param string $settingName
     * @param int $moduleId
     * @param mixed $value
     * @return int
     */
    public function updateSetting($settingName, $moduleId, $value)
    {
        $affectedRows = $this->setting->where('module_id', $moduleId)
            ->where('setting', $settingName)
            ->update(['value' => $value]);

        return $affectedRows;
    }
}
