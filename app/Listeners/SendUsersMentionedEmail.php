<?php

namespace TradefiUBA\Listeners;

use Mail;
use TradefiUBA\Events\UsersMentioned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use TradefiUBA\Mail\UserMentioned as UserMentionedEmail;

class SendUsersMentionedEmail
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
     * @param  UsersMentioned  $event
     * @return void
     */
    public function handle(UsersMentioned $event)
    {
        $users = $event->users->unique();
        if (count($users)) {
            foreach ($users as $user) {
                Mail::to($user)->queue(new UserMentionedEmail($event->topic, $event->post));
            }
        }
    }
}
