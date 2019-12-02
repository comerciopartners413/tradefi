<?php

namespace TradefiUBA\Http\Controllers\Admin;

use TradefiUBA\FX;
use TradefiUBA\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FXController extends Controller
{

    public function index()
    {
        $fxs = FX::all();
        return view('admin.fx.index', compact('fxs'));
    }

    public function update(Request $request, $id)
    {
        $fx = FX::find($id);
        if ($fx->update($request->all())) {
            return response()->json('FX data was updated successfuly');
        }
    }

    public function save(Request $request)
    {
        $fx = FX::find($request->id);
        if ($fx->update($request->all())) {
            return response()->json('FX data was updated successfuly');
        }
    }
}
