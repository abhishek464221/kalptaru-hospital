<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallOffer implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $caller_id;
    public $receiver_id;
    public $offer;
    public $call_type;

    public function __construct($caller_id, $receiver_id, $offer, $call_type)
    {
        $this->caller_id = $caller_id;
        $this->receiver_id = $receiver_id;
        $this->offer = $offer;
        $this->call_type = $call_type;
    }

    public function broadcastOn()
    {
        return new Channel('private.chat.' . $this->receiver_id);
    }

    public function broadcastAs()
    {
        return 'call-offer';
    }
}