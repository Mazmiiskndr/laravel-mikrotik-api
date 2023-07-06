<?php

namespace App\Services\MikrotikApi;

use LaravelEasyRepository\Service;
use App\Repositories\MikrotikApi\MikrotikApiRepository;
use App\Traits\HandleRepositoryCall;
use Exception;

class MikrotikApiServiceImplement extends Service implements MikrotikApiService
{
    use HandleRepositoryCall;

    protected $mainRepository;
    /**
     * Constructor.
     * @param MikrotikApiRepository $mainRepository The main repository for settings.
     */
    public function __construct(MikrotikApiRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Retrieves active Mikrotik users using the provided IP, username, and password.
     * @param string $ip The IP address of the Mikrotik router.
     * @param string $username The username used to authenticate with the Mikrotik router.
     * @param string $password The password needed to authenticate the user when connecting to the Mikrotik router.
     * @return mixed The result of calling the `getMikrotikUserActive` method of the `mainRepository` object.
     * @throws Exception If an error occurs while retrieving active users.
     */
    public function getMikrotikUserActive($ip, $username, $password)
    {
        return $this->handleRepositoryCall('getMikrotikUserActive', [$ip, $username, $password]);
    }

    /**
     * Retrieves Active Hotspot using the provided IP, username, and password.
     * @param string $ip The IP address of the Mikrotik router.
     * @param string $username The username used to authenticate with the Mikrotik router.
     * @param string $password The password needed to authenticate the user when connecting to the Mikrotik router.
     * @return mixed The result of calling the `getMikrotikActiveHotspot` method of the `mainRepository` object.
     * @throws Exception If an error occurs while retrieving active hotspots.
     */
    public function getMikrotikActiveHotspot($ip, $username, $password)
    {
        return $this->handleRepositoryCall('getMikrotikActiveHotspot', [$ip, $username, $password]);
    }

    /**
     * Retrieves Resource data using the provided IP, username, and password.
     * @param string $ip The IP address of the Mikrotik router.
     * @param string $username The username used to authenticate with the Mikrotik router.
     * @param string $password The password needed to authenticate the user when connecting to the Mikrotik router.
     * @return mixed The result of calling the `getMikrotikResourceData` method of the `mainRepository` object.
     * @throws Exception If an error occurs while retrieving resource data.
     */
    public function getMikrotikResourceData($ip, $username, $password)
    {
        return $this->handleRepositoryCall('getMikrotikResourceData', [$ip, $username, $password]);
    }

    /**
     * Fetches traffic data from the specified network interface of a device.
     * @param string $ip IP address of the device.
     * @param string $username Username for authentication.
     * @param string $password Password for authentication.
     * @param string $interface Network interface to monitor.
     * @return array Returns traffic data or throws an exception if an error occurs.
     * @throws Exception if unable to retrieve traffic data.
     */
    public function getTrafficData($ip, $username, $password, $interface)
    {
        return $this->handleRepositoryCall('getTrafficData', [$ip, $username, $password, $interface]);
    }

    /**
     * Fetches DHCP Leases Data from the specified network interface of a device.
     * @param string $ip IP address of the device.
     * @param string $username Username for authentication.
     * @param string $password Password for authentication.
     * @return array Returns DHCP Leases Data or throws an exception if an error occurs.
     * @throws Exception if unable to retrieve DHCP Leases Data.
     */
    public function getDhcpLeasesData($ip, $username, $password)
    {
        return $this->handleRepositoryCall('getDhcpLeasesData', [$ip, $username, $password]);
    }

    /**
     * Retrieves DHCP Leases records from a database, initializes DataTables, adds columns to DataTable.
     * @param string $ip IP address of the device.
     * @param string $username Username for authentication.
     * @param string $password Password for authentication.
     * @return mixed The result of calling the `getDhcpLeasesDatatables` method of the `mainRepository` object.
     * @throws Exception If an error occurs while retrieving DHCP leases datatable.
     */
    public function getDhcpLeasesDatatables($ip, $username, $password)
    {
        return $this->handleRepositoryCall('getDhcpLeasesDatatables', [$ip, $username, $password]);
    }

    /**
     * Try to connect from the specified network interface of a device.
     * @param string $ip IP address of the device.
     * @param string $username Username for authentication.
     * @param string $password Password for authentication.
     * @return array Returns connect or throws an exception if an error occurs.
     * @throws Exception if unable to connect.
     */
    public function connect($ip, $username, $password)
    {
        return $this->handleRepositoryCall('connect', [$ip, $username, $password]);
    }

}
