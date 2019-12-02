<?php

namespace TradefiUBA\Http\Controllers\Admin;

use TradefiUBA\Http\Controllers\Controller;
use TradefiUBA\Macro;
use Illuminate\Http\Request;

class MacroController extends Controller
{
    public function index()
    {
        $macros = Macro::all();
        return view('admin.macros.index', compact('macros'));
    }
    public function update(Request $request, $id)
    {
        $macro = Macro::find($id);
        if ($macro->update($request->all())) {
            return response()->json('Macro was added successfully');
        }
    }

    public function save(Request $request)
    {
        $macro = Macro::find($request->id);
        if ($macro->update($request->all())) {
            return response()->json('Macro data was updated successfuly');
        }
    }

}
