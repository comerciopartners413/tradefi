<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $guarded    = ['InventoryRef'];
    protected $primaryKey = 'InventoryRef';
    protected $table      = 'tblInventory';

    public function security()
    {
        return $this->belongsTo(Security::class, 'SecurityID');
    }

    public function transaction_type()
    {
        return $this->belongsTo(TransactionType::class, 'TransactionTypeID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'InputterID');
    }

    public function workflow()
    {
        return $this->belongsTo(Workflow::class, 'ModuleID');
    }

    public function buys_today()
    {
      // return static::where('SecurityID', $this->SecurityID)->where('TransactionTypeID', '1')->whereDate('created_at', date('Y-m-d'))->get()->sum('Quantity');
      return TradeData::where('SecurityID', $this->SecurityID)->where('TransactionTypeID', '1')->whereDate('TradeDate', date('Y-m-d'))->get()->sum('Quantity');
    }

    public function sells_today()
    {
      return static::where('SecurityID', $this->SecurityID)->where('TransactionTypeID', '2')->whereDate('created_at', date('Y-m-d'))->get()->sum('Quantity');
    }

}
