<?php

namespace TradefiUBA\Mail;

use TradefiUBA\Ticket;
use TradefiUBA\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTicketInformation extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $ticket;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Ticket $ticket)
    {
        $this->user   = $user;
        $this->ticket = $ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.tickets.ticket_info')->with([
            'ticket_id' => $this->ticket->ticket_id,
            'status'    => $this->ticket->status,
            'details'   => $this->ticket->details,
            'firstname' => $this->user->profile->firstname,
            'lastname'  => $this->user->profile->lastname,
        ]);
    }
}
