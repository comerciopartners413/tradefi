<?php

namespace TradefiUBA\Notifications;

use TradefiUBA\CashEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DepositNotification2 extends Notification
{
    use Queueable;

    public $cash_entry;
    public function __construct(CashEntry $cash_entry)
    {
        $this->cash_entry = $cash_entry;
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
            ->subject('Deposit Information')
            ->greeting('Hello, ' . $this->cash_entry->user->profile->fullname)
            ->line('<h2>Deposit Information</h2>')
            ->line('---------------------------------------------------------')
            ->line($this->cash_entry->Status == '000' ? '<b style="color:blue">Transaction was successful</b>' : '<b style="color:red">Transaction Failed</b>')
            ->line('----------------------------------------------------------')
            ->line('Amount : ₦' . number_format($this->cash_entry->Amount, 2))
            ->line('Transaction ID : ' . $this->cash_entry->transaction_id)
            ->line('Transaction Reference : ' . $this->cash_entry->cpay_ref)
            ->line('----------------------------------------------------------')

            ->line($this->cash_entry->Description)
            ->line('----------------------------------------------------------')
            ->action('Go to TradeFI.', 'http://tradefi.ng')
            ->line('Thank you for using our application!');
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
