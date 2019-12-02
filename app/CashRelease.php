<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class CashRelease extends Model
{
    protected $table      = 'tblCashRelease';
    protected $guarded    = ['CashReleaseRef'];
    protected $primaryKey = 'CashReleaseRef';
    public $timestamps    = false;
    // const CREATED_AT = 'InputDatetime';
    // const UPDATED_AT = 'ModifiedDatetime';

    public function security()
    {
        return $this->belongsTo(Security::class, 'SecurityID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'InputterID');
    }
}
