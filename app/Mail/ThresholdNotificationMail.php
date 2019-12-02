<?php

namespace TradefiUBA\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ThresholdNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $security_id;
    public $quantity;

    public function __construct(int $security_id, int $quantity)
    {
        $this->security_id = $security_id;
        $this->quantity    = $quantity;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.threshold', [
            'SecurityID' => $this->security_id,
            'Quantity'   => $this->quantity,
        ]);
    }
}
