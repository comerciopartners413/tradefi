<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    protected $fillable = ['comment', 'user_id', 'ticket_id'];
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany('TradefiUBA\TicketComment', 'parent_id');
    }
}
