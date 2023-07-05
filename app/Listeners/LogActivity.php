<?php

namespace App\Listeners;

use App\Events\ActivityPerformed;
use App\Models\RootActivity;
use App\Services\Setting\SettingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogActivity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ActivityPerformed  $event
     * @return void
     */
    public function handle(ActivityPerformed $event)
    {
        $settingService = app(SettingService::class);
        $activities = $settingService->getSetting('log_activities', 'default');
        if($activities == '0') {
            return;
        }
        RootActivity::create([
            'username' => $event->username,
            'module' => $event->action,
            'page' => $event->path,
            'timestamp' => now()->timestamp,
            'browser_name' => $event->params['browser_name'],
            'browser_version' => $event->params['browser_version'],
            'os_name' => $event->params['os_name'],
            'os_version' => $event->params['os_version'],
            'device_type' => $event->params['device_type'],
            'params' => json_encode($event->params),
            'ip' => $event->ip,
        ]);
    }
}
