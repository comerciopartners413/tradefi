<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankDetailsPending extends Model
{
    use SoftDeletes;

    protected $table   = 'bank_details_pending';
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    public $dates      = ['deleted_at'];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

}
