<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo('TradefiUBA\TicketCategory', 'ticket_category_id');
    }
    public function profile()
    {
        return $this->belongsTo('TradefiUBA\Profile');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }
}
