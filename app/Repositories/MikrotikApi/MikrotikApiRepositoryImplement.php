<?php

namespace App\Repositories\MikrotikApi;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\RouterOsApi;
use Illuminate\Support\Facades\Log;

class MikrotikApiRepositoryImplement extends Eloquent implements MikrotikApiRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(RouterOsApi $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieves Mikrotik interface data via RouterOS API.
     * @param string $ip Mikrotik router IP address.
     * @param string $username Authentication username.
     * @param string $password Authentication password.
     * @return array|null Mikrotik interface data or null on connection failure.
     */
    public function getMikrotikUserActive($ip, $username, $password)
    {
        try {
            // Connect to the Mikrotik router. If connection fails, log the error and return null.
            if (!$this->model->connect($ip, $username, $password)) {
                Log::error('Failed to connect to Mikrotik router: ' . $ip);
                return null;
            }

            // Fetch list of active users and IP bindings
            $userActive = $this->model->comm("/ip/hotspot/active/print");
            $ipBindings = $this->model->comm("/ip/hotspot/ip-binding/print");

            // Filter bypassed IP bindings
            $ipBindingBypassed = array_filter($ipBindings, function ($binding) {
                return isset($binding['type']) && $binding['type'] === 'bypassed';
            });

            // Filter blocked IP bindings
            $ipBindingBlocked = array_filter($ipBindings, function ($binding) {
                return isset($binding['type']) && $binding['type'] === 'blocked';
            });

            // Return the counts of active users, bypassed and blocked IP bindings
            return [
                'userActive' => count($userActive),
                'ipBindingBypassed' => count($ipBindingBypassed),
                'ipBindingBlocked' => count($ipBindingBlocked),
            ];
        } catch (\Exception $e) {
            // If any error occurs, log the error message and return null
            Log::error('Failed to get Mikrotik interface data: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Retrieves active hotspot data from a Mikrotik router.
     * @param string $ip The IP address of the Mikrotik router to connect to.
     * @param string $username The username used to authenticate with the Mikrotik router.
     * @param string $password The password credential required to access the Mikrotik router.
     * @return array|null The active hotspot data from the Mikrotik router, or null on error.
     */
    public function getMikrotikActiveHotspot($ip, $username, $password)
    {
        try {
            // Connect to the Mikrotik router. If connection fails, log the error and return null.
            if (!$this->model->connect($ip, $username, $password)) {
                Log::error('Failed to connect to Mikrotik router: ' . $ip);
                return null;
            }

            // Fetch active hotspot data
            $activeHotspot = $this->model->comm("/ip/hotspot/active/print");

            // Return the active hotspot data
            return count($activeHotspot);
        } catch (\Exception $e) {
            // If any error occurs, log the error message and return null
            Log::error('Failed to get Mikrotik active hotspot: ' . $e->getMessage());
            return null;
        }
    }

    // TODO:
    /**
     * Retrieves Mikrotik resource data via RouterOS API.
     * @param string $ip Mikrotik router IP address.
     * @param string $username Authentication username.
     * @param string $password Authentication password.
     * @return array|null Mikrotik resource data or null on connection failure.
     */
    public function getMikrotikResourceData($ip, $username, $password)
    {
        try {
            // Connect to the Mikrotik router. If connection fails, log the error and return null.
            if (!$this->model->connect($ip, $username, $password)) {
                Log::error('Failed to connect to Mikrotik router: ' . $ip);
                return null;
            }

            // Fetch system resource data
            $systemResource = $this->model->comm("/system/resource/print");

            if (empty($systemResource[0])) {
                Log::error('Failed to get Mikrotik resource data: Empty response.');
                return null;
            }

            // Extract the data from the response
            $uptime = $systemResource[0]['uptime'] ?? null;
            $freeMemory = $systemResource[0]['free-memory'] ?? null;
            $totalMemory = $systemResource[0]['total-memory'] ?? null;
            $cpuLoad = $systemResource[0]['cpu-load'] ?? null;

            // Calculate the free memory percentage
            $freeMemoryPercentage = $freeMemory && $totalMemory ? number_format(($freeMemory / $totalMemory) * 100, 2) . "%" : null;

            // Parse Mikrotik uptime format to a more common format
            if ($uptime) {
                $pattern = "/(?:(\d+)w)?(?:(\d+)d)?(?:(\d+)h)?(?:(\d+)m)?(?:(\d+)s)?/";
                preg_match($pattern, $uptime, $matches);

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

            // Add a percent sign to the CPU Load percentage before returning
            $cpuLoad .= "%";

            // Fetch active hotspot data
            $activeHotspot = $this->getMikrotikActiveHotspot($ip, $username, $password);

            return [
                'uptime' => $uptime,
                'freeMemoryPercentage' => $freeMemoryPercentage,
                'cpuLoad' => $cpuLoad,
                'activeHotspot' => $activeHotspot,
            ];
        } catch (\Exception $e) {
            // If any error occurs, log the error message and return null
            Log::error('Failed to get Mikrotik resource data: ' . $e->getMessage());
            return null;
        }
    }

}