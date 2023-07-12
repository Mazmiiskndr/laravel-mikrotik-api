<?php

namespace App\Repositories\MikrotikApi;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\RouterOsApi;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class MikrotikApiRepositoryImplement extends Eloquent implements MikrotikApiRepository
{

    /**
     * 👇 Define RouterOS API endpoints 👇
     */
    // END POINT ROUTER OS API
    const ENDPOINT_ACTIVE_ROUTER_OS = "/ip/hotspot/active/print";
    const ENDPOINT_IP_BINDING_ROUTER_OS = "/ip/hotspot/ip-binding/print";
    const ENDPOINT_RESOURCE_ROUTER_OS = "/system/resource/print";
    const ENDPOINT_MONITOR_TRAFFIC_ROUTER_OS = "/interface/monitor-traffic";
    const ENDPOINT_HOTSPOT_SERVERS_ROUTER_OS = "/ip/hotspot/print";
    const ENDPOINT_IP_BINDING_ADD_ROUTER_OS = "/ip/hotspot/ip-binding/add";
    const ENDPOINT_IP_BINDING_SET_ROUTER_OS = '/ip/hotspot/ip-binding/set';
    const ENDPOINT_IP_BINDING_REMOVE_ROUTER_OS = '/ip/hotspot/ip-binding/remove';

    /**
     * 👇 Define CURL API endpoints 👇
     */
    // END POINT CURL
    const ENDPOINT_ACTIVE_CURL = "ip/hotspot/active/print";
    const ENDPOINT_IP_BINDING_CURL = "ip/hotspot/ip-binding/print";
    const ENDPOINT_RESOURCE_CURL = "system/resource/print";
    const ENDPOINT_MONITOR_TRAFFIC_CURL = "interface/monitor-traffic";


    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;
    protected $isConnected = false;

    // Construct function initializes Mikrotik Model
    public function __construct(RouterOsApi $model)
    {
        // Assuming this is where you're initializing the object to interact with Mikrotik API.
        $this->model = $model;
    }

    /**
     * Connect to a Mikrotik router.
     *
     * @param string $ip Router IP
     * @param string $username Username for authentication
     * @param string $password Password for authentication
     *
     * @return bool Connection status
     */
    // *** ⚠️ THIS IS FOR CONNECT ROUTER OS API NO CURL ⚠️ ***
    public function connect($ip, $username, $password)
    {
        // If already connected, return true
        if ($this->isConnected) {
            return true;
        }

        // Try to connect, log error and return false on failure
        if (!$this->model->connect($ip, $username, $password)) {
            Log::error('Failed to connect to Mikrotik router: ' . $ip);
            return false;
        }

        // Mark as connected on success
        $this->isConnected = true;

        // Return connection success
        return true;
    }


    // /**
    //  * Retrieves Mikrotik interface data via RouterOS API.
    //  * @param string $ip Mikrotik router IP address.
    //  * @param string $username Authentication username.
    //  * @param string $password Authentication password.
    //  * @return array|null Mikrotik interface data or null on connection failure.
    //  */
    // public function getMikrotikUserActive($ip, $username, $password)
    // {
    //     try {
    //         // Connect to the Mikrotik router. If connection fails, log the error and return null.
    //         if (!$this->model->connect($ip, $username, $password)) {
    //             Log::error('Failed to connect to Mikrotik router: ' . $ip);
    //             return null;
    //         }

    //         // Fetch list of active users and IP bindings
    //         $userActive = $this->model->comm(self::ENDPOINT_ACTIVE_ROUTER_OS);
    //         $ipBindings = $this->model->comm(self::ENDPOINT_IP_BINDING_ROUTER_OS);

    //         // Filter bypassed IP bindings
    //         $ipBindingBypassed = array_filter($ipBindings, function ($binding) {
    //             return isset($binding['type']) && $binding['type'] === 'bypassed' && isset($binding['disabled']) && $binding['disabled'] === "false";
    //         });

    //         // Filter blocked IP bindings
    //         $ipBindingBlocked = array_filter($ipBindings, function ($binding) {
    //             return isset($binding['type']) && $binding['type'] === 'blocked' && isset($binding['disabled']) && $binding['disabled'] === "false";
    //         });

