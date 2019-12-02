<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\User;
use Illuminate\Http\Request;
use Countdown;
use Carbon\Carbon;
use TradefiUBA\FootPrint;

class SettingController extends Controller
{
    // public function get_reset_password()
    // {
    //     return view('')
    // }

    public function change_pass()
    {
      // ***========
      $footprint = (object) [
        'Title' => 'Change Password',
        'Details' => 'Viewing change password form.'
      ];
      FootPrint::logTrail($footprint);
      // ***========
      return view('change_pass');
    }

    public function reset_password(Request $request)
    {
        $current_user = auth()->user();

        // Validation Rules
        $validator = \Validator::make($request->all(), [
            'password' => 'confirmed|min:8',
        ]);

        if ($validator->fails()) {
            // return response()->json([
            //     'errors' => $validator->errors(),
            // ]);
            return back()->withInput()->with('error', 'Password must be at least 8 characters long.');
        }
        if (\Hash::check($request->old_password, $current_user->password)) {
            // password matches our records
            $current_user->password = bcrypt($request->password);
            $current_user->changed_password = true;
            
            if ($current_user->save()) {

                // ***========
                $footprint = (object) [
                  'Title' => 'Change Password',
                  'Details' => 'Password changed successfully'
                ];
                FootPrint::logTrail($footprint);
                // ***========

                return redirect('/profile')->with('success', 'Password was changed successfully');
            } else {
                return back()->withInput()->with('error', 'Something happened, and password could not be saved.');
            }
        } else {
            return back()->with('error', 'Your current password does not match');
        }
    }

    public function reset_trading_pin(Request $request)
    {
        $current_user = User::find(auth()->user()->id);
        if ($current_user->update(['trading_pin' => encrypt($request->trading_pin)])) {
            return redirect()->route('profile.index')->with('success', 'Trading Pin was changed successfully');
        }
    }

    public function change_pin()
    {
        // ***========
      $footprint = (object) [
        'Title' => 'Change Pin',
        'Details' => 'Viewing change pin form.'
      ];
      FootPrint::logTrail($footprint);
      // ***========

        return view('pin.change');
    }

    public function change_pin_post(Request $request)
    {
        $current_user = User::find(auth()->user()->id);
        $this->validate($request, [
            'trading_pin' => 'required|numeric|confirmed',
        ]);
        if ($current_user->update(['trading_pin' => encrypt($request->trading_pin), 'changed_pin' => true])) {

            // ***========
            $footprint = (object) [
              'Title' => 'Change Pin',
              'Details' => 'Pin changed successfully.'
            ];
            FootPrint::logTrail($footprint);
            // ***========

            return redirect()->route('home')->with('success', 'Trading Pin was changed successfully');
        }
    }

    public function next_trade_date()
    {
        $query = collect(\DB::select('EXEC procNextTradeDate'))->first();
        return $query->NextTradeDate;
    }

    public function countdown_timer()
    {
        $carbonated       = \Carbon\Carbon::now();
        $trade_start_time = Carbon::now()->setTimeFromTimeString("10:00:00");
        $trade_end_time   = Carbon::now()->setTimeFromTimeString("14:00:00");

        // || Carbon::now()->greaterThan($trade_end_time)) || Carbon::now()->isWeekend()
        // if ((Carbon::now() < $trade_start_time) || (Carbon::now() > $trade_end_time)) {
        $time      = Carbon::parse(collect(\DB::select('EXEC procNextTradeDate'))->first()->NextTradeDate)->setTimeFromTimeString('10:00:00');
        $countdown = Countdown::from(Carbon::now())->to($time)->get()
            ->toHuman('<b>Market will open in</b> : {days} days {hours} hours {minutes} minutes {seconds} seconds');
        return $countdown;

        // return response()->json($post_deal)->setStatusCode(500, 'Deal Was Unsuccesful. Market is Closed');
        // }
    }
}
