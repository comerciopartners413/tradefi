<?php

namespace TradefiUBA\Notifications;

use TradefiUBA\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use TradefiUBA\Security;

class MarketVolume extends Notification
{
    use Queueable;

    public $user;
    public $security;
    public function __construct(User $user, Security $security)
    {
        $this->user     = $user;
        $this->security = $security;
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
            ->greeting('Hello Admin')
            ->subject('Insufficient Market Volume for ' . $this->security->description)
            ->line('By: ' . $this->user->profile->fullname)
            ->line('Email: ' . $this->user->email)
            ->line('Phone: ' . $this->user->profile->phone);
        // ->action('View User', url('/admin/users'))
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
