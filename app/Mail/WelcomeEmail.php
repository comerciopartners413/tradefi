<?php

namespace TradefiUBA\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeEmail extends Mailable
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
        return $this->view('emails.users.activation')->with([
            'firstname' => $this->user->profile->firstname,
            'lastname'  => $this->user->profile->lastname,
            'code'      => $this->user->confirmation_code,
        ]);
    }
}
