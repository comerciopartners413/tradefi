<?php

namespace TradefiUBA\Events;

use TradefiUBA\TradeData;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GeneralExecutedDeal implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $trade;
    public function __construct(TradeData $trade)
    {
        $this->trade = $trade;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('general-executed-deal');
    }

    public function broadcastWith()
    {
        return [
            'Description'       => $this->trade->security->Description,
            'ProductID'         => $this->trade->security->ProductID,
            'Quantity'          => number_format($this->trade->Quantity, 2),
            'Price'             => $this->trade->Price != 0 ? number_format($this->trade->Price, 2) : number_format($this->trade->DiscountRate, 2),
            'Yield'             => number_format($this->trade->Yield, 4),
            'InputDatetime'     => $this->trade->InputDatetime,
            'TransactionTypeID' => $this->trade->TransactionTypeID,
        ];
    }
}
