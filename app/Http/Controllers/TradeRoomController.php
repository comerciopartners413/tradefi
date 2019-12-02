<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Events\DealExecuted;
use TradefiUBA\Events\GeneralExecutedDeal;
use TradefiUBA\Events\TradeCreated;
use TradefiUBA\GL;
use Notification;
use TradefiUBA\News;
use TradefiUBA\Notifications\TradeNotification;
use TradefiUBA\Mail\MarketVolume;
use TradefiUBA\Security;
use TradefiUBA\TradeData;
use TradefiUBA\TradeFIData;
use TradefiUBA\TradeList;
use TradefiUBA\TransactionType;
use TradefiUBA\PriceUpload;
use TradefiUBA\Rules\TraderoomModulo;
use TradefiUBA\User;
use DB, Carbon\Carbon;
use Event;
use Mail;
use Illuminate\Http\Request;
use Pusher\PushNotifications\PushNotifications as PN;

class TradeRoomController extends Controller
{
    public function index()
    {
        $securities = Security::take('MaturityDate', 'Security', 'Description', 'ProductID');
        $tradelist  = collect(DB::select("EXEC procTradeList"))->transform(function ($item, $key) {
            $item->buy_quantity  = Security::find($item->SecurityID)->buy_quantity();
            $item->sell_quantity = Security::find($item->SecurityID)->sell_quantity();

            return $item;
        });
        // dd($tradelist);
        $not_activated = User::where('admin', 0)
            ->where('ActivatedFlag', 0)
            ->where('id', auth()->user()->id)
            ->get();
        $news = News::latest()->take(3)->get();
        // dd($news);

        if (count($not_activated) > 0) {
            return view('trade_room.not_activated');
        }
        // if ($request->has('From') and $request->has('To')) {

        return view('trade_room.index', compact('securities', 'tradelist', 'not_activated', 'news'));
    }

