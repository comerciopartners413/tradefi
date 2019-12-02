<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    protected $guarded = ['id'];

    public function profile()
    {
        return $this->belongsTo('TradefiUBA\Profile');
    }

    public function bank()
    {
        return $this->belongsTo('TradefiUBA\Bank');
    }
}
