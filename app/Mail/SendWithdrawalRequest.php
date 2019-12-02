<?php

namespace TradefiUBA\Mail;

use TradefiUBA\CashEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWithdrawalRequest extends Mailable
{
    use Queueable, SerializesModels;
    public $withdrawals;

    public function __construct(CashEntry $withdrawals)
    {
        $this->withdrawals = $withdrawals;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Withdrawal Request')
            ->markdown('emails.withdrawals.request', [
                'withdrawals' => $this->withdrawals,
            ]);
    }
}
