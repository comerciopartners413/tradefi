<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $guarded    = ['TransactionTypeRef'];
    protected $primaryKey = 'TransactionTypeRef';
    public $table         = 'tblTransactionType';
}
