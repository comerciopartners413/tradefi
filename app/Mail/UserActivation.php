<?php

namespace TradefiUBA\Mail;

use TradefiUBA\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserActivation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.users.activation')
            ->subject('Welcome to TradeFi!')
            ->with([
                'firstname' => $this->user->profile->firstname,
                'lastname'  => $this->user->profile->lastname,
                'code'      => $this->user->confirmation_code,
            ]);
    }
}
