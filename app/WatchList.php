<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class WatchList extends Model
{
    protected $table      = 'tblWatchList';
    protected $guarded    = ['WatchListRef'];
    protected $primaryKey = 'WatchListRef';
    // public $timestamps    = false;
    const CREATED_AT = 'InputDatetime';
    const UPDATED_AT = 'ModifiedDatetime';

}
