<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $guarded = ['id'];

    public function company()
    {
      $this->belongsTo(Company::class);
    }

    
    public function menus()
    {
        return $this->belongsToMany('TradefiUBA\Menu');
    }

}
