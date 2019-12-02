<?php

namespace TradefiUBA\Http\Controllers;

use Illuminate\Http\Request;
use TradefiUBA\FAQ;

class FaqController extends Controller
{
    public function index()
    {
        return view('faqs.index');
    }
}
