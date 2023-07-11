<?php

namespace App\Services\MikrotikApi;

use LaravelEasyRepository\BaseService;

interface MikrotikApiService extends BaseService{

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
     * Retrieves Mikrotik hotspot servers data via RouterOS API.
     * @param string $ip Mikrotik router IP address.
     * @param string $username Authentication username.
     * @param string $password Authentication password.
     * @return array|null Mikrotik hotspot servers data or null on connection failure.
     */
    public function getMikrotikHotspotServers($ip, $username, $password);

    /**
     * Creates a new IP binding entry via RouterOS API.
     * @param string $ip Mikrotik router IP address.
     * @param string $username Authentication username.
     * @param string $password Authentication password.
     * @param string $data The MAC address, Server and Type.
     * @return string|null The Mikrotik ID of the newly created IP binding or null on failure.
     */
    public function createMikrotikIpBinding($ip, $username, $password, $data);

    /**
     * Updates an IP binding entry via RouterOS API.
     * @param string $ip Mikrotik router IP address.
     * @param string $username Authentication username.
     * @param string $password Authentication password.
     * @param string $data The MAC address, Server and Type.
     * @return string|null The Mikrotik ID of the updated IP binding or null on failure.
     */
    public function updateMikrotikIpBinding($ip, $username, $password, $data);

    /**
     * Deletes an IP binding entry via RouterOS API.
     * @param string $ip Mikrotik router IP address.
     * @param string $username Authentication username.
     * @param string $password Authentication password.
     * @param string $mikrotikId The Mikrotik ID of the IP binding.
     * @return bool Whether the deletion was successful.
     */
    public function deleteMikrotikIpBinding($ip, $username, $password, $mikrotikId);

    /**
     * Establishes a connection to Mikrotik.
     * @param string $ip The IP address of the Mikrotik.
     * @param string $username The username to log into the Mikrotik.
     * @param string $password The password to log into the Mikrotik.
     */
    public function connect($ip, $username, $password);

}
