<?php

namespace TradefiUBA;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;
class Config extends Model
{
    protected $table = 'tblConfig';

    public static function next_trade_date()
    {

        return Carbon::parse(\DB::select("EXEC procNextTradeDate")[0]->NextTradeDate)->setTimeFromTimeString(env('TRADE_START_TIME'));
    }

    public static function start_trade_time()
    {
        $time = Carbon::now()->setTimeFromTimeString(env('TRADE_START_TIME'));
        if (Carbon::now()->isWeekend()) {
            $time = Carbon::parse(Config::first()->TradeDate)->setTimeFromTimeString(env('TRADE_START_TIME'));
            return $time;
        } elseif (Carbon::now() > Carbon::now()->setTimeFromTimeString(env('TRADE_END_TIME'))) {
            $time = Config::next_trade_date();
            return $time;
        } else {
            return $time;
        }
    }

    public static function is_weekend()
    {
        if (Carbon::now()->isWeekend()) {
            return true;
        } else {
            echo "'" . Carbon::now()->setTimeFromTimeString('10:00:00') . "'";
        }
    }

    public static function is_friday()
    {
        if (Carbon::now()->isFriday()) {
            return true;
        } else {
            return '0';
        }
    }
}
