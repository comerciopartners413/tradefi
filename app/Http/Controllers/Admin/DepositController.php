<?php

namespace TradefiUBA\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use TradefiUBA\CashEntry;
use TradefiUBA\FootPrint;
use TradefiUBA\Http\Controllers\Controller;

class DepositController extends Controller
{
    public function index()
    {
        // dd($_SERVER['REMOTE_ADDR']);
        $request = (object) [
            'Title' => 'Deposits Screen (queue)',
        ];
        FootPrint::logTrail($request);

        $approver_role = auth()->user()->roles->pluck('id');
        // dd($approver_role);

        $approved_deposits = CashEntry::where('ApproverID', 0)
            ->where('ModuleID', 36)
            ->orderBy('ApprovalDate', 'desc')
            ->get();

        // dd($data);

        // ops initiator's queue
        $unapproved_deposits = CashEntry::where('ApproverID', '<>', 0)
            ->where('NotifyFlag', 1)
            ->where('ModuleID', 36)
        // ->where('InputterID', auth()->user(){->id})
            ->whereIn('ApproverID', $approver_role)
            ->get();
        // $cash_entries = CashEntry::where('PostingTypeID', 1)->get();

        $unsent_deposits = CashEntry::where('ApproverID', '<>', 0)
            ->join('tblWorkflowData', 'tblCashEntry.ModuleID', '=', 'tblWorkflowData.ModuleID')
            ->where('tblCashEntry.ModuleID', 36)
            ->where('transaction_id', null)
            ->where('NotifyFlag', 0)
        // ->whereIn('tblWorkflowData.RequesterID', $approver_role)->get();
            ->where('InputterID', auth()->user()->id)->get();
        // ->whereIn('ApproverID', $approver_role)->get();

        $approved_deposits = CashEntry::where('ApproverID', 0)
            ->where('ModuleID', 36)
            ->orderBy('ApprovalDate', 'desc')
            ->get();

        return view('admin.deposits.index', compact('unapproved_deposits', 'approved_deposits', 'unsent_deposits', 'cash_entries', 'unapproved_withdrawals', 'withdrawals', 'approved_withdrawals'));
    }

    public function approved_deposits_ajax(Request $request)
    {
        return datatables()->collection(collect(DB::select("EXEC procApprovedDeposits")))->toJson();
        // return Laratables::recordsOf(collect(DB::select("exec procFinalBillAmountAll ")));
    }

    public function send_custody(Request $request, $id)
    {
        $cash_entry = CashEntry::find($id);
        if ($cash_entry->update(['NotifyFlag' => 1])) {
            $request = (object) [
                'Title' => 'Sent Custody for approval',
            ];
            FootPrint::logTrail($request);
            return redirect()->route('admin.custody.index')->with('success', 'Custody Charge request was sent successfully');
        } else {
            return back()->withInput()->with('error', 'Custody Charge request failed to update');
        }
    }

    public function custody()
    {
        $request = (object) [
            'Title' => 'Custody Screen (queue)',
        ];
        FootPrint::logTrail($request);

        $approver_role = auth()->user()->roles->pluck('id');
        // dd($approver_role);

        $unapproved_custody = CashEntry::where('ApproverID', '<>', 0)
            ->where('NotifyFlag', 1)
            ->where('PostingTypeID', 15)
            ->where('ModuleID', 38)
        // ->where('transaction_id', '<>', null)
            ->whereIn('ApproverID', $approver_role)
            ->get();
        $cash_entries = CashEntry::where('PostingTypeID', 15)->get();

        $unsent_custody = CashEntry::where('ApproverID', '<>', 0)
            ->join('tblWorkflowData', 'tblCashEntry.ModuleID', '=', 'tblWorkflowData.ModuleID')
            ->where('tblCashEntry.ModuleID', 38)
            ->where('PostingTypeID', 15)
            ->where('NotifyFlag', 0)
        // ->whereIn('tblWorkflowData.RequesterID', $approver_role)->get();
            ->whereIn('RequesterID', $approver_role)->get();

        $approved_custody = CashEntry::where('ApproverID', 0)
            ->where('ModuleID', 38)
            ->where('ApprovedFlag', 1)
            ->where('PostingTypeID', 15)
            ->get();

        // $unapproved_withdrawals = CashEntry::unapproved_withdrawals();
        // $withdrawals            = CashEntry::where('PostingTypeID', 2)->get();
        // $approved_withdrawals   = CashEntry::approved_withdrawals();
        // return dd($cash_entries);
        return view('admin.custody.index', compact('unapproved_custody', 'approved_custody', 'unsent_custody', 'cash_entries', 'unapproved_withdrawals', 'withdrawals', 'approved_withdrawals'));
    }
}
