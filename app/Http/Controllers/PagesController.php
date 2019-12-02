<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Bank;
use Illuminate\Http\Request;
use TradefiUBA\FootPrint;

class PagesController extends Controller
{
    public function index()
    {
        $banks = Bank::all()->sortBy('name');
        return view('index', compact('banks'));
    }

    public function timedout()
    {
      if (\Auth::check()) {
        // ***========
        $footprint = (object) [
          'Title' => 'Timedout'
        ];
        FootPrint::logTrail($footprint);
        // ***========

        \Auth::logout();
        // Session::flush();
        return redirect('/?timeout=true');
      }
      return redirect('/');
    }

    public function getNewToken()
    {
        return response()->json(csrf_token());
    }

    public function tradefi_guide()
    {
        return view('pages.guide');
    }

    public function tradefi_faqe()
    {
        return view('pages.faq');
    }

    public function aml()
    {
        return view('pages.aml');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function faq()
    {
        return view('pages.faq');
    }
}
