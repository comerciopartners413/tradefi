<?php

namespace TradefiUBA\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserOnboarded extends Notification
{
    use Queueable;

    // public $user;
    public function __construct()
    {
        // $this->user = $user;
    }

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
            ->greeting('Hello')
            ->subject('User Onboarded')
            ->line('A new user')
            ->action('View User', url('/admin/users'))
            ->line('Cheers');
    }

}
