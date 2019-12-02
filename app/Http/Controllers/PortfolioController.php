<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Security;
use TradefiUBA\Config;

class PortfolioController extends Controller
{
    public function index()
    {
        $user_id         = auth()->id();
        $gl              = auth()->user()->profile->gls->first();
        $securities      = Security::all();
        $user            = auth()->user()->id;
        $bonds_portfolio = \DB::select("
                EXEC procBondsPortfolio $user
            ");
        $tbills_portfolio = \DB::select("
                EXEC procTBillsPortfolio $user
            ");
        $general_portfolio = \DB::select("
                EXEC procPortfolioAll $user
            ");
        $user = auth()->user()->id;

        $trading_pl = \DB::select("
                EXEC procBondsPortfolioPlus $user
            ");
        $unrealized_gain = collect(\DB::select("
                EXEC TotalUnrealizedGain $user
            "));

        $tradedate         = Config::first()->TradeDate;
        $trading_pl_bonds  = collect(\DB::select("EXEC procBondsPL_Portfolio '$tradedate', $user_id, NULL, 'Summary'"));
        $trading_pl_tbills = collect(\DB::select("EXEC procTBillsPL_Portfolio '$tradedate', $user_id, NULL, 'Summary'"));

        $tradedate = Config::first()->TradeDate;

        $net_account_value     = collect(\DB::select("EXEC procBondsPL '$tradedate', $user_id"))->sum('MarketValue') + collect(\DB::select("EXEC procTBillsPL '$tradedate', $user_id"))->sum('MarketValue');
        $total_unrealized_gain = collect(\DB::select("EXEC procBondsPL '$tradedate', $user_id"))->sum('CapitalGainLoss') + collect(\DB::select("EXEC procTBillsPL '$tradedate', $user_id"))->sum('CapitalGainLoss');

        // dd($unrealized_gain->first()->Gain);
        return view('portfolios.index', compact('gl', 'securities', 'tradedate', 'bonds_portfolio', 'tbills_portfolio', 'general_portfolio', 'trading_pl', 'unrealized_gain', 'trading_pl_bonds', 'trading_pl_tbills', 'net_account_value', 'total_unrealized_gain'));
    }

    public function getBondsPortfolio()
    {
        $bonds_portfolio = collect(\DB::select("
                EXEC procBondsPortfolio
            "));
        return response()->json($bonds_portfolio);
    }
}
