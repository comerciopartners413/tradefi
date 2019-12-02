<?php

namespace TradefiUBA\Listeners;

use Mail;
use TradefiUBA\Topic;
use TradefiUBA\Events\TopicDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use TradefiUBA\Mail\TopicDeleted as TopicDeletedEmail;

class SendTopicOwnerTopicDeletedEmail implements ShouldQueue
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
     * @param  TopicDeleted  $event
     * @return void
     */
    public function handle(TopicDeleted $event)
    {
        Mail::to($event->topic->user->email)->queue(new TopicDeletedEmail($event->topic));
    }
}
