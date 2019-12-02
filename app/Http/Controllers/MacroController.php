<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Macro;
use TradefiUBA\User;
use Illuminate\Http\Request;

class MacroController extends Controller
{
    public function store(Request $request)
    {
        $macro = new Macro;
        if ($macro->save($request->all())) {
            return response()->json('Macro data was updated successfuly');
        }
    }

    public function save(Request $request)
    {
        $macro = Macro::find($request->id);
        if (User::tradefi_admin()) {

        } else {
            return back()->with('error', 'You don\'t have permissions');
        }
    }

}
