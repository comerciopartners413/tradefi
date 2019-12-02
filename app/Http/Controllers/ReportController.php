<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\TradeData;
use TradefiUBA\Config;

class ReportController extends Controller
{
    public function index()
    {
        $user_id   = auth()->id();
        $gl_id     = auth()->user()->gls->where('AccountTypeID', 1)->first()->GLRef;
        $cash_flow = TradeData::where('InputterID', $user_id)->get();

        $cash_flow_chart_data = collect(\DB::select("
                EXEC procCashFlow $gl_id
            "));
        $months  = $cash_flow_chart_data->pluck('Months')->toJson();
        $inflow  = $cash_flow_chart_data->pluck('Inflow')->toJson();
        $outflow = $cash_flow_chart_data->pluck('OutFlow')->toJson();

        // Profit or Loss Reports
        $tradedate        = Config::first()->TradeDate;
        $trading_pl_bonds = collect(\DB::select("EXEC procBondsPL '$tradedate', $user_id"));
        // dd($trading_pl_bonds);
        $trading_pl_tbills = collect(\DB::select("EXEC procTBillsPL '$tradedate', $user_id"));

        $net_account_value     = collect(\DB::select("EXEC procBondsPL '$tradedate', $user_id"))->sum('MarketValue') + collect(\DB::select("EXEC procTBillsPL '$tradedate', $user_id"))->sum('MarketValue');
        $total_unrealized_gain = collect(\DB::select("EXEC procBondsPL '$tradedate', $user_id"))->sum('CapitalGainLoss') + collect(\DB::select("EXEC procTBillsPL '$tradedate', $user_id"))->sum('CapitalGainLoss');

        return view('reports.index', compact('cash_flow', 'months', 'inflow', 'outflow', 'trading_pl_bonds', 'trading_pl_tbills', 'net_account_value', 'total_unrealized_gain'));
    }

}
