<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityPerformed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username, $action, $path, $params, $ip;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($username, $action, $path, $params, $ip)
    {
        $this->username = $username;
        $this->action = $action;
        $this->path = $path;
        $this->params = $params;
        $this->ip = $ip;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
