<?php

namespace TradefiUBA\Http\Controllers;

use Illuminate\Http\Request;

use TradefiUBA\Http\Requests;
use Paystack;
use TradefiUBA\CashEntry;

class PaymentController extends Controller
{

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function index()
    {
        $paystack_gen = Paystack::genTranxRef();
        return view('paystack.test.index', compact('paystack_gen'));
    }
    public function redirectToGateway()
    {
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();
        // http://api.tradefi.cavidex.com/paystack/callback
        // dd($paymentDetails->status);
        if ($paymentDetails['status'] === true) {
            // begin processing
            // convert amount to Naira
            $amount     = $paymentDetails['data']['amount'];
            $commission = ($amount / 100 * 0.015);
            if ($commission > 2000) {
                $commission = 2000;
            } else {
                $commission = $commission;
            }
            $new_amount = $amount - ($commission * 100);

            $amount           = $new_amount;
            $reference        = $paymentDetails['data']['reference'];
            $status           = $paymentDetails['data']['status'];
            $transaction_id   = $paymentDetails['data']['id'];
            $transaction_date = \Carbon\Carbon::parse($paymentDetails['data']['transaction_date']);
            $cash_entry       = new CashEntry([
                'TransferTypeID'  => 2,
                'PostingTypeID'   => 1,
                'TransactionDate' => $transaction_date,
                'Amount'          => $amount / 100, //get naira from kobo
                'CustomerID'      => auth()->user()->id,
                'BankID'          => 21,
                'cpay_ref'        => $reference,
                'transaction_id'  => $transaction_id,

                'Description'     => $paymentDetails['message'],
                'Status'          => $paymentDetails['data']['gateway_response'],

            ]);

            if ($cash_entry->save()) {
                CashEntry::find($cash_entry->CashEntryRef)->update([
                    'ApprovedFlag' => true,
                    'ApproverID'   => 0,
                    'ApprovalDate' => \Carbon\Carbon::now(),

                ]);
                Notification::send(auth()->user(), new DepositNotification2($cash_entry));
            }

            return response()->json(['success' => true, 'message' => 'Deposit was successful'], 200);
        } else {
            return response()->json(['success' => false, 'message' => $paymentDetails->message], 200);
        }

    }

}
