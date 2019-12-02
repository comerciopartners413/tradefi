<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class CouponPayment extends Model
{
    protected $table      = 'tblCouponPayment';
    protected $guarded    = ['CouponPaymentRef'];
    protected $primaryKey = 'CouponPaymentRef';
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
