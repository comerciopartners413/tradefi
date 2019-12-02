<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class DayBasis extends Model
{
    protected $guarded    = ['DayBasisRef'];
    protected $primaryKey = 'DayBasisRef';
    protected $table      = 'tblDayBasis';
    const CREATED_AT      = 'InputDatetime';
    const UPDATED_AT      = 'ModifiedDatetime';

}
