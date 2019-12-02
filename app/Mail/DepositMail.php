<?php

namespace TradefiUBA\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use TradefiUBA\CashEntry;

class DepositMail extends Mailable
{
    use Queueable, SerializesModels;

    public $deposit;

    public function __construct(CashEntry $deposit)
    {
        $this->deposit = $deposit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.deposit', [
            'deposit' => $this->deposit,
        ]);
    }
}
