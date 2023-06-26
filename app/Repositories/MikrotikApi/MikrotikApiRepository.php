<?php

namespace App\Repositories\MikrotikApi;

use LaravelEasyRepository\Repository;

interface MikrotikApiRepository extends Repository{

    /**
     * Fetches active Mikrotik users.
     * @param string $ip The IP address of the Mikrotik.
     * @param string $username The username to log into the Mikrotik.
     * @param string $password The password to log into the Mikrotik.
     */
    public function getMikrotikUserActive($ip, $username, $password);

    /**
     * Retrieves active hotspot data from Mikrotik.
     * @param string $ip The IP address of the Mikrotik.
     * @param string $username The username to log into the Mikrotik.
     * @param string $password The password to log into the Mikrotik.
     */
    public function getMikrotikActiveHotspot($ip, $username, $password);

    /**
     * Fetches resource data from Mikrotik.
     * @param string $ip The IP address of the Mikrotik.
     * @param string $username The username to log into the Mikrotik.
     * @param string $password The password to log into the Mikrotik.
     */
    public function getMikrotikResourceData($ip, $username, $password);

    /**
     * Retrieves traffic data for a specified interface from Mikrotik.
     * @param string $ip The IP address of the Mikrotik.
     * @param string $username The username to log into the Mikrotik.
     * @param string $password The password to log into the Mikrotik.
     * @param string $interface The interface for which to fetch traffic data.
     */
    public function getTrafficData($ip, $username, $password, $interface);

    /**
     * Fetches DHCP Leases data from Mikrotik.
     * @param string $ip The IP address of the Mikrotik.
     * @param string $username The username to log into the Mikrotik.
     * @param string $password The password to log into the Mikrotik.
     */
    public function getDhcpLeasesData($ip, $username, $password);

    /**
     * Fetches DHCP Leases records and prepares DataTables JSON response.
     * @param string $ip The IP address of the Mikrotik.
     * @param string $username The username to log into the Mikrotik.
     * @param string $password The password to log into the Mikrotik.
     * @return mixed DataTables JSON response or null if no data.
     */
    public function getDhcpLeasesDatatables($ip, $username, $password);

    /**
     * Establishes a connection to Mikrotik.
     * @param string $ip The IP address of the Mikrotik.
     * @param string $username The username to log into the Mikrotik.
     * @param string $password The password to log into the Mikrotik.
     */
    public function connect($ip, $username, $password);

}