    //         // Return the counts of active users, bypassed and blocked IP bindings
    //         return [
    //             'userActive' => count($userActive),
    //             'ipBindingBypassed' => count($ipBindingBypassed),
    //             'ipBindingBlocked' => count($ipBindingBlocked),
    //         ];
    //     } catch (\Exception $e) {
    //         // If any error occurs, log the error message and return null
    //         Log::error('Failed to get Mikrotik interface data: ' . $e->getMessage());
    //         return null;
    //     }
    // }

    // /**
    //  * Retrieves active hotspot data from a Mikrotik router.
    //  * @param string $ip The IP address of the Mikrotik router to connect to.
    //  * @param string $username The username used to authenticate with the Mikrotik router.
    //  * @param string $password The password credential required to access the Mikrotik router.
    //  * @return array|null The active hotspot data from the Mikrotik router, or null on error.
    //  */
    // public function getMikrotikActiveHotspot($ip, $username, $password)
    // {
    //     try {
    //         // Connect to the Mikrotik router. If connection fails, log the error and return null.
    //         if (!$this->model->connect($ip, $username, $password)) {
    //             Log::error('Failed to connect to Mikrotik router: ' . $ip);
    //             return null;
    //         }

    //         // Fetch active hotspot data
    //         $activeHotspot = $this->model->comm("/ip/hotspot/active/prnt");

    //         // Return the active hotspot data
    //         return count($activeHotspot);
    //     } catch (\Exception $e) {
    //         // If any error occurs, log the error message and return null
    //         Log::error('Failed to get Mikrotik active hotspot: ' . $e->getMessage());
    //         return null;
    //     }i
    // }

    // /**
    //  * Retrieves Mikrotik resource data via RouterOS API.
    //  * @param string $ip Mikrotik router IP address.
    //  * @param string $username Authentication username.
    //  * @param string $password Authentication password.
    //  * @return array|null Mikrotik resource data or null on connection failure.
    //  */
    // public function getMikrotikResourceData($ip, $username, $password)
    // {
    //     try {
    //         // Connect to the Mikrotik router. If connection fails, log the error and return null.
    //         if (!$this->model->connect($ip, $username, $password)) {
    //             Log::error('Failed to connect to Mikrotik router: ' . $ip);
    //             return null;
    //         }

    //         // Fetch system resource data
    //         $systemResource = $this->model->comm(self::ENDPOINT_RESOURCE_ROUTER_OS);

    //         if (empty($systemResource[0])) {
    //             Log::error('Failed to get Mikrotik resource data: Empty response.');
    //             return null;
    //         }

    //         // Extract the data from the response
    //         ['uptime' => $uptime, 'freeMemoryPercentage' => $freeMemoryPercentage, 'cpuLoad' => $cpuLoad] = $this->processSystemResource($systemResource[0]);

    //         // Fetch active hotspot data
    //         $activeHotspot = $this->getMikrotikActiveHotspot($ip, $username, $password);

    //         return [
    //             'uptime' => $uptime,
    //             'freeMemoryPercentage' => $freeMemoryPercentage,
    //             'cpuLoad' => $cpuLoad,
    //             'activeHotspot' => $activeHotspot,
    //         ];
    //     } catch (\Exception $e) {
    //         // If any error occurs, log the error message and return null
    //         Log::error('Failed to get Mikrotik resource data: ' . $e->getMessage());
    //         return null;
    //     }
    // }

    // /**
    //  * Method to get current upload and download traffic data from a Mikrotik router.
    //  * @param string $ip @param string $username @param string $password @param string $interface @return array
    //  */
    // public function getTrafficData($ip, $username, $password, $interface = null)
    // {
    //     // Connect to the Mikrotik router
    //     if (!$this->model->connect($ip, $username, $password)) {
    //         // If connection fails, return default values
    //         return [
    //             'uploadTraffic' => 0,
    //             'downloadTraffic' => 0
    //         ];
    //     }

    //     $interface  = env('MIKROTIK_INTERFACE');
    //     // Send the request to the monitor traffic endpoint
    //     $response = $this->model->comm(self::ENDPOINT_MONITOR_TRAFFIC_ROUTER_OS, [
    //         "interface" => $interface,
    //         "once" => ""
    //     ]);

