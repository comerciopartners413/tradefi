<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $fillable = ['name', 'display_name', 'description'];

    public function company()
    {
      $this->belongsTo(Company::class);
    }
}
