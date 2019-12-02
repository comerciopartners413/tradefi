<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class Frequency extends Model
{
    protected $guarded    = ['FrequencyRef'];
    protected $primaryKey = 'FrequencyRef';
    protected $table      = 'tblFrequency';
    const CREATED_AT      = 'InputDatetime';
    const UPDATED_AT      = 'ModifiedDatetime';

}
