<?php

namespace TradefiUBA\Listeners;

use Mail;
use TradefiUBA\Events\UserRoleModified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use TradefiUBA\Mail\UserRoleModified as UserRoleModifiedEmail;

class SendUserRoleModifiedEmail implements ShouldQueue
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
     * @param  UserRoleModified  $event
     * @return void
     */
    public function handle(UserRoleModified $event)
    {
        Mail::to($event->user->email)->queue(new UserRoleModifiedEmail($event->old_role, $event->user));
    }
}
