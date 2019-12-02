<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class TradeFIData extends Model
{
    protected $table      = 'tblTradeFIData';
    protected $guarded    = ['TradeDataRef'];
    protected $primaryKey = 'TradeDataRef';
    // public $timestamps    = false;
    const CREATED_AT = 'InputDatetime';
    const UPDATED_AT = 'ModifiedDatetime';
    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

    public function fromDateTime($value)
    {
        return substr(parent::fromDateTime($value), 0, -3);
    }

    public function user()
    {
        return $this->belongsTo('TradefiUBA\User', 'CustomerID');
    }

    public function security()
    {
        return $this->belongsTo('TradefiUBA\Security', 'SecurityID');
    }
}
