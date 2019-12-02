<?php

namespace TradefiUBA\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TradeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $trade;
    public function __construct($trade)
    {
        $this->trade = $trade;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
      $type_id = $this->trade->TransactionTypeID;
      $product_id = \TradefiUBA\Security::find($this->trade->SecurityID)->ProductID;
      $product = \TradefiUBA\Security::find($this->trade->SecurityID)->Description;
      $price = number_format($this->trade->DirtyPrice, 2);

        return (new MailMessage)
            ->subject('Trade Successful')
            ->line('You successfully '.(($type_id == '1')? 'purchased':'sold').(($product_id == '1')? 'Bonds':'TBills').' at rate: '.$price)
            // ->action('Notification Action', url('/'))
            // ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return (
            ['data' => [
                'user'                => $this->trade->user->id,
                'transaction_type_id' => $this->trade->TransactionTypeID,
                'product_id'          => \TradefiUBA\Security::find($this->trade->SecurityID)->ProductID,
                'description'         => \TradefiUBA\Security::find($this->trade->SecurityID)->Description,
                'price'               => number_format($this->trade->DirtyPrice, 2),
            ],
            ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id'             => $this->trade->user->id,
            'transaction_type_id' => $this->trade->TransactionTypeID,
            'product_id'          => \TradefiUBA\Security::find($this->trade->SecurityID)->ProductID,
            'description'         => \TradefiUBA\Security::find($this->trade->SecurityID)->Description,
            'price'               => number_format($this->trade->DirtyPrice, 2),
        ];
    }
}
