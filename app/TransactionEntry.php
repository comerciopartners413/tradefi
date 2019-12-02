<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class TransactionEntry extends Model
{
    protected $guarded = ['TransactionEntryRef'];
    protected $table   = 'tblTransactionEntry';
    public $timestamps = false;
}
