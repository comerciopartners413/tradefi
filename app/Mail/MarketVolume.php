<?php

namespace TradefiUBA\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use TradefiUBA\User;
use TradefiUBA\Security;
class MarketVolume extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $security;
    public $quantity;
    public function __construct(User $user, Security $security, $quantity)
    {
        $this->user     = $user;
        $this->security = $security;
        $this->quantity = $quantity;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.trades.marketvolume')->with([
            'description' => $this->security->Description,
            'quantity'    => $this->quantity,
            'fullname'    => $this->user->profile->fullname,
            'email'       => $this->user->email,
            'phone'       => $this->user->profile->phone,
        ]);
    }
}
