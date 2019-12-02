<?php

namespace TradefiUBA\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DealExecuted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $gl;
    public $user;
    public $trade;
    // public $deal;

    public function __construct($gl, $user, $trade)
    {
        $this->gl    = $gl;
        $this->user  = $user;
        $this->trade = $trade;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('deal-executed.' . $this->user->id);
    }

    public function broadcastWith()
    {
        return [
            'data' => [
                'Description'    => $this->trade->security->Description,
                'BookBalance'    => $this->gl->BookBalance,
                'ClearedBalance' => $this->gl->ClearedBalance,
            ],
        ];
    }
}
