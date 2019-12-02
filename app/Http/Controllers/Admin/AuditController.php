<?php

namespace TradefiUBA\Http\Controllers\Admin;

use TradefiUBA\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use TradefiUBA\Inventory;
use TradefiUBA\User;
class AuditController extends Controller
{
    public function index()
    {
        // Select all tables SQL SERVER Version
        $tables = collect(DB::select('Select TABLE_NAME FROM INFORMATION_SCHEMA.TABLES'));
        // dd($tables);
        return view('audit.index', compact('tables'));
    }

    public function store(Request $request)
    {
        $module = $request->module;
        // check module
        if ($module == 'Inventory') {
            $query = Inventory::all();
            $query = $query->transform(function ($item, $key) {
                $item->fullname      = User::find($item->InputterID)->profile->fullname ?? '-';
                $item->created_at    = \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() ?? '-';
                $item->approved_date = \Carbon\Carbon::parse($item->ApprovalDate)->toFormattedDateString() ?? '-';
                return $item;
            });
            return redirect()->route('audits.index')->with('module', $query);
        } else {
            return false;
        }

    }
}
