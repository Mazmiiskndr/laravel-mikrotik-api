<?php

namespace App\Http\Middleware;

use App\Events\ActivityPerformed;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
use Jenssegers\Agent\Agent;

class ActivityLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * This function does a few things:
     * - It retrieves session data related to the user.
     * - It gets additional information about the user's device, OS, and browser.
     * - It triggers an event that logs this activity.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the session key from the cookie or the queued cookies
        $sessionKey = $this->getSessionKey();
        $redisKey = '_redis_key_prefix_' . $sessionKey;

        // Retrieve the session data from Redis
        $sessionData = Redis::hGetAll($redisKey);

        if ($sessionData) {
            // Extract relevant session data
            $username = $sessionData['username'];
            $path = $request->path();
            $params = $request->all();
            $ip = $request->ip();
            $module = $this->getModuleFromPath($path);

            // Use Jenssegers\Agent to get browser, version, OS, and device type
            $additionalParams = $this->getAdditionalParams();

            // Merge the additional parameters with the request parameters
            $params = array_merge($params, $additionalParams);

            // Trigger the ActivityPerformed event
            event(new ActivityPerformed($username, $module, $path, $params, $ip));
        }

        // Proceed with the request and get the response
        return $next($request);
    }


    /**
     * Retrieve the session key from the cookies.
     * @return string|null
     */
    protected function getSessionKey()
    {
        return Cookie::get('session_key') ?? \App\Helpers\SessionKeyHelper::getQueuedSessionKey();
    }

    /**
     * Extract the module name from the path.
     * @param string $path
     * @return string
     */
    protected function getModuleFromPath(string $path)
    {
        $pathSegments = explode('/', $path);
        return $pathSegments[0];
    }

    /**
     * Use Jenssegers\Agent to get information about the user's device, OS, and browser.
     * @return array
     */
    protected function getAdditionalParams()
    {
        $agent = new Agent();
        $browser = $agent->browser();
        $browserVersionString = $agent->version($browser);
        $browserVersionParts = explode('.', $browserVersionString);
        $browserVersion = intval($browserVersionParts[0]);
        $os = $agent->platform();
        $osVersion = $agent->version($os);
        $deviceType = ($agent->isDesktop() ? 'Desktop' : ($agent->isMobile() ? 'Mobile' : 'Tablet'));

        return [
            'browser_name' => $browser,
            'browser_version' => $browserVersion,
            'os_name' => $os,
            'os_version' => $osVersion,
            'device_type' => $deviceType,
        ];
    }
}
