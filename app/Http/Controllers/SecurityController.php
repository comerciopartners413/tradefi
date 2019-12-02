<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\ClosingPriceBonds;
use TradefiUBA\ClosingPriceTBills;
use TradefiUBA\DayBasis;
use TradefiUBA\Frequency;
use TradefiUBA\Product;
use TradefiUBA\Security;
use TradefiUBA\Spread;
use Excel;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $securities = \DB::table('tblSecurity')
            ->select('tblSecurity.*', 'tblProduct.Product')
            ->join('tblProduct', 'tblSecurity.ProductID', '=', 'tblProduct.ProductRef')
            ->get();
        return view('securities.index', compact('securities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $trade_types = TradeType::all();
        // $securities = Security::all();
        $securities = \DB::table('tblSecurity')
            ->select('tblSecurity.*', 'tblProduct.Product')
            ->join('tblProduct', 'tblSecurity.ProductID', '=', 'tblProduct.ProductRef')
            ->where('tblSecurity.InputterID', auth()->user()->id)
            ->where('tblSecurity.NotifyFlag', 0)
            ->get();
        // dd($securities);
        $products    = Product::all();
        $frequencies = Frequency::all();
        $day_basis   = DayBasis::all();
        return view('securities.create_', compact('securities', 'products', 'day_basis', 'frequencies'));
    }

    public function send(Request $request, $id)
    {
        $security = Security::find($id);
        if ($security->update(['NotifyFlag' => 1])) {
            return redirect()->route('securities.create')->with('success', 'Security was sent successfully');
        } else {
            return back()->withInput()->with('error', 'Security failed to update');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'Security'     => 'required',
            'IssueDate'    => 'required',
            'MaturityDate' => 'required',
        ]);
        if ($request->ProductID == 2) {
            $security = new Security($request->except(['CouponRate', 'Frequency', 'DayBasisID', 'Redemption']));
        } else {
            $security = new Security($request->all());
        }

        if ($security->save()) {
            // $security->update([
            //     'ApproverID'   => $security->workflow->ApproverID1 ?? null,
            //     'ApproverID1'  => $security->workflow->ApproverID1 ?? null,
            //     'ApproverID2'  => $security->workflow->ApproverID2 ?? null,
            //     'ApproverID3'  => $security->workflow->ApproverID3 ?? null,
            //     'ApproverID4'  => $security->workflow->ApproverID4 ?? null,
            //     'ApproverID5'  => $security->workflow->ApproverID5 ?? null,
            //     'ApproverID6'  => $security->workflow->ApproverID6 ?? null,
            //     'ApproverID7'  => $security->workflow->ApproverID7 ?? null,
            //     'ApproverID8'  => $security->workflow->ApproverID8 ?? null,
            //     'ApproverID9'  => $security->workflow->ApproverID9 ?? null,
            //     'ApproverID10' => $security->workflow->ApproverID10 ?? null,

            // ]);
            return redirect()->route('securities.create')->with('success', 'Security has been added successfully');
        } else {
            return back()->withErrors()->with('error', 'Security wasn\'t added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function benchmark(Request $request)
    {
        $security = Security::find($request->SecurityRef);
        // dd($security);
        if ($security->update(['BenchMarkFlag' => 1])) {
            return response()->json(['Security has been benchmarked'])->setStatusCode(200);
        } else {
            return false;
        }
    }

    public function remove_benchmark(Request $request)
    {
        $security = Security::find($request->SecurityRef);
        // dd($security);
        if ($security->update(['BenchMarkFlag' => 0])) {
            return response()->json(['Security has been unbenchmarked'])->setStatusCode(200);
        } else {
            return false;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products    = Product::all();
        $securities  = Security::all();
        $frequencies = Frequency::all();
        $day_basis   = DayBasis::all();
        $security    = \DB::table('tblSecurity')->where('SecurityRef', $id)->first();
        return view('securities.edit', compact('security', 'products', 'day_basis', 'frequencies', 'securities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $security = Security::find($id);
        // $request->ModifierID = 2;
        if ($security->update($request->except(['id', 'action']))) {
            return redirect()->route('securities.create')->with('success', 'Security was updated successfully');
        } else {
            return back()->withInput()->with('error', 'Security failed to update');
        }
    }

    public function spread_update_bonds(Request $request, $id)
    {

        $spread = Spread::find($id);
        // $request->ModifierID = 2;
        if ($spread->update($request->except(['id', 'action']))) {
            return redirect()->route('securities.makeSpread')->with('success', 'Spread was updated successfully');
        } else {
            return back()->withInput()->with('error', 'Spread failed to update');
        }
    }

    public function spread_update_tbills(Request $request, $id)
    {

        $spread = Spread::find($id);
        // $request->ModifierID = 2;
        if ($spread->update($request->except(['id', 'action']))) {
            return redirect()->route('securities.makeSpread')->with('success', 'Spread was updated successfully');
        } else {
            return back()->withInput()->with('error', 'Spread failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function importExport()
    {
        return view('securities.import');
    }

    /**
     * File Export Code
     *
     * @var array
     */
    public function downloadExcel(Request $request, $type)
    {
        $data = Item::get()->toArray();
        return Excel::create('itsolutionstuff_example', function ($excel) use ($data) {
            $excel->sheet('mySheet', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download($type);
    }

    /**
     * Import file into database Code
     *
     * @var array
     */
    public function importExcel(Request $request)
    {

        if ($request->Product == 1) {

// Bonds
            if ($request->hasFile('import_file')) {
                $path = $request->file('import_file')->getRealPath();

                $data = Excel::load($path, function ($reader) {})->get();

                if (!empty($data) && $data->count()) {

                    foreach ($data->toArray() as $key => $value) {
                        if (!empty($value)) {
                            // foreach ($value as $v) {
                            $insert[] = [
                                'Security'         => $value['description'],
                                'IssueDate'        => $value['issue_date'],
                                'Coupon'           => $value['coupon'],
                                'OutstandingValue' => $value['outstanding_value'],
                                'MaturityDate'     => $value['maturity_date'],
                                'TTM'              => $value['ttm'],
                                'Yield'            => $value['yield'],
                                'ClosingPrice'     => $value['closing_price'],
                            ];
                            // }
                            // dd($value['description']);
                        }
                    }

                    if (!empty($insert)) {
                        ClosingPriceBonds::truncate();
                        ClosingPriceBonds::insert($insert);
                        return back()->with('success', 'Insert Record successfully.');
                    }

                }

            }

        } elseif ($request->Product == 2) {

            if ($request->hasFile('import_file')) {
                $path = $request->file('import_file')->getRealPath();

                $data = Excel::load($path, function ($reader) {})->get();

                if (!empty($data) && $data->count()) {

                    foreach ($data->toArray() as $key => $value) {
                        if (!empty($value)) {
                            // foreach ($value as $v) {
                            $insert[] = [
                                'DTM'         => $value['dtm'],
                                'Description' => "{$value['maturity']}",
                                'ClosingRate' => $value['closing_rate'],
                                'Yield'       => $value['yield'],
                            ];
                            // }
                            // dd($value['description']);
                        }
                    }

                    if (!empty($insert)) {
                        ClosingPriceTBills::truncate();
                        ClosingPriceTBills::insert($insert);
                        return back()->with('success', 'Insert Record successfully.');
                    }

                }

            }
        }

        return back()->with('error', 'Please Check your file, Something is wrong there.');
    }

    public function makeSpread()
    {
        $securities_bonds = Security::where('MaturityDate', '>', \Carbon\Carbon::now())->select('SecurityRef', 'Security', 'Description', 'Spread')->where('ProductID', 1)->get();

        $securities_tbills = Security::where('MaturityDate', '>', \Carbon\Carbon::now())->select('SecurityRef', 'Security', 'Description', 'Spread')->where('ProductID', 2)->get();

        $spread = \DB::table('tblSpread')->where('SpreadRef', 1)->first();
        // dd($securities);
        return view('securities.spread', compact('securities_bonds', 'securities_tbills', 'spread'));
    }

    public function makeSpreadPost(Request $request)
    {
        $security = Security::find($request->id);
        if ($security->update(['Spread' => $request->Spread])) {
            return response()->json("success", 200);
        }
    }
}
