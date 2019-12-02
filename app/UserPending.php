<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPending extends Model
{
    use SoftDeletes;

    protected $table   = 'users_pending';
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    public $dates      = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
