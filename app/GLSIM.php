<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class GLSIM extends Model
{
    protected $table      = 'tblGL';
    protected $guarded    = ['GLRef'];
    protected $primaryKey = 'GLRef';
    protected $connection = 'simulation_db';
    // public $timestamps    = false;
    const CREATED_AT = 'InputDatetime';
    const UPDATED_AT = 'ModifiedDatetime';

    public function profile()
    {
        return $this->belongsTo('TradefiUBA\Profile', 'CustomerID', 'user_id');
    }

}
