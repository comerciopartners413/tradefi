<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class PriceChange extends Model
{
    protected $table      = 'tblPriceChange';
    protected $guarded    = ['PriceChangeRef'];
    protected $primaryKey = 'PriceChangeRef';
    public $timestamps    = false;

    public function security()
    {
        return $this->belongsTo(Security::class, 'SecurityID');
    }
}
