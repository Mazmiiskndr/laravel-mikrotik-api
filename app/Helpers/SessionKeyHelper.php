<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Cookie;

trait SessionKeyHelper
{
    public static function getQueuedSessionKey()
    {
        // Get all queued cookies
        $queuedCookies = Cookie::getQueuedCookies();
        // Initialize the $sessionKey variable as null
        $sessionKey = null;

        // Iterate through each queued cookie
        foreach ($queuedCookies as $cookie) {
            // Check if the current cookie's name is 'session_key'
            if ($cookie->getName() === 'session_key') {
                // If found, set the $sessionKey variable with the cookie's value
                $sessionKey = $cookie->getValue();
                break;
            }
        }
        // Return the session_key value if found, or null if not found
        return $sessionKey;
    }
}
