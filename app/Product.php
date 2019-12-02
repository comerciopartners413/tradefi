<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table      = 'tblProduct';
    protected $guarded    = ['ProductRef'];
    protected $primaryKey = 'ProductRef';
    // public $timestamps    = false;
    const CREATED_AT = 'InputDatetime';
    const UPDATED_AT = 'ModifiedDatetime';

    public function security()
    {
        return $this->hasMany('TradefiUBA\Security', 'ProductID');
    }
}
