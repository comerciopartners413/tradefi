<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfilePending extends Model
{
    use SoftDeletes;

    protected $table   = 'profiles_pending';
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    public $dates      = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
