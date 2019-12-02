<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Bank;
use TradefiUBA\Custodian;
use TradefiUBA\Gender;
use TradefiUBA\Lga;
use TradefiUBA\User;
use File;
use Image;
use Carbon\Carbon;
use TradefiUBA\UserPending;
use TradefiUBA\ProfilePending;
use TradefiUBA\BankDetailsPending;
use TradefiUBA\Nationality;
use TradefiUBA\Profile;
use TradefiUBA\State;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ProfileController extends Controller
{
    public function index()
    {
        $profile       = auth()->user()->profile;
        $nationalities = Nationality::orderBy('name')->get();
        $states        = State::orderBy('name')->get();
        $lgas          = Lga::orderBy('name')->get();
        $genders       = Gender::orderBy('Gender')->get();
        $bank_detail   = $profile->bank_detail;
        // dd($bank_detail);
        if ($bank_detail == null) {
            $bank_detail = $profile->bank_detail;
        }
        // dd($bank_detail);
        $custodians       = Custodian::all();
        $banks            = Bank::all()->sortBy('name');
        $tbills_purchased = \DB::table('tblTradeData')
            ->where('TransactionTypeID', 1)
            ->join('tblSecurity', 'tblTradeData.SecurityID', '=', 'tblSecurity.SecurityRef')
            ->where('ProductID', 2)
            ->where('tblTradeData.InputterID', $profile->id)
            ->get();
        $tbills_sold = \DB::table('tblTradeData')
            ->where('TransactionTypeID', 2)
            ->join('tblSecurity', 'tblTradeData.SecurityID', '=', 'tblSecurity.SecurityRef')
            ->where('ProductID', 2)
            ->where('tblTradeData.InputterID', $profile->id)
            ->get();

        $bonds_purchased = \DB::table('tblTradeData')
            ->where('TransactionTypeID', 1)
            ->join('tblSecurity', 'tblTradeData.SecurityID', '=', 'tblSecurity.SecurityRef')
            ->where('ProductID', 1)
            ->where('tblTradeData.InputterID', $profile->id)
            ->get();
        $bonds_sold = \DB::table('tblTradeData')
            ->where('TransactionTypeID', 1)
            ->join('tblSecurity', 'tblTradeData.SecurityID', '=', 'tblSecurity.SecurityRef')
            ->where('ProductID', 1)
            ->where('tblTradeData.InputterID', $profile->id)
            ->get();
        $user_activity = Activity::where('causer_id', auth()->user()->id)
            ->latest()
            ->get();
        $ticket_activity = Activity::where('subject_type', 'TradefiUBA\Ticket')
            ->where('subject_id', auth()->user()->id)
            ->latest()
            ->get();
        // dd($user_activity);

        return view('profiles.index', compact('profile', 'states', 'genders', 'nationalities', 'lgas', 'banks', 'bank_detail', 'custodians', 'tbills_purchased', 'tbills_sold', 'bonds_purchased', 'bonds_sold', 'user_activity', 'ticket_activity'));
    }

    // get user
    public function getUser(Request $request)
    {

        return view('user.profile.index', [
            'user' => User::where('username', $request->user)->first(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update2(Request $request, $id)
    {
        $profile   = Profile::find($id);
        $user      = $profile->user;
        $validator = \Validator::make($request->all(), [
            'username'       => 'required',
            'phone'          => 'required',
            'address'        => '',
            'dob'            => '',
            'email'          => 'email|required',
            'password'       => 'confirmed',
            'account_number' => '',
            // 'bvn'            => 'unique:bank_details|max:11',
            'avatar'         => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->with('success', 'Profile not updated');
        }

        $pending_avatar = null;

        if ($request->has('avatar')) {
            $file = $request->file('avatar');

            $path    = $file->hashName('avatar');
            $width   = $request->width;
            $x_coord = $request->x_coord;
            $y_coord = $request->y_coord;
            $image   = \Image::make($file);
            // dd($width);
            // dd($real_width / 0.397012);
            $image->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->crop(150, 150, (int) abs($x_coord), (int) abs($y_coord));

            $user->pending_avatar = $path;

            $pending_avatar = $path;
            \Storage::disk('public')->put($path, (string) $image->encode());

        }

        $profile->user->pending = json_encode([
            'users'    => (collect(['email' => $request->email, 'avatar' => $pending_avatar, 'username' => $request->username])->intersectByKeys(User::find(auth()->user()->id)->getAttributes()))->all(),
            'profiles' => (collect($request->all())->intersectByKeys(Profile::find(auth()->user()->profile->id)->getAttributes()))->all(),
        ]);
        $user->save();

        if ($profile) {
            if ($request
                // $profile->update($request->except(['username', 'email', 'avatar', 'width', 'height', 'x_coord', 'y_coord']))
                // && $profile->user->update($request->only(['username', 'email']))
            ) {
                return redirect('/profile')->with('success', 'Profile will be updated after approval');
            } else {
                return back()->withInput();
            }

        }
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $validator = \Validator::make($request->all(), [
            'username'       => 'required',
            'phone'          => 'required',
            'address'        => '',
            'dob'            => '',
            'email'          => 'email|required',
            'password'       => 'confirmed',
            'account_number' => '',
            // 'bvn'            => 'unique:bank_details|max:11',
            'avatar'         => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors())->with('error', 'Profile not updated');
        }
        $count = UserPending::where('user_id', auth()->user()->id)->get();
        if ($count->count() > 0) {
            return redirect('/profile')->with('error', 'You have a pending update awaiting approval');
        }

        try {
            \DB::beginTransaction();
            // users table
            $profile               = Profile::find($id);
            $user                  = $profile->user;
            $user_pending          = new UserPending;
            $user_pending->user_id = $user->id;
            $now                   = time();
            // avatar

            $user_pending->fill($request->only(['email', 'username', 'password', 'moi']));
            if ($request->has('avatar') && !is_null($request->file('avatar'))) {

                $file                 = $request->file('avatar');
                $path                 = 'avatar';
                $filename             = $now . '-' . auth()->user()->username . '.' . $file->getClientOriginalExtension();
                $user_pending->avatar = $filename;
                // $file->storeAs('public/avatar', $now . '-' . $file->getClientOriginalName());
                Image::make($file)->orientate()->sharpen(15)->fit(600)->save(storage_path('app/public/avatar/') . $filename);
                // Image::make(asset('storage/avatar') . '/' . $now . '-_-' . $file->getClientOriginalName())->fit(300);

                // \Storage::disk('public')->put($path, $image->encode());
            } else {
                $user_pending->avatar = $user->avatar;
            }

            if ($request->has('identification') && !is_null($request->file('identification'))) {
                $file                         = $request->file('identification');
                $path                         = 'identification';
                $filename                     = $now . '-' . auth()->user()->username . '-identification-' . $file->getClientOriginalName();
                $user_pending->identification = $filename;
                $file->storeAs('public/identification', $filename);
            } else {
                $user_pending->identification = $user->identification;
            }

            if ($request->has('utility_bill') && !is_null($request->file('utility_bill'))) {
                $file                       = $request->file('utility_bill');
                $path                       = 'utility_bill';
                $filename                   = $now . '-' . auth()->user()->username . '-utility_bill-' . $file->getClientOriginalName();
                $user_pending->utility_bill = $filename;
                $file->storeAs('public/utility_bill', $filename);
            } else {
                $user_pending->utility_bill = $user->utility_bill;
            }
            $user_pending->save();

            // profiles table
            $profile_pending          = new ProfilePending;
            $profile_pending->user_id = $user->id;
            $profile_pending->fill($request->except(['avatar', 'email', 'username', 'password', 'moi', 'identification', 'utility_bill', 'width', 'height', 'x_coord', 'y_coord', 'account_number', 'bank_id']));
            $profile_pending->save();

            \DB::commit();
            return redirect('/profile')->with('success', 'Profile will be updated after approval');
        } catch (Exception $e) {
            \DB::rollback();
            return redirect('/profile')->with('error', 'Profile was not updated');
        }
    }

    public function destroy($id)
    {

    }
}
