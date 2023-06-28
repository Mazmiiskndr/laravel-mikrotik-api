<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;

class CheckSessionCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Get all queued cookies
        $sessionKey = Cookie::get('session_key') ?? \App\Helpers\SessionKeyHelper::getQueuedSessionKey();
        $redisKey = '_redis_key_prefix_' . $sessionKey;

        // Check session cookie!
        if (!$sessionKey || !Redis::exists($redisKey)) {

            // Sesi or cookie not valid!
            return redirect('')->with('error', 'You are not logged in. Please log in to access the page.');
        }

        // Sesi or cookie valid!
        return $next($request);
    }
}
