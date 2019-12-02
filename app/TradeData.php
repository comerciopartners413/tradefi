<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class TradeData extends Model
{
    protected $table      = 'tblTradeData';
    protected $guarded    = ['TradeDataRef'];
    protected $primaryKey = 'TradeDataRef';
    // public $timestamps    = false;
    const CREATED_AT = 'InputDatetime';
    const UPDATED_AT = 'ModifiedDatetime';

    public function transaction_type()
    {
        return $this->belongsTo('TradefiUBA\TransactionType', 'TransactionTypeID');
    }

    public function security()
    {
        return $this->belongsTo('TradefiUBA\Security', 'SecurityID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'InputterID');
    }

}
