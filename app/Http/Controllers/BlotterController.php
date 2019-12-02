<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Config;
use Illuminate\Http\Request;
use TradefiUBA\TradeData;

class BlotterController extends Controller
{
    public function index()
    {
        $user         = auth()->user()->id;
        $today        = \DB::table('tblConfig')->first()->TradeDate;
        $user_blotter = TradeData::where('InputterID', $user)->where('TradeDate', $today)->get();
        // dd($user_blotter);
        return view('blotter.index_', compact('user_blotter'));
    }

    public function store(Request $request)
    {
        $today = Config::first()->TradeDate;
        $user  = auth()->user()->id;
        if ($request->fromDate != '') {
            $from = $request->fromDate;
        } else {
            $from = $today;
        }

        if ($request->toDate != '') {
            $to = $request->toDate;
        } else {
            $to = $today;
        }
        $user_blotter = TradeData::where('InputterID', $user)->whereBetween('TradeDate', ["$from", "$to"])->get();
        return view('blotter.index_', compact('user_blotter', 'from', 'to'));
    }

}
