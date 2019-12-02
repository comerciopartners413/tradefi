<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class TradeDataSIM extends Model
{
    protected $table      = 'tblTradeDataSIM';
    protected $guarded    = ['TradeDataRef'];
    protected $primaryKey = 'TradeDataRef';
    // public $timestamps    = false;
    const CREATED_AT = 'InputDatetime';
    const UPDATED_AT = 'ModifiedDatetime';

    public function transaction_type()
    {
        return $this->belongsTo('TradefiUBA\TransactionType', 'TransactionTypeID');
    }
}