    //     if (isset($response[0])) {
    //         // Get the traffic data
    //         $trafficData = $response[0];

    //         $uploadTraffic = isset($trafficData['tx-bits-per-second']) ? round($trafficData['tx-bits-per-second']) : 0;
    //         $downloadTraffic = isset($trafficData['rx-bits-per-second']) ? round($trafficData['rx-bits-per-second']) : 0;

    //         return [
    //             'uploadTraffic' => $uploadTraffic ,
    //             'downloadTraffic' => $downloadTraffic
    //         ];
    //     }

    //     return [
    //         'uploadTraffic' => 0,
    //         'downloadTraffic' => 0
    //     ];
    // }

    /**
     * Retrieves DHCP Leases data from a Mikrotik router via RouterOS API.
     *
     * @param string $ip The IP address of the Mikrotik router to connect to.
     * @param string $username The username used to authenticate with the Mikrotik router.
     * @param string $password The password credential required to access the Mikrotik router.
     * @return array|null The DHCP Leases data from the Mikrotik router, or null on error or connection failure.
     */
    // public function getDhcpLeasesData($ip, $username, $password)
    // {
    //     try {
    //         // Connect to the Mikrotik router. If connection fails, log the error and return null.
    //         if (!$this->model->connect($ip, $username, $password)) {
    //             Log::error('Failed to connect to Mikrotik router: ' . $ip);
    //             return null;
    //         }

    //         // Fetch DHCP Leases data
    //         $dhcpLeases = $this->model->comm("/ip/dhcp-server/lease/print");

    //         // Process the data: if 'Active Host Name' is null or doesn't exist, set it to 'Unknown'
    //         foreach ($dhcpLeases as &$lease) {
    //             if (!isset($lease['active-host-name']) || is_null($lease['active-host-name'])) {
    //                 $lease['active-host-name'] = 'Unknown';
    //             }
    //         }

    //         // Return the processed DHCP Leases data
    //         return $dhcpLeases;
    //     } catch (\Exception $e) {
    //         // If any error occurs, log the error message and return null
    //         Log::error('Failed to get Mikrotik DHCP Leases data: ' . $e->getMessage());
    //         return null;
    //     }
    // }

