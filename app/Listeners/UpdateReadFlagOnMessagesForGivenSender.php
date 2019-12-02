<?php

namespace TradefiUBA\Listeners;

use TradefiUBA\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use TradefiUBA\Events\UserHasViewedMessagesFromSender;

class UpdateReadFlagOnMessagesForGivenSender
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
     * @param  UserHasViewedMessagesFromSender  $event
     * @return void
     */
    public function handle(UserHasViewedMessagesFromSender $event)
    {
        foreach ($event->currentUser->receivedMessagesFromSender($event->sender) as $message) {
            $message->update([
                'read' => 1,
            ]);
            $message->save();
        }
    }
}
