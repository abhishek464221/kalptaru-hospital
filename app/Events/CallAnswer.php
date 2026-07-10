<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallAnswer implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $caller_id;
    public $receiver_id;
    public $answer;

    public function __construct($caller_id, $receiver_id, $answer)
    {
        $this->caller_id = $caller_id;
        $this->receiver_id = $receiver_id;
        $this->answer = $answer;
    }

    public function broadcastOn()
    {
        return new Channel('private.chat.' . $this->caller_id);
    }

    public function broadcastAs()
    {
        return 'call-answer';
    }
}