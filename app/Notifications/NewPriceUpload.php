<?php

namespace TradefiUBA\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Excel;
use TradefiUBA\Config;
use TradefiUBA\User;

class NewPriceUpload extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $filename)
    {
      $this->message = $message;
      $this->filename = $filename;
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
                    ->subject('New Price List Uploaded '. date('Y-m-d'))
                    ->line('Kindly find attached, a new price list uploaded by '.$this->message->sender->FullName)
                    ->attach(storage_path('app/public/message_files/'.$this->filename), [
                      // 'as' => 'UBA-Price-'.date('Y-m-d').'.xlsx',
                      // 'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ])
                    ;
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
