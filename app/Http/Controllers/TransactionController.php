<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\TradeData;
use TradefiUBA\Transaction;
use TradefiUBA\CashEntry;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $from       = $request->From;
        $to         = $request->To;
        $user       = auth()->user()->id;
        $statements = \DB::select("EXEC procViewBalancesAll $user");
        // dd($statements);
        $statements_bonds   = \DB::select("EXEC procStatementDetailsBonds $user");
        $bonds_debit_total  = collect(\DB::select("Exec procStatementDetailsBonds $user"))->sum('Debit');
        $bonds_credit_total = collect(\DB::select("Exec procStatementDetailsBonds $user"))->sum('Credit');

        $statements_tbills   = \DB::select("EXEC procStatementDetailsTBills $user");
        $tbills_debit_total  = collect(\DB::select("Exec procStatementDetailsTBills $user"))->sum('Debit');
        $tbills_credit_total = collect(\DB::select("Exec procStatementDetailsTBills $user"))->sum('Credit');

        $user_transactions = TradeData::where('InputterID', $user)->get();
        // dd($user_transactions);
        $gl_id = auth()->user()->gls->where('AccountTypeID', 1)->first()->GLRef;
        // dd($gl_id);
        $gls = Transaction::where('GLID', $gl_id)->first();
        if (!empty($gls)) {
            $trans           = \DB::select("EXEC procViewBalances $gls->GLID");
            $statements_cash = \DB::select("EXEC procStatementDetails " . (int) $gls->GLID);
            // dd($statements_cash);
            $cash_credit_total = collect(\DB::select("EXEC procStatementDetails $gls->GLID"))->sum('Credit');
            $cash_debit_total  = collect(\DB::select("EXEC procStatementDetails $gls->GLID"))->sum('Debit');
        }
        $cash_deposits = CashEntry::where('PostingTypeID', 1)
            ->where('CustomerID', auth()->user()->id)
            ->where('cpay_ref', '<>', null)
            ->get();

        $gl_balance = number_format(\DB::table('tblGL')->select('ClearedBalance')
                ->where('CustomerID', auth()->user()->id)
                ->where('AccountTypeID', 1)
                ->first()->ClearedBalance, 2);

        return view('transactions.showDetails', compact('gl_balance', 'user_transactions', 'cash_deposits', 'statements_cash', 'statements_bonds', 'statements_tbills', 'bonds_credit_total', 'bonds_debit_total', 'tbills_credit_total', 'tbills_debit_total', 'cash_credit_total', 'cash_debit_total'));
    }

    public function showDetails()
    {
        $statements = \DB::select("EXEC procViewBalancesAll");

        $statements_bonds  = \DB::select("EXEC procStatementDetailsBonds $user");
        $statements_tbills = \DB::select("EXEC procStatementDetailsTBills $user");

        $gl_balance = number_format(\DB::table('tblGL')->select('ClearedBalance')
                ->where('CustomerID', auth()->user()->id)
                ->where('AccountTypeID', 1)
                ->first()->ClearedBalance, 2);

        return view('transactions.showdetails', compact('statements', 'statements_bonds', 'gl_balance', 'statements_tbills'));
    }

    public function show($id)
    {
        $gls = Transaction::where('GLID', $id)->first();
        if (!empty($gls)) {
            $trans = \DB::select("EXEC procViewBalances $gls->GLID");
        }

        $gls  = Transaction::where('GLID', $id)->first();
        $user = auth()->user()->id;
        if (!empty($gls)) {
            $statements = \DB::select("EXEC procStatementDetails $gls->GLID");

            // dd($statements);
        }

        $revs = \DB::select("EXEC procReversals");

        return view('transactions.show', compact('trans', 'details', 'statements', 'revs'));
    }

    public function multipost()
    {
        $gls       = \TradefiUBA\GL::all();
        $all_staff = \TradefiUBA\User::where('admin', '<>', 1);
        $accounts  = collect(\DB::select("EXEC ProcAccountNames"));
        // dd($accounts);
        $revs = \DB::select("EXEC procReversals");
        return view('transactions.multipost', compact('gls', 'accounts', 'all_staff', 'revs'));
    }

    public function multipost_store(Request $request)
    {
        $user = \Auth::user();
        // dd($request->all());

        $sum_debit  = '0';
        $sum_credit = '0';

        foreach ($request->type as $key => $type) {

            if ($type == '3') {
                $sum_debit += $request->amount[$key];
            } elseif ($type == '4') {
                $sum_credit += $request->amount[$key];
            }

        }

        // dd($sum_credit.' = '.$sum_debit);

        if ($sum_debit != $sum_credit) {
            return redirect()->back()->withInput()->with('error', 'Debit amount is not equal to credit amount. Please check the input amounts and try again.');
        } else {

            foreach ($request->type as $key => $type) {
                // dd($request->amount[$key]);
                $row                    = new Transaction;
                $row->TransactionTypeID = $type;
                $row->Amount            = $request->amount[$key];
                $row->GLID              = $request->account[$key];
                $row->PostDate          = $request->post_date[$key];
                $row->ValueDate         = $request->value_date[$key];
                $row->Narration         = $request->narration[$key] . ' - REVERSAL';
                // $row->BankSlipNo        = $request->slip_no[$key];
                // $row->StaffID         = $request->staff[$key];
                $row->InputterID      = $user->id;
                $row->TransactionCode = 'Deposit' . uniqid();
                // $row->CurrencyID      = '1';
                $row->PostingTypeID = '1';
                $row->save();

            }
            return redirect()->back()->with('success', 'Transactions posted successfully.');
        }
    }

}
