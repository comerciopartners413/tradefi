<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class GL extends Model
{
    protected $table      = 'tblGL';
    protected $guarded    = ['GLRef'];
    protected $primaryKey = 'GLRef';
    // public $timestamps    = false;
    const CREATED_AT = 'InputDatetime';
    const UPDATED_AT = 'ModifiedDatetime';

    public function profile()
    {
        return $this->belongsTo('TradefiUBA\Profile');
    }

}
