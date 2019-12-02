<?php

namespace TradefiUBA\Console\Commands;

use Illuminate\Console\Command;
use Pusher\PushNotifications\PushNotifications as PN;

class TradeReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trade:remind {period?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify clients of trade start time and end time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $period = $this->argument('period');

        // push notif to mobile
        $pushNotifications = new PN([
            'instanceId' => env('PUSHER_PN_INSTANCE_ID'),
            'secretKey'  => env('PUSHER_PN_SECRET_KEY'),
        ]);

        if ($period == 'fiveMinsToStart') {
            $pushNotifications->publish(['public'],
                array("fcm" => array("notification" => array(
                    "title" => "Alert",
                    "body"  => "Market will open in 5 mins",
                ),
                    "data"                              => [
                        'type' => 'general',
                    ]),
                ));
        }
    }
}
