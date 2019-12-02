<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $guarded = ['id'];

    public function ticket()
    {
        return $this->hasOne('TradefiUBA\Ticket');
    }
}
