<?php

namespace TradefiUBA\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use TradefiUBA\CashEntry;
use TradefiUBA\Config;
use TradefiUBA\FootPrint;
use TradefiUBA\Mail\SendWithdrawalRequest;
use TradefiUBA\Workflow;

class WithdrawalController extends Controller
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

        $unapproved_withdrawals = CashEntry::where('ApproverID', '<>', 0)
            ->where('ModuleID', 37)
            ->where('NotifyFlag', 1)
        //->where('RejectedFlag', 0)
            ->whereIn('ApproverID', $approver_role)->get();

        $unsent_withdrawals = CashEntry::where('ApproverID', '<>', 0)
            ->join('tblWorkflowData', 'tblCashEntry.ModuleID', '=', 'tblWorkflowData.ModuleID')
            ->where('tblCashEntry.ModuleID', 37)
            ->where('NotifyFlag', 0)
            ->whereIn('tblWorkflowData.RequesterID', $approver_role)->get();

        $withdrawals          = CashEntry::where('PostingTypeID', 12)->where('ModuleID', 37)->get();
        $approved_withdrawals = CashEntry::approved_withdrawals();
        // return dd($cash_entries);
        return view('admin.withdrawals.index', compact('unapproved_withdrawals', 'withdrawals', 'unsent_withdrawals', 'approved_withdrawals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $configs = Config::first();
        // $customers        = Customer::all();
        $customer_details = \DB::table('tblGL')
            ->select('GLRef', 'tblGL.Description as des', \DB::raw('CONCAT("Customer", \' - \' ,"AccountType", \' - \',"AccountNo", \' - \',"BookBalance") AS CUST_ACCT'))
            ->leftJoin('tblCustomer', 'tblGL.CustomerID', '=', 'tblCustomer.CustomerRef')
            ->leftJoin('tblAccountType', 'tblGL.AccountTypeID', '=', 'tblAccountType.AccountTypeRef')
            ->leftJoin('tblCurrency', 'tblGL.CurrencyID', '=', 'tblCurrency.CurrencyRef')
            ->leftJoin('tblBranch', 'tblGL.BranchID', '=', 'tblBranch.BranchRef')
            ->get();
        $cashentries = \DB::table('tblCashEntry')
            ->leftJoin('tblGL', 'tblCashEntry.GLIDCredit', '=', 'tblGL.GLRef')
            ->leftJoin('tblCustomer', 'tblGL.CustomerID', '=', 'tblCustomer.CustomerRef')
            ->where('PostingTypeID', '=', 12)
            ->where('Posted', '=', 0)
            ->get();
        return view('withdrawals.create', compact('cashentries', 'configs', 'customer_details'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check if a bank detail exists
        if (auth()->user()->profile->bank_detail->bank_id == null || auth()->user()->profile->bank_detail->bank_id == 0 || auth()->user()->avatar == null || auth()->user()->identification == null) {
            return back()->with('error', 'One of either your Banking details, Passport Photograph, Means Of Identification needs to be updated before making a withdrawal');
        }

        // return response()->json($request->Amount, 200);

        // validate Amount (Musn't be less than 52.50)
        if ($request->Amount < 52.50) {
            return back()->withInput()->with('error', 'You cannot withdraw less than 52.50');
        }

        $withdrawals             = new CashEntry($request->all());
        $CustomerGl              = \DB::table('tblGL')->where('GLRef', $request->GLIDDebit)->first();
        $workflow_data           = Workflow::where('ModuleID', 37)->first();
        $withdrawals->CustomerID = auth()->user()->id;
        // $withdrawals->BankID        = auth()->user()->profile->bank_detail ? auth()->user()->profile->bank_detail->bank_id : null;
        $withdrawals->TransferTypeID  = 2;
        $withdrawals->TransactionDate = Config::first()->TradeDate;
        $withdrawals->PostingTypeID   = 12;

        //
        $DebitLimit                   = $CustomerGl->ClearedBalance;
        $withdrawals->Amount          = $request->Amount - 52.50;
        $withdrawals->BankID          = auth()->user()->profile->bank_detail->bank_id;
        $withdrawals->TransactionDate = \Carbon\Carbon::now();
        if ($DebitLimit - 52.50 >= 0) {
            $absoluteDebitLimit = $CustomerGl->ClearedBalance;
        } else {
            $absoluteDebitLimit = $DebitLimit - 52.50;
        }

        //
        $absoluteDebitLimit2 = $absoluteDebitLimit + 0.01;
        // dd($absoluteDebitLimit2);
        $this->validate($request, [
            'Amount'    => "required|numeric|max:$absoluteDebitLimit|min:0",
            'GLIDDebit' => 'required',
        ]);
        if ($withdrawals->save()) {
            $withdrawals->update([
                'BlockedFlag' => 1,
            ]);

            Mail::to('settlement@tradefi.ng')
            // ->cc(['riliwan.rabo@gmail.com'])
                ->queue(new SendWithdrawalRequest($withdrawals));

            if (auth()->user()->admin) {
                return redirect()->route('withdrawals.index')->with('success', 'Withdrawal was successful');
            } else {
                return redirect()->route('transactions.index')->with('success', 'Withdrawal was successful');
            }
        } else {
            return 'aye';
        }
    }

    public function send(Request $request, $id)
    {
        $cash_entry = CashEntry::find($id);
        if ($cash_entry->update(['NotifyFlag' => 1])) {
            $request = (object) [
                'Description' => 'Sent withdrawal request with Ref: ' . $cash_entry->CashEntryRef,
            ];
            FootPrint::logTrail($request);
            return redirect()->route('withdrawals.index')->with('success', 'Withdrawal request was sent successfully');
        } else {
            return back()->withInput()->with('error', 'Withdrawal request failed to update');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $configs          = Config::first();
        $customer_details = \DB::table('tblGL')
            ->select('GLRef', 'tblGL.Description as des', \DB::raw('CONCAT("Customer", \' - \' ,"AccountType", \' - \',"AccountNo", \' - \',"BookBalance") AS CUST_ACCT'))
            ->leftJoin('tblCustomer', 'tblGL.CustomerID', '=', 'tblCustomer.CustomerRef')
            ->leftJoin('tblAccountType', 'tblGL.AccountTypeID', '=', 'tblAccountType.AccountTypeRef')
            ->leftJoin('tblCurrency', 'tblGL.CurrencyID', '=', 'tblCurrency.CurrencyRef')
            ->leftJoin('tblBranch', 'tblGL.BranchID', '=', 'tblBranch.BranchRef')
            ->get();
        $withdrawals = CashEntry::where('PostingTypeID', '=', 12)->get();
        $withdrawal  = CashEntry::where('CashEntryRef', $id)->first();
        // return dd($TradeRef);
        return view('withdrawals.edit', compact('withdrawal', 'withdrawals', 'cashentries', 'customers', 'configs', 'customer_details'));
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
        $withdrawals = \DB::table('tblCashEntry')->where('CashEntryRef', $id);
        if ($withdrawals->update($request->except(['_token', '_method']))) {
            return redirect()->route('withdrawals.create')->with('success', 'Withdrawal was successfully');
        } else {
            return back()->withInput()->with('error', 'Withdrawal failed ');
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
        $cash_entry = CashEntry::find($id);
        if ($cash_entry) {

            try {
                DB::beginTransaction();
                $cash_entry->delete();
                // this procedure will perform some auto reversal

                // $RejectedDate = $request->RejectedDate;
                // $Ref          = collect($cash_entry->CashEntryRef);
                // $RejecterID   = auth()->user()->id;
                // $Comment      = 'Deleted by ' . auth()->user()->profile->fullname;
                // $ModuleID     = 37;
                // $RejectedFlag = 0;
                // $approve_proc = \DB::statement(
                //     "EXEC procRejectRequest  '$RejectedDate', '$Ref', $ModuleID, '$Comment', $RejecterID, $RejectedFlag"
                // );

                $request = (object) [
                    'Description' => 'Deleted/Archived Withdrawal with Ref: ' . $cash_entry->CashEntryRef,
                ];
                FootPrint::logTrail($request);
                return redirect()->route('withdrawals.index')->with('success', 'Withdrawal request was archived successfully');

                DB::commit();

                // Audit log

            } catch (Exception $e) {
                DB::rollback();
                return back()->withInput()->with('error', 'Withdrawal request failed to delete: ' . $e->getMessages()->first());
            }

        } else {
            return back()->withInput()->with('error', 'Withdrawal failed to delete');
        }
    }

    public function check_password(Request $request)
    {
        $user = auth()->user();
        try {
            if (decrypt($user->trading_pin) == $request->password) {
                return response()->json(['success' => true, 'message' => 'Pin Matched'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Wrong Pin. Unauthorized'], 401);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
