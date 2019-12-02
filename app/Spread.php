<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class Spread extends Model
{
    protected $guarded    = ['SpreadRef'];
    protected $primaryKey = 'SpreadRef';
    protected $table      = 'tblSpread';
    public $timestamps    = false;
}
