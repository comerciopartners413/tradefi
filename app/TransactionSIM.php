<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class TransactionSIM extends Model
{
    protected $table   = 'tblTransactionSIM';
    protected $guarded = ['TransactionRef'];
    // protected $table   = 'tblTransaction';
    public $timestamps = false;
}
