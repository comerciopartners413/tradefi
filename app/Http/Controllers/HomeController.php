<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\FX;
use TradefiUBA\GL;
use TradefiUBA\Macro;
use TradefiUBA\News;
use TradefiUBA\Security;
use TradefiUBA\User;
use TradefiUBA\WatchList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use TradefiUBA\FootPrint;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ***========
        $footprint = (object) [
          'Title' => 'Dashboard',
          'Details' => 'Viewing dashboard'
        ];
        FootPrint::logTrail($footprint);
        // ***========

        // return Cash GLID
        // return dd(auth()->user()->profile->gls[0]->GLRef);
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

        //  get auth user

        $watchlist = \DB::select("
                EXEC procWatchList $user
            ");

        $securities = Cache::remember('home-securities', 22 * 60, function () {
            return Security::where('MaturityDate', '>', \Carbon\Carbon::now())
                ->where([
                    'ApproverID'   => 0,
                    'ApprovedFlag' => 1,
                ])
                ->get();
        });
        if ($securities == null) {
            $securities = Security::where('MaturityDate', '>', \Carbon\Carbon::now())
                ->get();
        }

        $news   = News::latest()->take(3)->get();
        if (env('APP_ENV') == 'local') {
          $pricelist = [];
        } else {
          $client = new \GuzzleHttp\Client();
          $res    = $client->request('GET', 'https://comercio.timsmate.com/api/market-prices');
  
          $pricelist_raw = json_decode($res->getBody());
          $pricelist     = collect($pricelist_raw);
        }

        // check if user has changed trading_pin
        $pin_has_changed = auth()->user()->changed_pin;
        $macros          = Macro::all();
        $fxs             = FX::all();

        // ==========
        // $bonds = TradeData::where()

        if ($pin_has_changed) {
            return view('home_', compact('bonds_portfolio', 'tbills_portfolio', 'general_portfolio', 'watchlist', 'securities', 'pricelist', 'news', 'equities', 'macros', 'fxs'));
        } else {
            return redirect('/change-pin')->with('info', 'Please Change Your Trading Pin to continue');
        }

    }

    public function watchSecurity(Request $request)
    {
        // check if that security is being watched already
        $watchlist = WatchList::where('SecurityID', $request->SecurityRef)->where('InputterID', auth()->user()->id)->get();
        // return response()->json(($watchlist));
        if (count($watchlist) > 0) {
            return response()->json("You are already watching this security")->setStatusCode(500);
        } else {
            $watchlist = new WatchList([
                'SecurityID' => $request->SecurityRef,
                'InputterID' => auth()->user()->id,
            ]);
            if ($watchlist->save()) {
                $user           = auth()->user()->id;
                $watchlist_data = collect(\DB::select("
                                EXEC procWatchList $user
                            "));
                $filtered = $watchlist_data->filter(function ($value, $key) use ($request) {
                    return $value->SecurityID == $request->SecurityRef;
                });
                if (count($filtered) <= 0) {
                    return response()->json("No deals made yet on this security but it will be watched for you", 500);
                }
                return response()->json([
                    'message'   => 'You have added ' . Security::find($watchlist->SecurityID)->Description . ' to your watchlist',
                    'watchlist' => [
                        'Security'   => $filtered->first()->Security,
                        'SecurityID' => $filtered->first()->SecurityID,
                        'Deals'      => $filtered->first()->Deals . ' ' . str_plural('deal', $filtered->first()->Deals),
                        'LastPrice'  => number_format($filtered->first()->LastPrice, 2),
                        'Volume'     => number_format($filtered->first()->Volume, 2),
                    ],
                ])
                    ->setStatusCode(200);
            } else {
                return response()->json('Fail to add ' . Security::find($watchlist->SecurityID)->Description . ' to your watchlist')
                    ->setStatusCode(500);
            }
        }
    }

    public function unWatchSecurity(Request $request)
    {
        // check if that security is being watched already
        $watchlist = WatchList::where('SecurityID', $request->SecurityRef)->where('InputterID', auth()->user()->id)->delete();
        if ($watchlist) {
            return response()->json("Security has been removed from watchlist")->setStatusCode(200);
        } else {
            return response()->json("Security wasn't removed from watchlist")->setStatusCode(500);
        }
    }

    public function getBalanceForSecurity($id)
    {
        $user          = auth()->user()->id;
        $balance_count = GL::where('SecurityID', $id)
            ->where('CustomerID', $user)->get();
        if (count($balance_count) > 0) {
            $balance = GL::where('SecurityID', $id)
                ->where('CustomerID', $user)->first()->ClearedBalance;
            return response()->json($balance)->setStatusCode(200);

        } else {
            return response()->json(count($balance_count))->setStatusCode(200);
        }

    }

    public function mark_as_read($id)
    {
        $user = User::find($id);
        $user->unreadNotifications->markAsRead();
        return response()->json("All Clean")->setStatusCode(200);
    }

    public function pricelist()
    {

        $market_pricelist = Cache::remember('market-prices', 22 * 60, function () {
            $client = new \GuzzleHttp\Client();
            $res    = $client->request('GET', 'https://comercio.timsmate.com/api/market-prices');

            $pricelist_raw        = json_decode($res->getBody());
            $pricelist            = collect($pricelist_raw);
            $pricelist_collection = $pricelist->transform(function ($item, $key) {
                if ($item->ProductID == 1) {
                    $item->ProductID = '<b>Bonds</b>';
                } else {
                    $item->ProductID = 'TBills';
                }
                $item->Yield        = number_format($item->Yield, 2);
                $item->Description  = '<b style="color:#f6a821">' . $item->Description . '</b>';
                $item->ClosingPrice = '<b style="color:#fff">' . number_format($item->ClosingPrice, 2) . '</b>';
                $item->ClosingDate  = (string) \Carbon\Carbon::parse($item->ClosingDate)->toFormattedDateString();
                return $item;
            });

            return $pricelist_collection;
        });
        if ($market_pricelist != null) {
            return $market_pricelist;
        }
        return $this->price_list_cache();
    }

    public function price_list_cache()
    {
        $client = new \GuzzleHttp\Client();
        $res    = $client->request('GET', 'https://comercio.timsmate.com/api/market-prices');

        $pricelist_raw        = json_decode($res->getBody());
        $pricelist            = collect($pricelist_raw);
        $pricelist_collection = $pricelist->transform(function ($item, $key) {
            if ($item->ProductID == 1) {
                $item->ProductID = '<b>Bonds</b>';
            } else {
                $item->ProductID = 'TBills';
            }
            $item->Yield        = number_format($item->Yield, 2);
            $item->Description  = '<b style="color:#f6a821">' . $item->Description . '</b>';
            $item->ClosingPrice = '<b style="color:#fff">' . number_format($item->ClosingPrice, 2) . '</b>';
            $item->ClosingDate  = (string) \Carbon\Carbon::parse($item->ClosingDate)->toFormattedDateString();
            return $item;
        });
        return $pricelist_collection;
    }

    public function equitieslist()
    {

        $equities_pricelist = Cache::remember('equities-list', 22 * 60, function () {
            $client = new \GuzzleHttp\Client();
            $res    = $client->request('GET', 'api.catss.ng/api/cavidex/equities');

            $pricelist_raw = json_decode($res->getBody());
            $pricelist     = collect($pricelist_raw);
            $s             = $pricelist->transform(function ($item, $key) {

                $item->security       = '<b style="color:gold">' . $item->security . '</b>';
                $item->previous_close = '<b style="color:#fff">' . number_format($item->previous_close, 2) . '</b>';
                $item->close_price    = '<b style="color:#fff">' . number_format($item->close_price, 2) . '</b>';
                $item->date           = (string) \Carbon\Carbon::parse($item->date->date)->toFormattedDateString();
                return $item;
            });
            return $s;
        });

        if ($equities_pricelist != null) {
            return $equities_pricelist;
        }
        return $this->equities_list_cache();
    }

    public function equities_list_cache()
    {
        $client = new \GuzzleHttp\Client();
        $res    = $client->request('GET', 'api.catss.ng/api/cavidex/equities');

        $pricelist_raw = json_decode($res->getBody());
        $pricelist     = collect($pricelist_raw);
        $s             = $pricelist->transform(function ($item, $key) {

            $item->security       = '<b style="color:gold">' . $item->security . '</b>';
            $item->previous_close = '<b style="color:#fff">' . number_format($item->previous_close, 2) . '</b>';
            $item->close_price    = '<b style="color:#fff">' . number_format($item->close_price, 2) . '</b>';
            $item->date           = (string) \Carbon\Carbon::parse($item->date->date)->toFormattedDateString();
            return $item;
        });
        return $s;
    }
}
