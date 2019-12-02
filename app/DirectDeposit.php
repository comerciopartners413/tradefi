<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class DirectDeposit extends Model
{
    protected $guarded = ['id'];
    public $table      = 'direct_deposits';

    public function user()
    {
        return $this->hasOne('TradefiUBA\User', 'id', 'CustomerID');
    }

}
