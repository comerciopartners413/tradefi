<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class TransactionEntrySIM extends Model
{
    protected $guarded = ['TransactionEntryRef'];
    protected $table   = 'tblTransactionEntrySIM';
    public $timestamps = false;
}
