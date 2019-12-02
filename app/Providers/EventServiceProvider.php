<?php

namespace TradefiUBA\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'TradefiUBA\Events\ThresholdNotification'           => [
            'TradefiUBA\Listeners\sendThresholdNotification',
        ],
        'TradefiUBA\Events\UserPostedOnTopic'               => [
            'TradefiUBA\Listeners\SendTopicSubscribersPostEmail',
        ],
        'TradefiUBA\Events\UserSubscribedToTopic'           => [
            'TradefiUBA\Listeners\SendTopicOwnerSubscriptionCreatedEmail',
        ],
        'TradefiUBA\Events\TopicReported'                   => [
            'TradefiUBA\Listeners\SendModeratorsTopicReportedEmail',
        ],
        'TradefiUBA\Events\PostReported'                    => [
            'TradefiUBA\Listeners\SendModeratorsPostReportedEmail',
        ],
        'TradefiUBA\Events\TopicDeleted'                    => [
            'TradefiUBA\Listeners\SendTopicOwnerTopicDeletedEmail',
        ],
        'TradefiUBA\Events\PostDeleted'                     => [
            'TradefiUBA\Listeners\SendPostOwnerPostDeletedEmail',
        ],
        'TradefiUBA\Events\UserRoleModified'                => [
            'TradefiUBA\Listeners\SendUserRoleModifiedEmail',
        ],
        'TradefiUBA\Events\UsersMentioned'                  => [
            'TradefiUBA\Listeners\SendUsersMentionedEmail',
        ],
        'TradefiUBA\Events\UserHasViewedMessagesFromSender' => [
            'TradefiUBA\Listeners\UpdateReadFlagOnMessagesForGivenSender',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
