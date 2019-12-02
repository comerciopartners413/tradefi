<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $guarded    = ['WithdrawalRef'];
    protected $primaryKey = 'WithdrawalRef';
    public $table         = 'tblWithdrawal';

    const CREATED_AT = 'InputDatetime';
    const UPDATED_AT = 'ModifiedDatetime';
}
