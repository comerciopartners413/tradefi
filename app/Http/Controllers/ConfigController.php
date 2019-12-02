<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Config;
use DB;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $configs = Config::all();
        return view('configs.create', compact('configs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $config = new Config($request->all());
        $this->validate($request, [
            'TradeDate' => 'required',
        ]);
        if ($config->save()) {
            return redirect()->route('configs.create')->with('success', 'Configuration was set successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Configuration failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $configs = Config::all();
        $config  = Config::where('ConfigRef', $id)->first();
        // return dd($TradeRef);
        return view('configs.edit', compact('config', 'configs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $config = \DB::table('tblConfig')->where('ConfigRef', $id);
        if ($config->update($request->except(['_token', '_method']))) {
            return redirect()->route('config.create')->with('success', 'Configuration was updated successfully');
        } else {
            return back()->withInput()->with('error', 'Configuration failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function execeod()
    {
        return view('configs.eod_confirm');
    }

    public function execeodpost()
    {
        DB::statement("
            EXEC procNewEOD
        ");

        return redirect()->route('execeod')->with('status', 'EOD was successful');
    }
}
