<?php

namespace TradefiUBA\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Drivers\DriverManager;

class GenieController extends Controller
{

    public function index()
    {
        return view('genie.index');
    }
    public function handle()
    {
        // Load the driver(s) you want to use
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
        $config = [];

        $botman = app('botman');
        $botman->hears('hello', function ($bot) {

            // $bot->typesAndWaits(1);
            $bot->reply("Hi " . auth()->user()->profile->firstname);
            // $bot->startConversation(new ExampleConversation());
        });

        $botman->hears('what are {keyword}', function ($bot, $keyword) {

            // $bot->typesAndWaits(1);
            if (strtolower($keyword) == 'bonds' || strtolower($keyword) == 'bond') {
                $bot->reply(ucfirst($keyword) . " are loans made to large organizations. These include corporations, cities and national governments. A bond is a piece of a massive loan. That’s because the size of these entities requires them to borrow money from more than one source.");
            } elseif (strtolower($keyword) == 'tbills') {
                $bot->reply(ucfirst($keyword) . " are short-term bonds that mature within one year or less from their time of issuance. T-bills are sold with maturities of four, 13, 26, and 52 weeks, which are more commonly referred to as the one-, three-, six-, and 12-month T-bills, respectively.");
            }

            // $bot->startConversation(new ExampleConversation());
        });

        $botman->fallback(function ($bot) {
            $bot->reply('Sorry, I don\'t understand that commands. Here are list of commands I understand');
        });

        // Start listening
        $botman->listen();
    }
}
