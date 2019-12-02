<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $guarded    = ['CountryRef'];
    protected $primaryKey = 'CountryRef';
    protected $table      = 'tblCountry';
    const CREATED_AT      = 'InputDatetime';
    const UPDATED_AT      = 'ModifiedDatetime';

}
