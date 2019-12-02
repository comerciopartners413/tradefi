<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class ClosingPriceList extends Model
{
    protected $table      = 'tblClosingPriceList';
    protected $guarded    = ['ClosingPriceRef'];
    protected $primaryKey = 'ClosingPriceRef';
    // public $timestamps    = false;
    const CREATED_AT = 'InputDatetime';
    const UPDATED_AT = 'ModifiedDatetime';

}
