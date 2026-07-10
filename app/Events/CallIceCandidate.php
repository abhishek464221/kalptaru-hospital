<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallIceCandidate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $target_id;
    public $sender_id;
    public $candidate;

    public function __construct($target_id, $sender_id, $candidate)
    {
        $this->target_id = $target_id;
        $this->sender_id = $sender_id;
        $this->candidate = $candidate;
    }

    public function broadcastOn()
    {
        return new Channel('private.chat.' . $this->target_id);
    }

    public function broadcastAs()
    {
        return 'call-ice';
    }
}