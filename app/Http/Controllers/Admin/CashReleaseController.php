<?php

namespace TradefiUBA\Http\Controllers\Admin;

use Illuminate\Http\Request;
use TradefiUBA\Http\Controllers\Controller;
use TradefiUBA\CashRelease;
use TradefiUBA\Security;
use TradefiUBA\Notifications\CashReleaseNotification;
use DB;
class CashReleaseController extends Controller
{
    public function get_list()
    {
        $cash_payment = CashRelease::where('PaidFlag', 0)->get();

        return view('reports.cash_payment', compact('cash_payment'));
    }

    public function post_list(Request $request)
    {
        $ref = CashRelease::find($request->CashReleaseRef);
        // dd($ref->AmountPayable);
        DB::statement("
            EXEC procPostCashRelease $ref->CashReleaseRef
        ");

        // not looping for now
        $user     = $ref->user;
        $amount   = $ref->AmountPayable;
        $maturity = Security::find($ref->SecurityID)->first()->Description;
        // $user->notify(new CashReleaseNotification($user, $amount, $maturity));
        return redirect('/admin/cash-release')->with('success', 'Cash Paid successful');
    }
}
