<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Profile extends Model
{

    use LogsActivity;
    protected $guarded              = ['id'];
    protected static $logAttributes = ['dob', 'firstname', 'gender', 'lastname', 'address', 'phone'];

    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Profile Update";
    }

    public function user()
    {
        return $this->belongsTo('TradefiUBA\User');
    }

    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function bank_detail()
    {
        return $this->hasOne('TradefiUBA\BankDetail');
    }

    public function gls()
    {
        return $this->hasMany('TradefiUBA\GL', 'CustomerID');
    }

    public function tickets()
    {
        return $this->hasMany('TradefiUBA\Ticket');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }
}
