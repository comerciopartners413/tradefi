<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class TransferType extends Model
{
    protected $guarded    = ['TransferTypeRef'];
    protected $primaryKey = 'TransferTypeRef';
    public $table         = 'tblTransferType';
}
