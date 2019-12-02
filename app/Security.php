<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    protected $table      = 'tblSecurity';
    protected $guarded    = ['SecurityRef'];
    protected $primaryKey = 'SecurityRef';
    // public $timestamps    = false;
    const CREATED_AT = 'InputDatetime';
    const UPDATED_AT = 'ModifiedDatetime';

    public function product()
    {
        return $this->belongsTo('TradefiUBA\Product', 'ProductID');
    }

    public function buy_price()
    {
        $buy_price = \TradefiUBA\TradeList::where('SecurityID', $this->SecurityRef)
            ->where('TransactionTypeID', 1)
            ->first();
        if (is_null($buy_price)) {
            return 0;
        }
        return number_format($buy_price->Price, 2);
    }

    public function buy_quantity()
    {
        $buy_inventory = \DB::select(
            'EXEC procInventoryList 1'
        );

        if (is_null($buy_inventory)) {
            return 0;
        }
        return collect($buy_inventory)->where('SecurityID', $this->SecurityRef)->sum('Quantity');
    }

    public function sell_price()
    {
        $sell_price = \TradefiUBA\TradeList::where('SecurityID', $this->SecurityRef)
            ->where('TransactionTypeID', 2)
            ->first();
        if (is_null($sell_price)) {
            return 0;
        }
        return number_format($sell_price->Price, 2);
    }

    public function sell_quantity()
    {
        $sell_inventory = \DB::select(
            'EXEC procInventoryList 2'
        );

        if (is_null($sell_inventory)) {
            return 0;
        }
        return collect($sell_inventory)->where('SecurityID', $this->SecurityRef)->sum('Quantity');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'InputterID');
    }

    public function workflow()
    {
        return $this->belongsTo(Workflow::class, 'ModuleID');
    }

    public function days2mat()
    {
      $today = date_create(date('Y-m-d'));
      $maturity = date_create($this->MaturityDate);
      
      return date_diff($today, $maturity)->format("%R%a") + 0;
    }

}
