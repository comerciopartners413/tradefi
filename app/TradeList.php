<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class TradeList extends Model
{
    protected $table      = 'tblTradeList';
    protected $guarded    = ['TradeListRef'];
    protected $primaryKey = 'TradeListRef';
    // public $timestamps    = false;
    const CREATED_AT = 'InputDatetime';
    const UPDATED_AT = 'ModifiedDatetime';

    public function security()
    {
        return $this->belongsTo('TradefiUBA\Security', 'SecurityID');
    }

    // public function tradelist()
    public function curent_price($security_id)
    {
        return $this->find($security_id);
    }
}
