<?php

namespace TradefiUBA\Events;

use TradefiUBA\TradeList;
use Illuminate\Broadcasting\Channel;
// use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TradeCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $trade_data_buy;
    public $trade_data_sell;
    public function __construct(TradeList $trade_data_buy, TradeList $trade_data_sell)
    {
        $this->trade_data_buy  = $trade_data_buy;
        $this->trade_data_sell = $trade_data_sell;
    }

    public function broadcastOn()
    {
        return new Channel('traderoom_creation');
    }

    public function broadcastWith()
    {
        return [
            'security'    => $this->trade_data_buy->SecurityID,
            'description' => \TradefiUBA\Security::find($this->trade_data_buy->SecurityID)->Description,
            'quantity'    => $this->trade_data_buy->Quantity,
            'buy_price'   => number_format($this->trade_data_buy->Price, 2),
            'sell_price'  => number_format($this->trade_data_sell->Price, 2),
        ];
    }
}
