<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $guarded    = ['GenderRef'];
    protected $primaryKey = 'GenderRef';
    public $table         = 'tblGender';

    const CREATED_AT = 'InputDatetime';
    const UPDATED_AT = 'ModifiedDatetime';
}