    public function index2(Request $request)
    {
        // if ($request->has('From') and $request->has('To')) {
        $tradelist = collect(DB::select("
                    EXEC procTradeList
            "));
        $news = News::latest()->take(3)->get();
        if ($request->SecurityType == 3 && $request->From == '' && $request->To == '') {
            $tradelist = DB::select("
                    EXEC procTradeList
            ");
            return view('trade_room.index', compact('securities', 'tradelist', 'news'));
        }
        if ($request->has('From') and $request->has('To')) {
            $ProductID = $request->SecurityType;
            $From      = $request->From;
            $To        = $request->To;
            $tradelist = DB::select("
                    EXEC procTradeListFiltered $ProductID, '$From', '$To'
            ");
            return view('trade_room.index', compact('securities', 'tradelist', 'news', 'ProductID', 'From', 'To'));
        }

    }

    public function fetch_tradelist(Request $request)
    {
        $tradelist = DB::select("
                    EXEC procTradeList
            ");
        return response()->json($tradelist)->setStatusCode(200);
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

    public function get_ticket_details(Request $request)
    {
        $trade = TradeData::find($request->TradeDataRef);
        return response()->json(['trade' => $trade, 'maturity' => $trade->security->Description]);
    }

    public function create()
    {
        $securities_bonds = Security::where('ProductID', 1)
            ->join('tblInventory', 'tblSecurity.SecurityRef', '=', 'tblInventory.SecurityID')
            ->where('MaturityDate', '>', \Carbon\Carbon::now())
            ->where('tblInventory.ApproverID', 0)
            ->where('tblInventory.ModuleID', '<>', null)

            ->select('SecurityRef', 'Security', 'Description', 'MaturityDate')
            ->groupBy(['SecurityRef', 'Security', 'Description', 'MaturityDate'])
            ->orderByRaw('sum(tblInventory.Quantity) DESC')
            ->get();
        // dd($securities_bonds);

        $securities_tbills = Security::where('ProductID', 2)
            ->join('tblInventory', 'tblSecurity.SecurityRef', '=', 'tblInventory.SecurityID')
            ->where('MaturityDate', '>', \Carbon\Carbon::now())
            ->where('tblInventory.ApproverID', 0)
            ->where('tblInventory.ModuleID', '<>', null)

            ->select('SecurityRef', 'Security', 'Description', 'MaturityDate')
            ->groupBy(['SecurityRef', 'Security', 'Description', 'MaturityDate'])
            ->orderByRaw('sum(tblInventory.Quantity) DESC')
            ->get();
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
        // return 'aye';
        // $pushNotifications = new PN([
        //     'instanceId' => env('PUSHER_PN_INSTANCE_ID'),
        //     'secretKey'  => env('PUSHER_PN_SECRET_KEY'),
        // ]);
        if ($security_existed->count() > 0) {
            // dd($security_existed->TradeListRef);
            // dd($ref);
            if ($request->has('BuyPrice') && $request->BuyPrice > 0 && $request->has('SellPrice') && $request->SellPrice > 0) {
                $trade_data_buy = [
                    'SecurityID'        => $request->SecurityRef,
                    'Price'             => $request->BuyPrice,
                    'TransactionTypeID' => 1,
                    // 'Quantity'          => $request->BuyQuantity,
                    'PriceMakerID'      => 1,
                    'ModifierID'        => auth()->user()->id,
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
                    // 'Quantity'          => $request->SellQuantity,
                    'PriceMakerID'      => 1,
                    'ModifierID'        => auth()->user()->id,
                ];
                TradeList::where('SecurityID', $request->SecurityRef)
                    ->where('TransactionTypeID', 2)
                    ->update($trade_data_sell);
                $b = TradeList::where('SecurityID', $trade_data_buy['SecurityID'])->where('TransactionTypeID', 1)->first();
                $s = TradeList::where('SecurityID', $trade_data_sell['SecurityID'])->where('TransactionTypeID', 2)->first();
                // $s = new TradeList($trade_data_sell);
                Event::fire(new TradeCreated($b, $s));

                $securities = Security::take('MaturityDate', 'Security', 'Description', 'ProductID');
                $tradelist  = collect(DB::select("EXEC procTradeList"));

                $tradelist = $tradelist->transform(function ($item, $key) {
                    $item->SecurityID   = (int) $item->SecurityID;
                    $item->BuyQuantity  = (int) $item->BuyQuantity;
                    $item->SellQuantity = (int) $item->SellQuantity;
                    $item->buy_price    = (float) $item->SellPrice;
                    $item->sell_price   = (float) $item->BuyPrice;
                    $item->buy_yield    = (float) $item->SellYield;
                    $item->sell_yield   = (float) $item->BuyYield;
                    $item->Min          = (float) $item->Min;
                    $item->Max          = (float) $item->Max;
                    $item->product_type = $item->ProductID == '1' ? 'bonds' : 'tbills';
                    $user               = auth()->user()->id;

                    $balance_count = GL::where('SecurityID', $item->SecurityID)
                        ->where('CustomerID', $user)->get();

                    $item->security_balance = count($balance_count) > 0 ? GL::where('SecurityID', $item->SecurityID)
                        ->where('CustomerID', $user)->first()->ClearedBalance : 0;

                    $buy_tradelist_for_security  = collect(DB::select("EXEC procTradeListForSecurity $item->SecurityID, 2"))->first();
                    $sell_tradelist_for_security = collect(DB::select("EXEC procTradeListForSecurity $item->SecurityID, 1"))->first();

                    $client                = new \GuzzleHttp\Client();
                    $security_id           = (int) $item->SecurityID;
                    $item->dirtyprice_buy  = (float) ($buy_tradelist_for_security->DirtyPrice);
                    $item->dirtyprice_sell = (float) ($sell_tradelist_for_security->DirtyPrice);
                    $maturity_date         = Security::find($security_id)->MaturityDate;
                    $res                   = $client->request('GET', 'https://comercio.timsmate.com/api/price-movement/' . $maturity_date);

                    $pricelist_raw    = json_decode($res->getBody());
                    $item->chart_data = collect($pricelist_raw)->sortBy('Date')->values()->all();

                    return $item;
                });

                // $publishResponse = $pushNotifications->publish(['public'],
                //     array("fcm" => array("notification" => array(
                //         "title" => "Price Change",
                //         "body"  => 'Price has changed',
                //     ),
                //         "data"                              => [
                //             'type' => 'tradelist',
                //         ]),
                //     ));

                return response()->json("Trade posted successfully");
            }
        } else {

            if ($request->has('BuyPrice') && $request->BuyPrice > 0 && $request->has('SellPrice') && $request->SellPrice > 0) {
                $trade_data_buy = new TradeList([
                    'SecurityID'        => $request->SecurityRef,
                    'Price'             => $request->BuyPrice,
                    'TransactionTypeID' => 1,
                    // 'Quantity'          => $request->BuyQuantity,
                    'PriceMakerID'      => 1,
                    'ModifierID'        => auth()->user()->id,
                ]);
                $trade_data_buy->save();
                // Event::fire(new TradeCreated($trade_data));
                $trade_data_sell = new TradeList([
                    'SecurityID'        => $request->SecurityRef,
                    'Price'             => $request->SellPrice,
                    'TransactionTypeID' => 2,
                    // 'Quantity'          => $request->SellQuantity,
                    'PriceMakerID'      => 1,
                    'ModifierID'        => auth()->user()->id,
                ]);
                $trade_data_sell->save();
                // Event::fire(new TradeCreated($trade_data));
                Event::fire(new TradeCreated($trade_data_buy, $trade_data_sell));

                $securities = Security::take('MaturityDate', 'Security', 'Description', 'ProductID');
                $tradelist  = collect(DB::select("EXEC procTradeList"));

                $tradelist = $tradelist->transform(function ($item, $key) {
                    $item->SecurityID   = (int) $item->SecurityID;
                    $item->BuyQuantity  = (int) $item->BuyQuantity;
                    $item->SellQuantity = (int) $item->SellQuantity;
                    $item->buy_price    = (float) $item->SellPrice;
                    $item->sell_price   = (float) $item->BuyPrice;
                    $item->buy_yield    = (float) $item->SellYield;
                    $item->sell_yield   = (float) $item->BuyYield;
                    $item->Min          = (float) $item->Min;
                    $item->Max          = (float) $item->Max;
                    $item->product_type = $item->ProductID == '1' ? 'bonds' : 'tbills';
                    $user               = auth()->user()->id;

                    $balance_count = GL::where('SecurityID', $item->SecurityID)
                        ->where('CustomerID', $user)->get();

                    $item->security_balance = count($balance_count) > 0 ? GL::where('SecurityID', $item->SecurityID)
                        ->where('CustomerID', $user)->first()->ClearedBalance : 0;

                    $buy_tradelist_for_security  = collect(DB::select("EXEC procTradeListForSecurity $item->SecurityID, 2"))->first();
                    $sell_tradelist_for_security = collect(DB::select("EXEC procTradeListForSecurity $item->SecurityID, 1"))->first();

                    $client                = new \GuzzleHttp\Client();
                    $security_id           = (int) $item->SecurityID;
                    $item->dirtyprice_buy  = (float) ($buy_tradelist_for_security->DirtyPrice);
                    $item->dirtyprice_sell = (float) ($sell_tradelist_for_security->DirtyPrice);
                    $maturity_date         = Security::find($security_id)->MaturityDate;
                    $res                   = $client->request('GET', 'https://comercio.timsmate.com/api/price-movement/' . $maturity_date);

                    $pricelist_raw    = json_decode($res->getBody());
                    $item->chart_data = collect($pricelist_raw)->sortBy('Date')->values()->all();

                    return $item;
                });

                $publishResponse = $pushNotifications->publish(['public'],
                    array("fcm" => array(
                        "data" => [
                            'type' => 'tradelist',

                        ]),
                    ));

                return response()->json("Trade posted successfully")->setStatusCode(200);

            }

        }
    }

    public function fetchTradeListForSecurity(Request $request)
    {
        $SecurityID        = $request->SecurityID;
        $TransactionTypeID = $request->TransactionTypeID;

        $security_tradelist = collect(DB::select("
                    EXEC procTradeListForSecurity $SecurityID, $TransactionTypeID
            "))->transform(function ($item, $key) use ($SecurityID) {
            $item->buy_quantity = Security::find($SecurityID)->buy_quantity();
            return $item;
        });
        return response()->json($security_tradelist)->setStatusCode(200, 'OK');
    }

    public function postDeal(Request $request)
    {

        $carbonated       = \Carbon\Carbon::now();
        $current_time     = (int) ($carbonated->toTimeString());
        $trade_start_time = Carbon::parse(env('TRADE_START_TIME'))->toDateTimeString();

        // Carbon::now()->setTimeFromTimeString("08:00:00");
        $trade_end_time = Carbon::parse(env('TRADE_END_TIME'))->toDateTimeString();

        if ((Carbon::now() < $trade_start_time) || (Carbon::now() > $trade_end_time) || (Carbon::now()->isWeekend())) {
            $post_deal = [];
            return response()->json($post_deal)->setStatusCode(500, 'Deal Was Unsuccesful. Market is Closed');
        }

        // return response()->json($post_deal)->setStatusCode(500, 'Deal Was Unsuccesful. Market is Closed');

        $validator = \Validator::make($request->all(), [
            'Quantity' => ['required', 'numeric', 'min:100000', 'max:99000000'],
        ],
            [
                'Quantity.max' => 'Volume may not be greater than <b>' . number_format(99000000) . '</b>',
                'Quantity.min' => 'Volume may not be lower than <b>' . number_format(100000) . '</b>',
            ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 502);
            //  used 502 to catch quantity errors on the front end
        }

        if ($request->TransactionTypeID == 1) {
            $transaction_type = 2;
        } elseif ($request->TransactionTypeID == 2) {
            $transaction_type = 1;
        }
        $security_id        = $request->SecurityID;
        $security_tradelist = collect(DB::select("
                    EXEC procTradeListForSecurity $security_id, $transaction_type
            "))->first();

        $SecurityID        = $security_id;
        $TradeListRef      = $request->TradeListRef;
        $TransactionTypeID = $request->TransactionTypeID;
        $Quantity          = $request->Quantity;
        $Price             = $security_tradelist->Price;
        $CustomerID        = auth()->user()->id;
        $PriceMakerID      = $security_tradelist->PriceMakerID;

        if ($request->Pin == decrypt(auth()->user()->trading_pin)) {
            $post_deal = DB::select("
                EXEC procInsertTradeFIData $TradeListRef, $TransactionTypeID, $Quantity, $Price, $CustomerID, $PriceMakerID
            ");

            // dd($post_deal->Status);
            if ($post_deal[0]->Status === "300") {
                $security = Security::find($SecurityID);
                $admins   = User::where('admin', 1)->get();
                $user     = User::find(auth()->user()->id);
                // Notification::send($admins, new MarketVolume($user, $security));
                if (\App::Environment('local')) {
                    Mail::to(['riliwan.rabo@gmail.com'])
                        ->queue(new MarketVolume($user, $security, $Quantity));
                } else {
                    Mail::to('settlement@tradefi.ng')

                        ->queue(new MarketVolume($user, $security, $Quantity));
                }
                return response()->json($post_deal)->setStatusCode(500, 'Insufficient Market Volume');
            }

            if ($post_deal[0]->Status == "200") {

                // return response()->json($post_deal);
                $trade       = TradeData::find($post_deal[0]->TradeDataRef);
                $user        = auth()->user();

                // Start: Update With Bank Rates
                $price = PriceUploadHistory::where('SecurityID', $trade->SecurityID)->orderBy('PriceUploadRef', 'desc')->first();
                $trade->BankYield = ($trade->TransactionTypeID == '1')? $price->BuyRate : $price->SellRate;
                $trade->update();
                // End: Update with Bank Rates

                $customer_gl = GL::where('AccountTypeID', 1)->where('CustomerID', $user->id)->first();
                Event::fire(new GeneralExecutedDeal($trade));
                Event::fire(new DealExecuted($customer_gl, $user, $trade));
                // dd($trade->security->Security);

                auth()->user()->notify(new TradeNotification($trade));

                return response()->json($post_deal)->setStatusCode(200, 'OK');
            } elseif ($post_deal[0]->Status == "500") {
                return response()->json($post_deal)->setStatusCode(500, 'Insufficient Balance.');
            }

        } else {
            return response()->json(['message' => 'Wrong Trading Pin'])->setStatusCode(500, 'Wrong Pin');
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
        $maturity_date = $request->MaturityDate;
        // $product       = Security::where('MaturityDate', $maturity_date)->first()->ProductID;

        $client = new \GuzzleHttp\Client();
        $res    = $client->request('GET', 'https://comercio.timsmate.com/api/price-movement/' . $maturity_date);

        $pricelist_raw = json_decode($res->getBody());
        $chart_data    = collect($pricelist_raw);
        // return $chart_data;
        return response()->json(['chart_data' => $chart_data]);
    }

    public function suspend(Request $request)
    {
        $proc = \DB::select("
                EXEC procZerorizePrices
            ");
        return response()->json('Trades were suspended', 200);
    }

}
