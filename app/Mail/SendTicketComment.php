<?php

namespace TradefiUBA\Mail;

use TradefiUBA\TicketComment;
use TradefiUBA\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTicketComment extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, TicketComment $comment)
    {
        $this->user    = $user;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Update on Ticket ' . $this->comment->ticket->ticket_id)
            ->view('emails.tickets.ticket_comment')->with([
            'ticket_id' => $this->comment->ticket->ticket_id,
            'status'    => $this->comment->ticket->status,
            'details'   => $this->comment->ticket->details,
            'firstname' => $this->user->profile->firstname,
            'lastname'  => $this->user->profile->lastname,
        ]);
    }
}
