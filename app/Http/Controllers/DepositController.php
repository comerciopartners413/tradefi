<?php

namespace TradefiUBA\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Notification;
use TradefiUBA\CashEntry;
use TradefiUBA\Config;
use TradefiUBA\DirectDeposit;
use TradefiUBA\FootPrint;
use TradefiUBA\GL;
use TradefiUBA\Mail\DepositMail;
use TradefiUBA\Notifications\DepositNotification2;
use TradefiUBA\User;
use TradefiUBA\Workflow;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $approver_role = auth()->user()->roles->pluck('id');
        // dd($approver_role);
        $unapproved_deposits = CashEntry::where('ApproverID', '<>', 0)
            ->where('NotifyFlag', 1)
            ->whereIn('ApproverID', $approver_role)->get();
        return view('deposits.index', compact('unapproved_deposits'));
    }

    public function all()
    {
        $unapproved_deposits = CashEntry::where('ApproverID', auth()->user()->id)
            ->get();
        // dd($unapproved_deposits);
        return view('deposits.index', compact('unapproved_deposits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function re_query(Request $request)
    {
        $cash_entry    = CashEntry::find($request->id);
        $trans_id      = $request->transaction_id;
        $cpay_ref      = $request->cpay_ref;
        $merchant_id   = \App::Environment('local') ? 'NIBSS0000000118' : 'NIBSS0000004032';
        $currency_code = '566';
        $product_id    = '0000000001';
        $secret_key    = \App::Environment('local') ? '63E76E47A95DC88A3FB26A8F88F8A43C' : 'C81729DD10529D4B5C12A4C73153C0DE';
        // $hash          = hash('SHA256', '0000000001' . 'C168E-DDADC-4BD68-2D957' . 'NIBSS0000004032' . 'C81729DD10529D4B5C12A4C73153C0DE');
        $hash = hash('SHA256', $trans_id . $cpay_ref . $merchant_id . $secret_key);

        $client = new \GuzzleHttp\Client();
        // $client->setDefaultOption('verify', false);
        $res = $client->request('GET', "https://centralpay.nibss-plc.com.ng/CentralPayPlus/merchantTransQueryJSON?transaction_id=$trans_id&cpay_ref=$cpay_ref&merchant_id=$merchant_id&hash=$hash", [
            'protocols' => ['http', 'https'],
            'verify'    => false,
        ]);

        $query = json_decode($res->getBody());
        return response()->json($query);
    }

    public function store(Request $request)
    {
        $deposit              = new CashEntry($request->all());
        $workflow_data        = Workflow::where('ModuleID', 36)->first();
        $deposit->CustomerID  = auth()->user()->id;
        $deposit->ApproverID  = $workflow_data->ApproverID1;
        $deposit->ApproverID1 = $workflow_data->ApproverID1;
        $deposit->ApproverID2 = $workflow_data->ApproverID2;
        $deposit->ApproverID3 = $workflow_data->ApproverID3;
        $deposit->ApproverID4 = $workflow_data->ApproverID4;
        $deposit->ApproverID5 = $workflow_data->ApproverID5;

        if ($deposit->save()) {
            // return response()->json([
            //     'message' => 'Depositwassuccessful',
            // ]);
            if (auth()->user()->admin) {

                return redirect()->route('admin.deposits.index')->with('success', 'This is an admin account');
            } else {
                // notify admin oof deposit

                if (\App::Environment('local')) {
                    Mail::to(['riliwan.rabo@gmail.com'])
                        ->queue(new DepositMail($deposit));
                } else {
                    Mail::to('settlement@tradefi.ng')
                        ->cc(['riliwan.rabo@gmail.com'])
                        ->queue(new DepositMail($deposit));
                }
                return redirect()->route('home')->with('success', 'Deposit wass uccessful');
            }
        } else {
            return back()->withInput();
        }
    }

    public function withdrawal_store(Request $request)
    {
        $withdrawals = new CashEntry($request->all());
        $CustomerGl  = auth()->user()->gls->first()->ClearedBalance;
        dd($CustomerGl);
        $DebitLimit         = $CustomerGl->DebitLimitTotal;
        $absoluteDebitLimit = abs($DebitLimit);
        $this->validate($request, [
            'Amount'    => "required|numeric|max:$absoluteDebitLimit",
            'GLIDDebit' => 'required',
        ]);
        if ($withdrawals->save()) {
            return redirect()->route('withdrawals.create')->with('success', 'Withdrawal was successful');
        } else {
            return redirect()->back()->withInput()->with('error', 'Withdrawalfailed');
        }
    }

    public function pay_view()
    {
        return redirect('/home')->with('error', 'Transaction Incomplete');
    }

    public function pay(Request $request)
    {

        if (!auth()->check()) {
            return redirect('/timedout');
        }

        $trans_id      = $request->transaction_id;
        $cpay_ref      = $request->cpay_ref;
        $merchant_id   = \App::Environment('local') ? 'NIBSS0000000118' : 'NIBSS0000004032';
        $currency_code = '566';
        $product_id    = '0000000001';
        $secret_key    = \App::Environment('local') ? '63E76E47A95DC88A3FB26A8F88F8A43C' : 'C81729DD10529D4B5C12A4C73153C0DE';
        $hash          = hash('SHA256', $trans_id . $cpay_ref . $merchant_id . $secret_key);

        // dd($hash);
        // GuzzleHttp\Exception\GuzzleException

        try {

            $client = new \GuzzleHttp\Client();
            // $client->setDefaultOption('verify', false);
            if (\App::Environment('local')) {
                $res = $client->request('GET', "https://staging.nibss-plc.com.ng/CentralPayPlus/merchantTransQueryJSON?transaction_id=$trans_id&cpay_ref=$cpay_ref&merchant_id=$merchant_id&hash=$hash", [
                    'protocols' => ['http', 'https'],
                    'verify'    => false,
                ]);
            } else {
                $res = $client->request('GET', "https://centralpay.nibss-plc.com.ng/CentralPayPlus/merchantTransQueryJSON?transaction_id=$trans_id&cpay_ref=$cpay_ref&merchant_id=$merchant_id&hash=$hash", [
                    'protocols' => ['http', 'https'],
                    'verify'    => false,
                ]);
            }

            // dd($res->getBody());
            $payment_query    = json_decode($res->getBody());
            $payment_response = collect($payment_query);
            // dd($payment_response);
            $cpay_ref             = $payment_response["CPAYRef"];
            $transaction_id       = $payment_response["TransactionId"];
            $amount               = $payment_response["Amount"];
            $bank_code            = $payment_response["BankCode"];
            $response_code        = $payment_response["ResponseCode"];
            $response_description = $payment_response["ResponseDesc"];
            $date_time            = $payment_response["TransDate"];
            $currency_code        = $payment_response["Currency"];
            $confirmation_hash    = hash('SHA256', $merchant_id . $product_id . $cpay_ref . $bank_code . $response_code . $response_description . $date_time . $amount . $trans_id . $currency_code);

            $workflow_data = Workflow::where('ModuleID', 36)->first();
            // $initial_amount = $amount;
            $commission = ($amount / 100 * 0.015);
            if ($commission > 2000) {
                $commission = 2000;
            } else {
                $commission = $commission;
            }
            $new_amount = $amount - ($commission * 100);
            if ($response_code == '000') {
                $cash_entry = new CashEntry([
                    'TransferTypeID'  => 2,
                    'PostingTypeID'   => 1,
                    'TransactionDate' => $date_time,
                    'Amount'          => $new_amount / 100, //get naira from kobo
                    'CustomerID'      => auth()->user()->id,
                    'BankID'          => 21,
                    'cpay_ref'        => $cpay_ref,
                    'transaction_id'  => $transaction_id,
                    'ApproverID'      => $workflow_data->ApproverID1,
                    'ApproverID1'     => $workflow_data->ApproverID1,
                    'ApproverID2'     => $workflow_data->ApproverID2,
                    'ApproverID3'     => $workflow_data->ApproverID3,
                    'ApproverID4'     => $workflow_data->ApproverID4,
                    'ApproverID5'     => $workflow_data->ApproverID5,
                    'Description'     => $response_description,
                    'Status'          => $response_code,

                ]);

                if ($cash_entry->save()) {
                    CashEntry::find($cash_entry->CashEntryRef)->update([
                        'ApprovedFlag' => true,
                        'ApproverID'   => 0,
                        'ApprovalDate' => \Carbon\Carbon::now(),

                    ]);
                    Notification::send(auth()->user(), new DepositNotification2($cash_entry));
                    return redirect("/deposit/details/$cash_entry->CashEntryRef/$response_description/$cpay_ref/" . $amount / 100
                    )->with('info', 'Deposit was successful');
                }

            } else {
                $cash_entry = new CashEntry([
                    'TransferTypeID'  => 2,
                    'PostingTypeID'   => 1,
                    'TransactionDate' => $date_time,
                    'Amount'          => $new_amount / 100, //get naira from kobo
                    'CustomerID'      => auth()->user()->id,
                    'BankID'          => 21,
                    'cpay_ref'        => $cpay_ref,
                    'transaction_id'  => $transaction_id,
                    'ApproverID'      => $workflow_data->ApproverID1,
                    'ApproverID1'     => $workflow_data->ApproverID1,
                    'ApproverID2'     => $workflow_data->ApproverID2,
                    'ApproverID3'     => $workflow_data->ApproverID3,
                    'ApproverID4'     => $workflow_data->ApproverID4,
                    'ApproverID5'     => $workflow_data->ApproverID5,
                    'Description'     => $response_description,
                    'Status'          => $response_code,
                ]);
                $cash_entry->save();
                // TODO: Add status failed
                CashEntry::find($cash_entry->CashEntryRef)->update([
                    'ApprovedFlag' => false,
                    'ApproverID'   => 1, //LEAVE AS 1
                    'ApprovalDate' => null,

                ]);
                Notification::send(auth()->user(), new DepositNotification2($cash_entry));
                return redirect("/deposit/details/$cash_entry->CashEntryRef/$response_description/$cpay_ref/" . $amount / 100
                )->with('error', $response_description . '<br> #' . $response_code);
            }
            // return dd($payment_response);

        } catch (\GuzzleHttp\Exception\GuzzleException $e) {

            dd($e);

        }

    }

    public function details($id, $description, $cpay_ref, $amount)
    {
        $cash_entry = CashEntry::find($id);
        $cust_info  = $cash_entry->user->profile->fullname;
        $desc       = $description;
        $cpay_ref   = $cpay_ref;
        $amount     = $amount;

        return view('deposits.details_', compact('cust_info', 'desc', 'cpay_ref', 'amount'));
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    public function bank_deposit(Request $request)
    {
        $deposit   = new DirectDeposit($request->all());
        $validator = \Validator::make($request->all(), [
            'pop' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->with('error', 'Failed. Try Again');
        }

        if ($request->has('pop')) {
            $now = time();

            $file = $request->file('pop');
            $path = $file->hashName('pop');
            // $image = \Image::make($file);

            // \Storage::disk('public')->put($path, $file);
            $user         = auth()->user();
            $filename     = $now . '-' . $user->username . '-pop-' . $file->getClientOriginalName();
            $deposit->pop = $filename;
            $file->storeAs('public/pop', $filename);

            $deposit->save();
        }

        return redirect('/profile')->with('success', 'Uploaded successfully and awaiting approval');
    }

    public function bank_deposits()
    {
        $request = (object) [
            'Title' => 'Direct Deposits Screen',
        ];
        FootPrint::logTrail($request);

        $approver_role = auth()->user()->roles->pluck('id');
        // dd($ops_initiators);
        // load modules
        if (in_array(3, $approver_role->toArray())) {
            $deposits = DirectDeposit::where('ApprovalStatus', 0)
                ->where('NotifyFlag', 0)
                ->orWhere('ApprovalStatus', null)
                ->latest()->get();
        } else {
            $deposits = collect([]);
        }
        $approved_deposits = DirectDeposit::where('ApprovedFlag', 1)
            ->where('ModuleID', 36)
            ->where('ApproverID', 0)
            ->get();
        $posted_deposits = DirectDeposit::where('ApprovedFlag', 1)
            ->where('ModuleID', 36)
            ->where('ApproverID', 0)
            ->where('PostedFlag', 1)
            ->get();
        return view('deposits.direct', compact('deposits', 'posted_deposits', 'approved_deposits'));
    }

    public function bank_deposits_approve(Request $request)
    {
        $deposit                 = DirectDeposit::find($request->id);
        $deposit->ApprovalStatus = 1;
        $deposit->ApproverID     = $request->ApproverID;
        $deposit->save();
        return redirect('/deposit/bank-deps')->with('success', 'Approved Successfully');
    }

    public function customer_transfer()
    {
        $configs          = Config::first();
        $customers        = User::where('id', '<>', 1)->get();
        $customer_details = collect(\DB::select("SELECT GLRef, users.username + ' - ' + tblAccountType.AccountType + ' / '  + CONVERT(varchar, format(tblGL.ClearedBalance,'#,##0.00'))
                         AS CUST_ACCT
                            FROM            tblGL INNER JOIN
                         tblAccountType ON tblGL.AccountTypeID = tblAccountType.AccountTypeRef INNER JOIN
                         users ON tblGL.CustomerID = users.id WHERE tblGL.AccountTypeID = 1 AND users.id <> 1
                         AND ActivatedFlag <> 0"));

        $cashentries = \DB::table('tblCashEntry')
            ->leftJoin('tblGL', 'tblCashEntry.GLIDCredit', '=', 'tblGL.GLRef')
            ->leftJoin('users', 'tblGL.CustomerID', '=', 'users.id')
        // ->where('PostingTypeID', '=', 11)
            ->where('tblGL.AccountTypeID', 1)
        // ->where('tblCashEntry.Posted', 0)
            ->get();
        return view('cash_entries.create_customer_transfer', compact('cashentries', 'customers', 'configs', 'customer_details'));
    }
    public function customer_transfer_store(Request $request)
    {
        $cashentries             = new CashEntry($request->all());
        $cashentries->CustomerID = GL::find($request->GLIDCredit)->CustomerID;
        // $absoluteDebitLimit = abs($DebitLimit);
        $this->validate($request,
            [
                //'Amount'    => "required|numeric|max:$absoluteDebitLimit",
                'ValueDate' => 'required',
                'GLIDDebit' => 'required',
            ]);
        if ($cashentries->save()) {

            // log trail
            $request = (object) [
                'Title' => 'Posted Cash with Reference #' . $cashentries->CashEntryRef,
            ];
            FootPrint::logTrail($request);

            // $cashentries->update(['PostedFlag' => 1]);
            return redirect()->route('customer_transfer')->with('success', 'Cash Entry was successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Cash Entry failed to save');
        }
    }

    public function bonds_custody_transfer()
    {
        $configs          = Config::first();
        $customers        = User::where('id', '<>', 1)->get();
        $customer_details = collect(\DB::select("SELECT GLRef, users.username + ' - ' + tblAccountType.AccountType + ' / '  + CONVERT(varchar, format(tblGL.ClearedBalance,'#,##0.00'))
                         AS CUST_ACCT
                            FROM            tblGL INNER JOIN
                         tblAccountType ON tblGL.AccountTypeID = tblAccountType.AccountTypeRef INNER JOIN
                         users ON tblGL.CustomerID = users.id WHERE tblGL.AccountTypeID = 1 AND users.id <> 1
                         AND ActivatedFlag <> 0"));

        $cashentries = \DB::table('tblCashEntry')
            ->leftJoin('tblGL', 'tblCashEntry.GLIDCredit', '=', 'tblGL.GLRef')
            ->leftJoin('users', 'tblGL.CustomerID', '=', 'users.id')
        // ->where('PostingTypeID', '=', 11)
            ->where('tblGL.AccountTypeID', 1)
        // ->where('tblCashEntry.Posted', 0)
            ->get();
        return view('cash_entries.bonds_custody_transfer', compact('cashentries', 'customers', 'configs', 'customer_details'));
    }
    public function bonds_custody_transfer_store(Request $request)
    {
        $cashentries = new CashEntry($request->all());
        // $cashentries->CustomerID = GL::find($request->GLIDCredit)->CustomerID;
        $cashentries->CustomerID = GL::find($request->GLIDDebit)->CustomerID;
        $cashentries->ModuleID   = 38;
        $cashentries->Module     = 38;
        $cashentries->InputterID = auth()->user()->id;
        // $absoluteDebitLimit = abs($DebitLimit);
        $this->validate($request,
            [
                //'Amount'    => "required|numeric|max:$absoluteDebitLimit",
                'ValueDate' => 'required',
                'GLIDDebit' => 'required',
            ]);
        if ($cashentries->save()) {

            $request = (object) [
                'Title' => 'Posted Bonds Custody with Reference #' . $cashentries->CashEntryRef,
            ];
            FootPrint::logTrail($request);

            // $cashentries->update(['PostedFlag' => 1]);
            return redirect()->route('bonds_custody_transfer')->with('success', 'Cash Entry was successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Cash Entry failed to save');
        }
    }

    public function send(Request $request, $id)
    {
        $cash_entry = CashEntry::find($id);
        if ($cash_entry->update(['NotifyFlag' => 1])) {
            $request = (object) [
                'Title' => 'Sent Deposit with Ref: ' . $cash_entry->CashEntryRef,
            ];
            FootPrint::logTrail($request);
            return redirect()->route('admin.deposits.index')->with('success', 'Deposit request was sent successfully');
        } else {
            return back()->withInput()->with('error', 'Deposit request failed to update');
        }
    }

    public function destroy($id)
    {
        $cash_entry = CashEntry::find($id);
        if ($cash_entry) {
            $cash_entry->delete();
            $request = (object) [
                'Title' => 'Deleted/Archived Deposit with Ref: ' . $cash_entry->CashEntryRef,
            ];
            FootPrint::logTrail($request);
            return redirect()->route('admin.deposits.index')->with('success', 'Deposit request was archived successfully');
        } else {
            return back()->withInput()->with('error', 'Deposit request failed to delete');
        }
    }
}
