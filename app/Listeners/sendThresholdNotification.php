<?php

namespace TradefiUBA\Listeners;

use TradefiUBA\Events\ThresholdNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use TradefiUBA\Mail\ThresholdNotificationMail;

class sendThresholdNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ThresholdNotification $event)
    {
        Mail::to('trading@tradefi.ng')
            ->cc(['riliwan.rabo@gmail.com'])
            ->queue(new ThresholdNotificationMail($event->security_id, $event->quantity));
    }
}
