<?php

namespace TradefiUBA\Http\Controllers\Admin;

use TradefiUBA\Http\Controllers\Controller;
use TradefiUBA\Inventory;
use TradefiUBA\Security;
use TradefiUBA\TransactionType;
use TradefiUBA\Country;
use Illuminate\Http\Request;
use DB;
use TradefiUBA\FootPrint;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();
        // dd($inventories);
        return view('inventory.index', compact('inventories'));
    }

    public function create()
    {
        $buy_inventory = \DB::select(
            'EXEC procInventoryList 1'
        );

        $sell_inventory = \DB::select(
            'EXEC procInventoryList 2'
        );

        // dd(collect($sell_inventory)->where('SecurityID', 5)->sum('Quantity'));

        $unsent_inventory = Inventory::where('NotifyFlag', 0)->where('TransactionTypeID2', '<>', null)->get();
        // dd($unsent_inventory);

        // dd($sell_inventory);
        $securities = Security::select('SecurityRef', 'Description', 'Security')
            ->where('MaturityDate', '>=', \Carbon\Carbon::now())
            ->get();
        $transaction_types = TransactionType::select('TransactionTypeRef', 'TransactionType')
            ->whereIn('TransactionTypeRef', [1, 2])->get();

        $transaction_types2 = TransactionType::select('TransactionTypeRef', 'TransactionType')
            ->whereIn('TransactionTypeRef', [7, 8])->get();

        return view('inventory.create', compact('buy_inventory', 'sell_inventory', 'unsent_inventory', 'securities', 'transaction_types', 'transaction_types2'));
    }

    public function inventory_today()
    {
      // $inventory_today = Inventory::select('SecurityID', DB::raw('MAX(Quantity) as Quantity'))->whereDate('created_at', date('Y-m-d'))->groupBy('SecurityID')->orderBy('Quantity', 'desc')->get();

      // $inventory_list = Inventory::select('SecurityID', DB::raw('MAX(Quantity) as Quantity, MAX(created_at) as created_at'))->whereDate('created_at', '!=', date('Y-m-d'))->groupBy('SecurityID')->orderBy('created_at', 'desc')->get();

      // $buy_inventory = collect(\DB::select('EXEC procInventoryList 1'))->where('Date', date('Y-m-d'));
      // $sell_inventory = collect(\DB::select('EXEC procInventoryList 2'))->where('Date', date('Y-m-d'));
      $inventory_list = collect(\DB::select('EXEC procUBAInventory'));

      // dd($buy_inventory);


      // $buy_inventory = collect(\DB::select(
      //   'EXEC procInventoryList 1'
      // ))->filter(function($q){
      //   return substr($q->Date, 0,10) == date('Y-m-d');
      // })->transform(function($item) {
      //   $item->sell = collect(\DB::select('EXEC procInventoryList 2'))->where('SecurityID', $item->SecurityID)->filter(function($q){
      //     return substr($q->Date, 0,10) == date('Y-m-d');
      //   })->first();
        
      //   return $item;
      // });

      

      // dd($buy_inventory);

      // ***========
      $footprint = (object) [
        'Title' => 'Inventory Today'
      ];
      FootPrint::logTrail($footprint);
      // ***========

      
      return view('inventory.inventory', compact('inventory_today', 'inventory_list', 'buy_inventory', 'sell_inventory', 'buy_history', 'sell_history', 'unsent_inventory', 'securities', 'transaction_types', 'transaction_types2'));
    }

    public function get_inventory(Request $request)
    {
        $inventory = Inventory::where('SecurityID', $request->SecurityID)->with('security')->get();
        $inventory = collect($inventory)->transform(function ($item, $key) {
            $trans_type = "";
            $trade_type = "";
            if ($item->TransactionTypeID == 1) {
                $trans_type = '<b style="color: #6bf16b"> Buy</b>';
            } elseif ($item->TransactionTypeID == 2) {
                $trans_type = '<b style="color: #ff4545"> Sell</b>';
            }
            // ----- //
            if ($item->TransactionTypeID2 == 7) {
                $trade_type = '<b style="color: #6bf16b"> Deposit</b>';
            } elseif ($item->TransactionTypeID2 == 8) {
                $trade_type = '<b style="color: #ff4545"> Withdrawal</b>';
            } elseif ($item->TransactionTypeID2 == null || $item->TransactionTypeID2 == '') {
                $trade_type = '<b style="color: #EEE"> User Trade</b>';
            }

            $item->transaction_type = $trans_type . ' - ' . $trade_type;
            $item->deal_date        = \Carbon\Carbon::parse($item->created_at)->toFormattedDateString();
            return $item;
        });
        return $inventory;
    }

    public function store(Request $request)
    {
        $inventory = new Inventory($request->all());
        if ($request->TransactionTypeID == 1 && $request->TransactionTypeID2 == 7) {
            //deposit
            $inventory->Quantity = $request->Quantity * 1;
        }

        if ($request->TransactionTypeID == 2 && $request->TransactionTypeID2 == 7) {
            //deposit
            $inventory->Quantity = $request->Quantity * 1;
        }

        if ($request->TransactionTypeID == 1 && $request->TransactionTypeID2 == 8) {
            //deposit
            $inventory->Quantity = $request->Quantity * -1;
        }
        if ($request->TransactionTypeID == 2 && $request->TransactionTypeID2 == 8) {
            //deposit
            $inventory->Quantity = $request->Quantity * -1;
        }
        $buy_limit = collect(\DB::select(
            'EXEC procInventoryList 1'
        ))->sum('Quantity');
        $sell_limit = collect(\DB::select(
            'EXEC procInventoryList 2'
        ))->sum('Quantity');

        if ($request->TransactionTypeID2 == 8 && $request->TransactionTypeID == 1) {
            $this->validate($request, [
                'SecurityID'        => 'required',
                'TransactionTypeID' => 'required',
                'Quantity'          => 'required|numeric|max:' . $buy_limit,

            ], [
                'Quantity.max' => 'The Quantity Exceeded your Buy Balance Of ' . number_format($buy_limit),
            ]);
        } elseif ($request->TransactionTypeID2 == 8 && $request->TransactionTypeID == 2) {
            $this->validate($request, [
                'SecurityID'        => 'required',
                'TransactionTypeID' => 'required',
                'Quantity'          => 'required|numeric|max:' . $sell_limit,

            ], [
                'Quantity.max' => 'The Quantity Exceeded your Sell Balance Of ' . number_format($sell_limit),
            ]);
        } else {
            $this->validate($request, [
                'SecurityID'        => 'required',
                'TransactionTypeID' => 'required',
                'Quantity'          => 'required|numeric',

            ]);
        }

        if ($inventory->save()) {
            return redirect()->route('admin.inventory.create')->with('success', 'Inventory was added successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Inventory failed to save');
        }
    }

    public function show($id)
    {
        //
    }

    public function send(Request $request, $id)
    {
        $inventory = Inventory::find($id);
        if ($inventory->update(['NotifyFlag' => 1])) {
            return redirect()->route('admin.inventory.create')->with('success', 'Inventory was sent for approval');
        } else {
            return back()->withInput()->with('error', 'Inventory failed to send for approval');
        }
    }

    public function edit($id)
    {
        $inventories = Inventory::all();
        $inventory   = Inventory::where('InventoryRef', $id)->first();
        // return dd($TradeRef);
        return view('inventory.edit', compact('branch', 'inventories'));
    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::find($id);
        $this->validate($request, [
            'Inventory' => 'required',

        ]);

        if ($inventory->update($request->all())) {
            return redirect()->route('inventory.create')->with('success', 'Inventory was updated successfully');
        } else {
            return back()->withInput()->with('error', 'Inventory failed to update');
        }
    }

    public function destroy($id)
    {
        //
    }
}
