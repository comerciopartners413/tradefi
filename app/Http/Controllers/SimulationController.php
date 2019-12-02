<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Events\DealExecuted;
use TradefiUBA\Events\TradeCreated;
use TradefiUBA\GLSIM;
use TradefiUBA\Notifications\TradeNotification;
use TradefiUBA\Security;
use TradefiUBA\TradeFIDataSIM;
use TradefiUBA\TradeList;
use TradefiUBA\TransactionType;
use TradefiUBA\User;
use DB;
use Event;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    public function index()
    {
        $securities = Security::all();
        $tradelist  = DB::select("
                    EXEC procTradeList
            ");

        // if ($request->has('From') and $request->has('To')) {

        return view('simulation.index', compact('securities', 'tradelist'));
    }

    public function index2(Request $request)
    {
        // if ($request->has('From') and $request->has('To')) {
        $tradelist = DB::select("
                    EXEC procTradeList
            ");
        if ($request->SecurityType == 3 && $request->From == '' && $request->To == '') {
            $tradelist = DB::select("
                    EXEC procTradeList
            ");
            return view('trade_room.index', compact('securities', 'tradelist'));
        }
        if ($request->has('From') and $request->has('To')) {
            $ProductID = $request->SecurityType;
            $From      = $request->From;
            $To        = $request->To;
            $tradelist = DB::select("
                    EXEC procTradeListFiltered $ProductID, '$From', '$To'
            ");
            return view('trade_room.index', compact('securities', 'tradelist'));
        }

    }

    public function search(Request $request)
    {
        // dd($request->SecurityType);
        $filter = $request->SecurityType;
        $from   = $request->From;
        $to     = $request->To;
        if ($request->SecurityType == 1) {
            $securities = Security::where('ProductID', 2)
                ->whereBetween('MaturityDate', ["$from", "$to"])
                ->get();
            // dd($securities);
            return view('trade_room.index', compact('securities'));
        } elseif ($request->SecurityType == 2) {
            $securities = Security::where('ProductID', 2)
                ->whereBetween('MaturityDate', ["$from", "$to"])
                ->get();
            return view('trade_room.index', compact('securities'));
        } else {
            $securities = Security::all()
                ->sortBy('ProductID');
        }

        return view('trade_room.index', compact('securities'));
    }

    public function create()
    {
        $securities_bonds = Security::where('BenchmarkFlag', 1)
            ->where('ProductID', 1)
            ->where('MaturityDate', '>', \Carbon\Carbon::now())
            ->get();

        $securities_tbills = Security::where('BenchmarkFlag', 1)
            ->where('ProductID', 2)
            ->where('MaturityDate', '>', \Carbon\Carbon::now())
            ->get();
        // dd($securities_bonds);
        $transaction_types = TransactionType::all();
        return view('trade_room.create', compact('securities_bonds', 'securities_tbills', 'transaction_types'));
    }

    public function store(Request $request)
    {

    }

    public function easymode()
    {
        $securities = Security::all();
        $tradelist  = DB::select("
                    EXEC procTradeList
            ");
        $not_activated = User::where('admin', 0)
            ->where('ActivatedFlag', 0)
            ->where('id', auth()->user()->id)
            ->get();

        if (count($not_activated) > 0) {
            return view('trade_room.not_activated');
        }
        return view('trade_room.easymode', compact('securities', 'tradelist', 'not_activated'));
    }

    public function fetchEasyModeTradeList(Request $request)
    {
        $amount     = $request->Amount;
        $length     = $request->LengthOfInvestment;
        $product_id = $request->ProductID;
        $tradelist  = DB::select("
                    EXEC procTradeListEasy $amount, $product_id, $length
            ");
        return response()->json($tradelist);
    }

    public function postTrade(Request $request)
    {

        // $security
        $security_existed = TradeList::where('SecurityID', $request->SecurityRef)->get();
        if ($security_existed->count() > 0) {
            // dd($security_existed->TradeListRef);
            // dd($ref);
            if ($request->has('BuyPrice') && $request->BuyPrice > 0 && $request->has('SellPrice') && $request->SellPrice > 0) {
                $trade_data_buy = [
                    'SecurityID'        => $request->SecurityRef,
                    'Price'             => $request->BuyPrice,
                    'TransactionTypeID' => 1,
                    'Quantity'          => 1000000000,
                    'PriceMakerID'      => 1,
                    'InputterID'        => auth()->user()->id,
                ];
                TradeList::where('SecurityID', $request->SecurityRef)
                    ->where('TransactionTypeID', 1)
                    ->update($trade_data_buy);
                $trade_data = TradeList::where('SecurityID', $request->SecurityRef)
                    ->where('TransactionTypeID', 1)->first();
                $trade_data_sell = [
                    'SecurityID'        => $request->SecurityRef,
                    'Price'             => $request->SellPrice,
                    'TransactionTypeID' => 2,
                    'Quantity'          => 1000000000,
                    'PriceMakerID'      => 1,
                    'InputterID'        => auth()->user()->id,
                ];
                TradeList::where('SecurityID', $request->SecurityRef)
                    ->where('TransactionTypeID', 2)
                    ->update($trade_data_sell);
                $b = TradeList::where('SecurityID', $trade_data_buy['SecurityID'])->where('TransactionTypeID', 1)->first();
                $s = TradeList::where('SecurityID', $trade_data_sell['SecurityID'])->where('TransactionTypeID', 2)->first();
                // $s = new TradeList($trade_data_sell);
                Event::fire(new TradeCreated($b, $s));
                return response()->json("Trade posted successfully");
            }
        } else {

            if ($request->has('BuyPrice') && $request->BuyPrice > 0 && $request->has('SellPrice') && $request->SellPrice > 0) {
                $trade_data_buy = new TradeList([
                    'SecurityID'        => $request->SecurityRef,
                    'Price'             => $request->BuyPrice,
                    'TransactionTypeID' => 1,
                    'Quantity'          => 1000000000,
                    'PriceMakerID'      => 1,
                    'InputterID'        => auth()->user()->id,
                ]);
                $trade_data_buy->save();
                // Event::fire(new TradeCreated($trade_data));
                $trade_data_sell = new TradeList([
                    'SecurityID'        => $request->SecurityRef,
                    'Price'             => $request->SellPrice,
                    'TransactionTypeID' => 2,
                    'Quantity'          => 1000000000,
                    'PriceMakerID'      => 1,
                    'InputterID'        => auth()->user()->id,
                ]);
                $trade_data_sell->save();
                // Event::fire(new TradeCreated($trade_data));
                Event::fire(new TradeCreated($trade_data_buy, $trade_data_sell));
                return response()->json("Trade posted successfully")->setStatusCode(200);

            }

        }
    }

    public function fetchTradeListForSecurity(Request $request)
    {
        $SecurityID        = $request->SecurityID;
        $TransactionTypeID = $request->TransactionTypeID;

        $security_tradelist = DB::connection('simulation_db')->select("
                    EXEC procTradeListForSecurity $SecurityID, $TransactionTypeID
            ");
        return response()->json($security_tradelist)->setStatusCode(200, 'OK');
    }

    public function postDeal(Request $request)
    {
        $SecurityID        = $request->SecurityID;
        $TradeListRef      = $request->TradeListRef;
        $TransactionTypeID = $request->TransactionTypeID;
        $Quantity          = $request->Quantity;
        $Price             = $request->Price;
        $CustomerID        = $request->CustomerID;
        $PriceMakerID      = $request->PriceMakerID;

        if ($request->Pin == auth()->user()->trading_pin) {
            $post_deal = DB::connection('simulation_db')->select("
                     EXEC procInsertTradeFIData $TradeListRef, $TransactionTypeID, $Quantity, $Price, $CustomerID, $PriceMakerID
            ");

            // dd($post_deal->Status);
            if ($post_deal[0]->Status == "200") {
                $customer_gl = auth()->user()->profile->gls->where('AccountTypeID', 1)->first();
                // return response()->json($post_deal);
                $trade = TradeFIDataSIM::find($post_deal[0]->TradeDataRef);
                $user  = auth()->user();
                Event::fire(new DealExecuted($customer_gl, $user));
                auth()->user()->notify(new TradeNotification($trade));
                return response()->json($post_deal)->setStatusCode(200, 'OK');
            } elseif ($post_deal[0]->Status == "500") {
                return response()->json($post_deal)->setStatusCode(500, 'Insufficient Balance.');
            }

        } else {
            return response()->json(['message' => 'Wrong Trading Pin'])->setStatusCode(500, 'Wrong Pin');
        }

    }

    public function getBalanceForSecurity($id)
    {
        $user          = auth()->user()->id;
        $balance_count = GLSIM::where('SecurityID', $id)
            ->where('CustomerID', $user)->get();
        if (count($balance_count) > 0) {
            $balance = GLSIM::where('SecurityID', $id)
                ->where('CustomerID', $user)->first()->ClearedBalance;
            return response()->json($balance)->setStatusCode(200);

        } else {
            return response()->json(count($balance_count))->setStatusCode(200);
        }

    }

    public function fetchLatestTrade()
    {
        $tradedata = \DB::select('
                EXEC procFetchLatestTrades
            ');
        return response()->json($tradedata);
    }

    public function fetchChartData(Request $request)
    {
        $security_id = $request->SecurityID;
        $product     = Security::find($security_id)->ProductID;
        $chart_data  = \DB::select("
                EXEC procPriceChangeForLast30 $security_id
            ");
        return response()->json(['chart_data' => $chart_data, 'product' => $product]);
    }

}
