<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class FX extends Model
{
    protected $guarded = ['id'];
    protected $table   = 'fx';

}
