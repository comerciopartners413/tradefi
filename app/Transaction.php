<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table   = 'tblTransaction';
    protected $guarded = ['TransactionRef'];
    // protected $table   = 'tblTransaction';
    public $timestamps = false;
}
