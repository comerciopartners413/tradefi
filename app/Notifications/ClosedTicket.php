<?php

namespace TradefiUBA\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClosedTicket extends Notification
{
    use Queueable;
    public $ticket_;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ticket_)
    {
        $this->ticket_ = $ticket_;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Your Ticket with ID: ' . $this->ticket_->ticket_id . ' has been closed')
            // ->action('Notification Action', url('/'))
            ->line('Thank you for using TradeFI');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
