<?php

namespace TradefiUBA\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Excel;
use TradefiUBA\Config;
use TradefiUBA\User;

class SendAccounts extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($hash)
    {
      $this->hash = $hash;
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
    //   $users = User::whereIn('id', $this->ids)->get();
    //   $ex   = Excel::create(str_replace('-', '', 'TradeFI' . Config::first()->TradeDate), function ($excel) use ($users) {
    //     $excel->sheet('TradeFi', function ($sheet) use ($users) {
    //         // $sheet->fromArray($data);
    //         $sheet->row(1, array( 'First Name', 'Last Name' ));
    //         $count = 2;
    //         foreach ($users as $key => $user) {
    //           $sheet->row($count, array(
    //             $user->profile->firstname, $user->profile->lastname
    //           ));
    //           $count++;
    //         }
    //     });
    // });

        return (new MailMessage)
                    ->subject('Client Accounts to Be Profiled')
                    ->line('Kindly find attached.')
                    // ->action('Notification Action', url('/'))
                    ->attach(storage_path('app/public/excel/users/users-'.$this->hash.'.xlsx'), [
                      'as' => 'TradeFi-Users-'.date('Y-m-d').'.xlsx',
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
