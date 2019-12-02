<?php

namespace TradefiUBA\Http\Controllers\Admin;

use Illuminate\Http\Request;
use TradefiUBA\Http\Controllers\Controller;
use TradefiUBA\CouponPayment;
use TradefiUBA\Security;
use DB;
class CouponPaymentController extends Controller
{
    public function get_list()
    {
        $coupon_payment = CouponPayment::where('PaidFlag', 0)->get();
        // $coupon_payment = collect($coupon_payment)->transform(function ($item, $key) {
        //     $item->ProductID = Security::where('Security', $item->Security)->get();
        //     return $item;
        // });
        // dd($coupon_payment);
        return view('reports.coupon_payment', compact('coupon_payment'));
    }

    public function post_list(Request $request)
    {
        $ref = CouponPayment::find($request->CouponPaymentRef);
        // dd($ref);
        DB::select("
            EXEC procPostCoupon $ref->CouponPaymentRef
        ");
        return redirect('/admin/coupon-payment')->with('success', 'Coupon Payment was successful');
    }
}
