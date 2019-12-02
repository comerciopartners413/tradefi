<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class CashEntry extends Model
{
    protected $guarded    = ['CashEntryRef'];
    protected $primaryKey = 'CashEntryRef';
    public $table         = 'tblCashEntry';

    const CREATED_AT = 'InputDatetime';
    const UPDATED_AT = 'ModifiedDatetime';

    public function bank()
    {
        return $this->belongsTo('TradefiUBA\Bank', 'BankID');
    }

    public function user()
    {
        return $this->hasOne('TradefiUBA\User', 'id', 'CustomerID');
    }

    public function transfer_type()
    {
        return $this->belongsTo('TradefiUBA\TransferType', 'TransferTypeID');
    }

    public static function approved()
    {
        return CashEntry::where('ApprovedFlag', 1)
            ->where('PostingTypeID', 1)
            ->get();
    }

    public static function unapproved()
    {
        return CashEntry::where('ApprovedFlag', '<>', 1)
            ->where('PostingTypeID', '<>', 12)
            ->get();
    }

    public static function approved_withdrawals()
    {
        return CashEntry::where('BlockedFlag', 0)
            ->where('ApproverID', 0)
            ->where('ApprovedFlag', 1)
            ->where('ModuleID', 37)
            ->where('PostingTypeID', 12)
            ->get();
    }

    public static function unapproved_withdrawals()
    {
        return CashEntry::where('ApprovedFlag', '<>', 1)
            ->where('ApprovedFlag', 0)
            ->where('ModuleID', 37)
            ->where('BlockedFlag', 1)
            ->get();
    }
}
