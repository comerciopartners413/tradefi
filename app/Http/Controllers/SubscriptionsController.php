<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\User;
use TradefiUBA\Topic;
use TradefiUBA\Subscription;
use TradefiUBA\Events\UserSubscribedToTopic;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{

    /**
     * Returns a user's subscription status, regarding a given Topic.
     * Utilized by SubscribeButtonComponent Vue component.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  TradefiUBA\Topic                $topic
     * @return Illuminate\Http\Response
     */
    public function getSubscriptionStatus(Request $request, Topic $topic)
    {
        $user         = $request->user();
        $subscription = $user->isSubscribedTo($topic);

        if ($subscription !== null) {
            // was already a subscription, send back the subscription status
            return response()->json($subscription->subscribed, 200);
        }

        // was no subscription..
        return null;
    }

    /**
     * Subscribes or unsubscribes a User from a Topic (SubscribeButtonComponent Vue component).
     *
     * @param  Illuminate\Http\Request  $request
     * @param  TradefiUBA\Topic                $topic
     * @return Illuminate\Http\Response
     */
    public function handleSubscription(Request $request, Topic $topic)
    {
        $user         = $request->user();
        $subscription = $user->isSubscribedTo($topic);
        if ($subscription !== null) {
            // subscription exists, but can be either subscribed or unsubscribed
            if ($subscription->subscribed === 0) {
                $subscription->subscribed = 1;
            } else if ($subscription->subscribed === 1) {
                $subscription->subscribed = 0;
            }
        } else {
            // wasn't subscribed
            $subscription             = new Subscription();
            $subscription->topic_id   = $topic->id;
            $subscription->user_id    = $user->id;
            $subscription->subscribed = 1;
        }
        $subscription->save();

        if ($subscription->subscribed === 1) {
            event(new UserSubscribedToTopic($topic));
        }

        return response()->json(null, 200);
    }
}