    /**
     * Retrieves Mikrotik hotspot servers data via RouterOS API.
     * @param string $ip Mikrotik router IP address.
     * @param string $username Authentication username.
     * @param string $password Authentication password.
     * @return array|null Mikrotik hotspot servers data or null on connection failure.
     */
    public function getMikrotikHotspotServers($ip, $username, $password)
    {
        try {
            // Connect to the Mikrotik router. If connection fails, log the error and return null.
            $this->connect($ip, $username, $password);


            // Fetch list of hotspot servers
            $hotspotServers = $this->model->comm(self::ENDPOINT_HOTSPOT_SERVERS_ROUTER_OS);

            // Check if 'name' field exists and collect all server names
            $serverNames = [];
            foreach ($hotspotServers as $server) {
                if (isset($server['name'])) {
                    $serverNames[] = $server['name'];
                }
            }

            // Return the list of server names
            return $serverNames;
        } catch (\Exception $e) {
            // If any error occurs, log the error message and return null
            Log::error('Failed to get Mikrotik hotspot servers data: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Creates or updates an IP binding entry via RouterOS API.
     * @param string $ip Mikrotik router IP address.
     * @param string $username Authentication username.
     * @param string $password Authentication password.
     * @param array $data The data for the IP binding.
     * @return string|null The Mikrotik ID of the created or updated IP binding or null on failure.
     */
    public function createOrUpdateMikrotikIpBinding($ip, $username, $password, $data)
    {
        try {
            // Connect to the Mikrotik router. If connection fails, log the error and return null.
            $this->connect($ip, $username, $password);

            // Prepare the common data for create and update operations.
            $commonData = $this->prepareCommonDataMikrotikIpBinding($data);

            // Check if 'mikrotikId' is set in the data. If it is, perform an update operation. If not, perform a create operation.
            if (isset($data['mikrotikId'])) {
                // Update the IP binding
                $this->model->comm(self::ENDPOINT_IP_BINDING_SET_ROUTER_OS, array_merge(['.id' => $data['mikrotikId']], $commonData));
            } else {
                // Create the IP binding
                $this->model->comm(self::ENDPOINT_IP_BINDING_ADD_ROUTER_OS, $commonData);
            }

            // Query the IP bindings to get the ID of the binding that was just created or updated.
            $ipBindings = $this->model->comm(self::ENDPOINT_IP_BINDING_ROUTER_OS);

            // Filter the IP bindings to find the one that was just created or updated.
            $savedIpBinding = array_filter($ipBindings, function ($binding) use ($data) {
                return $binding['mac-address'] == $data['macAddress'];
            });

            // If the IP binding was found, return its ID.
            if (count($savedIpBinding) > 0) {
                $savedIpBinding = reset($savedIpBinding);
                return $savedIpBinding['.id'];
            }

            Log::error('Failed to retrieve the ID of the saved IP binding.');
            return null;
        } catch (\Exception $e) {
            // If any error occurs, log the error message and return null
            Log::error('Failed to save IP binding: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Deletes an IP binding entry via RouterOS API.
     * @param string $ip Mikrotik router IP address.
     * @param string $username Authentication username.
     * @param string $password Authentication password.
     * @param string $mikrotikId The Mikrotik ID of the IP binding.
     * @return bool Whether the deletion was successful.
     */
    public function deleteMikrotikIpBinding($ip, $username, $password, $mikrotikId)
    {
        try {
            // Connect to the Mikrotik router. If connection fails, log the error and return null.
            $this->connect($ip, $username, $password);

            // Delete the IP binding
            $this->model->comm(self::ENDPOINT_IP_BINDING_REMOVE_ROUTER_OS, ['.id' => $mikrotikId]);

            return true;
        } catch (\Exception $e) {
            // If any error occurs, log the error message and return false
            Log::error('Failed to delete IP binding: ' . $e->getMessage());
            return false;
        }
    }

    // 👇 🌟🌟🌟 PRIVATES FUNCTION FOR IP BINDING 🌟🌟🌟 👇

    /**
     * The function prepares common data for creating and updating Mikrotik IP bindings in PHP.
     * @param data The parameter `` is an array that contains the following keys:
     * @return An array is being returned.
     */
    private function prepareCommonDataMikrotikIpBinding($data)
    {
        // Prepare the common data for create and update operations.
        return [
            'mac-address' => $data['macAddress'],
            'type' => $data['status'],
            "comment" => "Managed by AZMI. DO NOT EDIT!!!",
            'server' => $data['server']
        ];
    }

    // 👇 🌟🌟🌟 GET Request to the Mikrotik router. WITH CURL 🌟🌟🌟 👇

    /**
     * Fetches active hotspot data from a Mikrotik device using cURL.
     * @param string $ip The IP address of the Mikrotik device.
     * @param string $username The username for the Mikrotik device.
     * @param string $password The password for the Mikrotik device.
     * @return int|null Returns the number of active hotspots, or null if the connection fails.
     */
    public function getMikrotikActiveHotspot($ip, $username, $password)
    {
        // Retrieve active hotspot data from the Mikrotik device
        $hotspotActive = $this->connectAndRetrieveData($ip, $username, $password, 'ip/hotspot/active/print', ['count-only' => 'true']);

        // Return null if the connection failed
        if ($hotspotActive === null) {
            return null;
        }

        // Return the number of active hotspots
        return $hotspotActive['ret'];
    }

    /**
     * Method to get current upload and download traffic data from a Mikrotik router with CURL.
     * @param string $ip @param string $username @param string $password @param string $interface @return array
     */
    public function getTrafficData($ip, $username, $password, $interface)
    {
        // Set the interface to monitor traffic on (if not set, use the default interface)
        if (!$interface) {
            $interface = env('MIKROTIK_INTERFACE');
        }

        // Monitor the traffic on the interface
        $command    = self::ENDPOINT_MONITOR_TRAFFIC_CURL;
        $data       = [
            "interface" => $interface,
            "once" => "",
            ".proplist" => ["rx-bits-per-second", "tx-bits-per-second"]
        ];
        // Send the request to the monitor traffic endpoint
        $response = $this->model->connectCurl($ip, $username, $password, $command, $data);

        // If the request was not successful, return zero traffic
        if ($response === false || !is_array($response) || empty($response) || isset($response['error']) == 400) {
            // If connection fails, return default values
            return [
                'uploadTraffic' => 0,
                'downloadTraffic' => 0
            ];
        }

        // Get the first item in the response (assuming that the response is an array of items)
        $trafficData = $response[0];
        // Get the traffic data from the response
        $uploadTraffic = isset($trafficData['tx-bits-per-second']) ? $trafficData['tx-bits-per-second'] : 0;
        $downloadTraffic = isset($trafficData['rx-bits-per-second']) ? $trafficData['rx-bits-per-second']  : 0;

        // Return the traffic data
        return [
            'uploadTraffic' => $uploadTraffic,
            'downloadTraffic' => $downloadTraffic
        ];
    }

    /**
     * Retrieves Mikrotik interface data via RouterOS API CURL.
     * @param string $ip Mikrotik router IP address.
     * @param string $username Authentication username.
     * @param string $password Authentication password.
     * @return array|null Mikrotik interface data or null on connection failure.
     */
    public function getMikrotikUserActive($ip, $username, $password)
    {
        try {
            // Establish a connection and retrieve active users data
            $userActive = $this->connectAndRetrieveData($ip, $username, $password, self::ENDPOINT_ACTIVE_CURL, ['count-only' => 'true']);

            // Check if the system resource data is valid
            if ($userActive === null) {
                // Return null if system resource data is not valid
                return null;
            }

            // Establish a connection and retrieve IP bindings data for blocked users
            $ipBindingsBlocked = $this->getIpBindingsCount($ip, $username, $password, 'blocked');
            if ($ipBindingsBlocked === null) {
                Log::error('Failed to connect to Mikrotik router or fetch IP bindings data Blocked: ' . $ip);
                return null;
            }

            // Establish a connection and retrieve IP bindings data for bypassed users
            $ipBindingsBypassed = $this->getIpBindingsCount($ip, $username, $password, 'bypassed');
            if ($ipBindingsBypassed === null) {
                Log::error('Failed to connect to Mikrotik router or fetch IP bindings data Bypassed: ' . $ip);
                return null;
            }
            // Return the counts of active users, bypassed and blocked IP bindings
            return [
                'userActive' => $userActive !== null ? intval($userActive['ret']) : 0,
                'ipBindingBypassed' => intval($ipBindingsBypassed),
                'ipBindingBlocked' => intval($ipBindingsBlocked),
            ];
        } catch (\Exception $e) {
            // If any error occurs, log the error message and return null
            Log::error('Failed to get Mikrotik interface data: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Fetches system resource and active hotspot data from a Mikrotik device using cURL.
     * @param string $ip The IP address of the Mikrotik device.
     * @param string $username The username for the Mikrotik device.
     * @param string $password The password for the Mikrotik device.
     * @return array|null Returns an array with keys 'uptime', 'freeMemoryPercentage', 'cpuLoad', 'activeHotspot'
     */
    public function getMikrotikResourceData($ip, $username, $password)
    {
        // Retrieve system resource data from the Mikrotik device
        $systemResource = $this->connectAndRetrieveData($ip, $username, $password, self::ENDPOINT_RESOURCE_CURL, [".proplist" => ["uptime", "cpu-load", "free-memory", "total-memory"]]);

        // Check if the system resource data is valid
        if ($systemResource === null) {
            // Return null if system resource data is not valid
            return null;
        }

        // Process the system resource data and get the needed values
        ['uptime' => $uptime, 'freeMemoryPercentage' => $freeMemoryPercentage, 'cpuLoad' => $cpuLoad] = $this->processSystemResource($systemResource[0]);

        // Retrieve active hotspot count
        $activeHotspot = $this->getMikrotikActiveHotspot($ip, $username, $password);

        // Return an array with all the retrieved and processed data
        return [
            'uptime' => $uptime,
            'freeMemoryPercentage' => $freeMemoryPercentage,
            'cpuLoad' => $cpuLoad,
            'activeHotspot' => $activeHotspot
        ];
    }

    /**
     * Gets DHCP Leases data from a Mikrotik device
     * @param string $ip IP address of the Mikrotik device
     * @param string $username Username for accessing the Mikrotik device
     * @param string $password Password for accessing the Mikrotik device
     * @return array|null The processed DHCP Leases data or null in case of any error
     * @throws \Exception In case of any error during the operation
     */
    public function getDhcpLeasesData($ip, $username, $password)
    {
        try {
            // Fetch the raw DHCP Leases data from the Mikrotik device
            $dhcpLeasesData = $this->fetchDhcpLeasesData($ip, $username, $password);

            // If data fetch failed (null returned), return null early to end the function
            if ($dhcpLeasesData === null) {
                return null;
            }

            // If data fetch was successful, process the raw data into the desired format
            // and return the processed data
            return $this->processDhcpLeasesData($dhcpLeasesData);
        } catch (\Exception $e) {
            // If an error occurs at any point in the try block, log the error message
            Log::error('Failed to get DHCP Leases data: ' . $e->getMessage());

            // Then, rethrow the error to be handled by the calling function or the global error handler
            throw $e;
        }
    }

    /**
     * Retrieves DHCP Leases records from a database, initializes DataTables, adds columns to DataTable.
     * @return DataTables Yajra JSON response or null if there's no data.
     */
    public function getDhcpLeasesDatatables($ip, $username, $password)
    {
        // Retrieve and process the DHCP Leases data
        $dhcpLeasesData = $this->getDhcpLeasesData($ip, $username, $password);

        // If there's no data or data fetch failed, return null early to end the function
        if (empty($dhcpLeasesData)) {
            return null;
        }

        // Initialize DataTables and add columns to the table
        return DataTables::of($dhcpLeasesData)
            ->addIndexColumn()
            ->addColumn('ip_address', function ($data) {
                return $data['address'];
            })
            ->addColumn('mac_address', function ($data) {
                return $data['mac-address'];
            })
            ->addColumn('host_name', function ($data) {
                return $data['host-name'];
            })
            ->rawColumns(['ip_address', 'mac_address', 'host_name'])
            ->make(true);
    }

    // 👇 🌟🌟🌟 PROTECTED FUNCTIONS 🌟🌟🌟 👇

    /**
     * Process system resource data.
     * @param array $resourceData
     * @return array processed data
     */
    protected function processSystemResource(array $resourceData): array
    {
        // Get the needed values from the system resource data
        $uptime = $resourceData['uptime'] ?? null;
        $freeMemory = $resourceData['free-memory'] ?? null;
        $totalMemory = $resourceData['total-memory'] ?? null;
        $cpuLoad = $resourceData['cpu-load'] ?? null;

        // Calculate the free memory percentage
        $freeMemoryPercentage = $freeMemory && $totalMemory ? number_format(($freeMemory / $totalMemory) * 100, 2) . "%" : null;

        // Parse Mikrotik uptime format to a more common format
        $uptime = $this->parseUptime($uptime);

        // Add a percent sign to the CPU Load percentage before returning
        // $cpuLoad .= "%";

        return compact('uptime', 'freeMemoryPercentage', 'cpuLoad');
    }

    /**
     * Parse Mikrotik uptime format to a more common format.
     * @param string|null $uptime
     * @return string
     */
    protected function parseUptime($uptime)
    {
        if ($uptime) {
            // Parse the uptime string using a regex pattern
            $pattern = "/(?:(\d+)w)?(?:(\d+)d)?(?:(\d+)h)?(?:(\d+)m)?(?:(\d+)s)?/";
            preg_match($pattern, $uptime, $matches);

            // Get the values from the matches
            $weeks = intval($matches[1] ?? 0);
            $days = intval($matches[2] ?? 0);
            $hours = intval($matches[3] ?? 0);
            $minutes = intval($matches[4] ?? 0);
            $seconds = intval($matches[5] ?? 0);

            // Convert weeks to days
            $days += 7 * $weeks;

            // Construct uptime string in format "dd hh:mm:ss"
            $uptime = sprintf("%dd %02d:%02d:%02d", $days, $hours, $minutes, $seconds);
        }
        // Return the parsed uptime string
        return $uptime;
    }

    // 👇 🌟🌟🌟 PRIVATE FUNCTIONS 🌟🌟🌟 👇

    /**
     * Retrieves the count of IP bindings based on the type.
     * @param string $ip The IP address of the device.
     * @param string $username The username for authentication.
     * @param string $password The password for authentication.
     * @param string $type The type of IP binding (e.g. 'blocked', 'bypassed').
     * @return int The count of IP bindings, or 0 if the connection fails.
     */
    private function getIpBindingsCount($ip, $username, $password, $type)
    {
        // Define the MikroTik API command.
        $command = self::ENDPOINT_IP_BINDING_CURL;

        // Define the data for the command (request the count only).
        $data = [
            'count-only' => 'true',
            '.query' => [
                'type=' . $type,
                'disabled=false'
            ]
        ];

        // Establish a connection and retrieve the IP bindings data.
        $ipBindings = $this->model->connectCurl($ip, $username, $password, $command, $data);

        // Return the count of IP bindings, or 0 if the connection failed.
        return $ipBindings !== null ? intval($ipBindings['ret']) : 0;
    }

    /**
     * Handles cURL connections to the Mikrotik router
     * @param string $ip The IP address of the Mikrotik device.
     * @param string $username The username for the Mikrotik device.
     * @param string $password The password for the Mikrotik device.
     * @param string $command The command to execute on the Mikrotik device.
     * @param array $data The data to send with the command.
     * @return array|null Returns the response from the Mikrotik device, or null if the connection fails.
     */
    private function connectAndRetrieveData($ip, $username, $password, $command, $data)
    {
        // Try block for error handling
        try {
            // Using model function to connect to Mikrotik device and retrieve data
            $response = $this->model->connectCurl($ip, $username, $password, $command, $data);

            // Checking if the response is valid
            if ($response === false || !is_array($response) || empty($response) || isset($response['error'])) {
                throw new \Exception("Failed to get data. Empty response or error.");
            }

            // Return the valid response data
            return $response;
        } catch (\Exception $e) {
            // Logging the error message for debugging purposes
            Log::error('Failed to get data: ' . $e->getMessage());

            // Return null on failure
            return null;
        }
    }

    /**
     * Fetches DHCP Leases data from a Mikrotik device
     * @param string $ip IP address of the Mikrotik device
     * @param string $username Username for accessing the Mikrotik device
     * @param string $password Password for accessing the Mikrotik device
     * @return array|null The fetched DHCP Leases data or null in case of any error
     */
    private function fetchDhcpLeasesData($ip, $username, $password)
    {
        // Set the endpoint for DHCP Leases
        $dhcpLeasesEndpoint = "ip/dhcp-server/lease/print";
        $dhcpData = [
            'detail' => '',
            '.query' => [
                'disabled=false'
            ]
        ];

        // Retrieve DHCP Leases data from the Mikrotik device
        return $this->connectAndRetrieveData($ip, $username, $password, $dhcpLeasesEndpoint, $dhcpData);
    }

    /**
     * Processes the fetched DHCP Leases data
     * It maps over each DHCP Lease data item, replaces null hostname with 'Unknown',
     * checks if disabled = false, and returns only mac-address, address, and host-name
     * @param array $dhcpLeasesData The fetched DHCP Leases data
     * @return array The processed DHCP Leases data
     */
    private function processDhcpLeasesData($dhcpLeasesData)
    {
        // Map over each DHCP Lease data item and process it
        $processedData = array_map([$this, 'processDhcpLeaseData'], $dhcpLeasesData);

        // Remove null values from the processed data
        return array_filter($processedData);
    }

    /**
     * Processes a single DHCP Lease data item
     * It replaces null hostname with 'Unknown', checks if disabled = false,
     * and returns only mac-address, address, and host-name
     * @param array $item A DHCP Lease data item
     * @return array|null The processed DHCP Lease data item or null if disabled is not false
     */
    private function processDhcpLeaseData($item)
    {
        // Replace null hostname with 'Unknown'
        if (!isset($item['host-name']) || $item['host-name'] === null) {
            $item['host-name'] = 'Unknown';
        }

        // Check if disabled = false and return only mac-address, address, and host-name
        if ($item['disabled'] === 'false') {
            return [
                'mac-address' => $item['mac-address'] ?? null,
                'address' => $item['address'] ?? null,
                'host-name' => $item['host-name'],
            ];
        }

        // Return null if disabled is not false
        return null;
    }

}
