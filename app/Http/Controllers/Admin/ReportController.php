<?php

namespace TradefiUBA\Http\Controllers\Admin;

use TradefiUBA\TradeData;
use TradefiUBA\Config;
use TradefiUBA\Company;
use TradefiUBA\PriceChange;
use Illuminate\Http\Request;
use TradefiUBA\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function trades()
    {
        $tradedate  = Config::first()->TradeDate;
        $trade_data = TradeData::where('TradeDate', $tradedate)->get();
        $bonds      = TradeData::where('ProductID1', 1)->whereBetween('TradeDate', [$tradedate, $tradedate])->get();
        // dd($bonds);

        $tbills = TradeData::where('ProductID1', 2)->whereBetween('TradeDate', [$tradedate, $tradedate])->get();

        // dd($trade_data);
        return view('admin.trades.index', compact('trade_data', 'bonds', 'tbills'));
    }

    public function trades_uba(Request $request)
    {

      $tradedate = Config::first()->TradeDate;

      if ($request->fromDate != '') {
          $from = $request->fromDate;
      } else {
          $from = $tradedate;
      }

      if ($request->toDate != '') {
          $to = $request->toDate;
      } else {
          $to = $tradedate;
      }

      $uba = Company::where('name', 'uba')->first()->id;

      $trade_data = TradeData::whereBetween('TradeDate', ["$from", "$to"])->whereHas('user', function($q){
        $q->where('company_id', $uba);
      })->get();

      $bonds = TradeData::where('ProductID1', 1)->whereBetween('TradeDate', ["$from", "$to"])->whereHas('user', function($q){
        $q->where('company_id', $uba);
      })->get();

      $tbills = TradeData::where('ProductID1', 2)->whereBetween('TradeDate', ["$from", "$to"])->whereHas('user', function($q){
        $q->where('company_id', $uba);
      })->get();


        // $tradedate  = Config::first()->TradeDate;
        // $trade_data = TradeData::where('TradeDate', $tradedate)->get();
        // $bonds      = TradeData::where('ProductID1', 1)->whereBetween('TradeDate', [$tradedate, $tradedate])->get();
        // $tbills = TradeData::where('ProductID1', 2)->whereBetween('TradeDate', [$tradedate, $tradedate])->get();

        // dd($trade_data);
        return view('admin.trades.index_uba', compact('trade_data', 'bonds', 'tbills', 'from', 'to'));
    }

    public function trades_custody()
    {
        $trades = TradeData::all();
        return view('reports.custody', compact('trades'));
    }

    public function trades_post(Request $request)
    {
        $tradedate = Config::first()->TradeDate;

        if ($request->fromDate != '') {
            $from = $request->fromDate;
        } else {
            $from = $tradedate;
        }

        if ($request->toDate != '') {
            $to = $request->toDate;
        } else {
            $to = $tradedate;
        }

        $trade_data = TradeData::whereBetween('TradeDate', ["$from", "$to"])->get();

        $bonds = TradeData::where('ProductID1', 1)->whereBetween('TradeDate', ["$from", "$to"])->get();

        $tbills = TradeData::where('ProductID1', 2)->whereBetween('TradeDate', ["$from", "$to"])->get();
        return view('admin.trades.index', compact('trade_data', 'bonds', 'tbills', 'from', 'to'));
    }

    public function pricelog()
    {
        $pricelogs = collect(\DB::select("
            EXEC procStanbicPriceLog
            "));
        return view('admin.prices.log', compact('pricelogs'));
    }

    
    public function reports_settlement()
    {
        // $trades = TradeData::all();
        $trade_dates = TradeData::select('TradeDate')->groupBy('TradeDate')->get();
        return view('reports.settlement', compact('trades', 'trade_dates'));
    }
    
    public function reports_settlement_gis()
    {
        // $trades = TradeData::all();
        $trade_dates = TradeData::select('TradeDate')->groupBy('TradeDate')->get();
        $trade_dates->map(function($row){
          $formatted_date = date_format(date_create($row->TradeDate), 'Y-m-d');
          if(count(\DB::select("EXEC procUBATradeDownloaderGIS '$formatted_date' ")) > 0)
          return $row->active = true;
        });
        // dd($trade_dates->pluck('active'));
        // dd(\DB::select("EXEC procUBATradeDownloaderGIS '2018-05-31' "));
        return view('reports.settlement_gis', compact('trades', 'trade_dates'));
    }
}
