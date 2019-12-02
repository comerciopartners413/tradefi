<?php

namespace TradefiUBA\Console\Commands;

use Event;
use TradefiUBA\Events\ThresholdNotification;
use Illuminate\Console\Command;

class ThresholdNotificationToStanbic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'threshold:threshold {SecurityID} {Quantity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a email notification to stanbic, informing them of a security\'s threshold';

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
        return Event::fire(new ThresholdNotification($this->argument('SecurityID'), $this->argument('Quantity')));
        // return Event::fire(new ThresholdNotification("1", "4000000000"));
    }
}
