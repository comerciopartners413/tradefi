<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\GL;
use TradefiUBA\BankDetail;
use TradefiUBA\Mail\UserActivation;
// use TradefiUBA\Mail\WelcomeEmail;
use TradefiUBA\Mail\UserRegistration;
use TradefiUBA\User;
use TradefiUBA\UserPending;
use TradefiUBA\BankDetailsPending;
use TradefiUBA\ProfilePending;
use TradefiUBA\Role;
use TradefiUBA\Company;
use TradefiUBA\Rules\PreventFutureDate;
use TradefiUBA\Profile;
use DB, Image;
use Illuminate\Http\Request;
use Mail;
use Validator;
use TradefiUBA\Config;
use Excel;
use Notification;
use TradefiUBA\Notifications\UserOnboarded;
use TradefiUBA\Mail\UserOnboarded as UserOnboardedMail;
use Pusher\PushNotifications\PushNotifications as PN;

use TradefiUBA\Notifications\StaffInvitation;

class UserController extends Controller
{

    public function index()
    {

    }

    public function create()
    {}

    public function roles()
    {
        $roles = \DB::table('roles')->get();
        $users = User::all();
        return view('admin.users.roles', compact('roles', 'users'));
    }

    public function post_roles(Request $request)
    {
        $user = User::find($request->user_id);
        $user->save(['role_id' => $request->role_id]);
        return redirect('/users/roles');
    }

    public function check_trading_pin(Request $request)
    {
        $pin = decrypt(auth()->user()->trading_pin);
        // return response()->json($request->Pin);
        if ($request->Pin == $pin) {
            return response()->json(['message' => 'Pin OK'])->setStatusCode(200, 'OK');
        } else {
            return response()->json(['message' => 'Incorrect Pin'])->setStatusCode(500, 'Incorrect Pin');
        }
        // return response()->json($pin);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'BankID'         => '',
            'username'       => 'required|alpha_dash|unique:users',
            'phone'          => 'required|unique:profiles|max:15',
            'address'        => '',
            'email'          => 'required|email|unique:users',
            'password'       => 'required|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|
               confirmed',
            'account_number' => '',
            'bvn'            => 'required|unique:bank_details|min:11|max:11',
            'branch'         => '',
            'moi'            => '',
            'dob'            => ['required', new PreventFutureDate],

            'avatar'         => 'nullable|max:5048|mimes:jpeg,png,jpg',
            'identification' => 'nullable|mimes:jpeg,png,jpg,pdf|max:5048',
            'utility_bill'   => 'nullable|mimes:jpeg,png,jpg,pdf|max:5048',

            // 'phone'    => 'required|numeric|max:11',
        ], [
            'avatar.required' => 'Photograph is required',
            'BankID.required' => 'Choosing a bank is required',
            'bvn.required'    => 'BVN field is required',
            'bvn.max'         => 'BVN should be 11 characters',
            'moi.required'    => 'Choose your means of Identification',
            'password.regex'  => 'Password must contain an uppercase, a lowercase, a special character and a numeric value',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors())->setStatusCode(500, 'Internal Server Error');
        }

        try {

            DB::beginTransaction();
            #
            $now  = time();

            $company = Company::where('name', 'uba')->first();
            $role = Role::where('name', 'customer')->first();
            $user = new User([
                'email'             => $request->email,
                'username'          => $request->username,
                'password'          => bcrypt($request->password),
                'confirmation_code' => base64_encode(str_random(50)),
                'moi'               => $request->moi,
                'company_id' => $company->id,
                'cash_account' => random_digits(10)
            ]);

            $user->trading_pin = $user->generatePin();
            #
            $user->save();

            $user->roles()->attach($role->id);

            $user->profile()->create([
                'firstname'          => $request->firstname,
                'lastname'           => $request->lastname,
                'address'            => $request->address,
                'phone'              => $request->phone,
                'dob'                => $request->dob,
                'kin_fullname'       => $request->kin_fullname,
                'kin_relationship'   => $request->kin_relationship,
                'kin_address'        => $request->kin_address,
                'kin_phone'          => $request->kin_phone,
                'trading_experience' => $request->trading_experience,
                'income_bracket'     => $request->income_bracket,

            ]);
            // Cash GL Account
            $gl = new GL([
                'CustomerID'    => $user->id,
                'Description'   => 'Cash Account',
                'AccountTypeID' => 1,
                'CurrencyID'    => 1,
                'BranchID'      => 1,
                'SerialNo'      => count($user->profile->gls) + 1,
            ]);

            $gl->save();

            // BANKDETAILS
            // $profile = $user->profile;
            $user->profile->bank_detail()->create([
                'bank_id'        => $request->BankID,
                'branch'         => $request->branch,
                'account_number' => $request->account_number,
                'bvn'            => trim($request->bvn),
            ]);

            // avatar upload
            if ($request->has('avatar') && !is_null($request->file('avatar'))) {
                $file = $request->file('avatar');
                $path = 'avatar';

                $filename = $now . '-' . $user->username . '.' . $file->getClientOriginalExtension();
                $user->update(['avatar' => $filename]);
                // $file->storeAs('public/avatar', $now . '-' . $file->getClientOriginalName());
                Image::make($file)->orientate()->sharpen(15)->fit(600)->save(storage_path('app/public/avatar/') . $filename);
            }

            if ($request->has('identification') && !is_null($request->file('identification'))) {
                $file = $request->file('identification');
                $path = 'identification';
                // $image = \Image::make($file);

                $filename = $now . '-' . $user->username . '-identification-' . $file->getClientOriginalName();
                $user->update(['identification' => $filename]);
                $file->storeAs('public/identification', $filename);
            }

            if ($request->has('utility_bill') && !is_null($request->file('utility_bill'))) {
                $file = $request->file('utility_bill');
                $path = 'utility_bill';
                // $image = \Image::make($file);

                $filename = $now . '-' . $user->username . '-utility_bill-' . $file->getClientOriginalName();
                $user->update(['utility_bill' => $filename]);
                $file->storeAs('public/utility_bill', $filename);
            }

            Mail::to($user->email)->send(new UserActivation($user));
            // Mail::to($user->email)->send(new WelcomeEmail($user));
            // $admins = User::where('admin', 1)->get();
            // Notification::send($admins, new UserOnboarded);
            if (\App::environment('local')) {
                // change to anything P.S am using Mailtrap
                Mail::to('riliwan.rabo@gmail.com')->send(new UserOnboardedMail($user));
            } else {
                Mail::to('onboarding@tradefi.ng')->send(new UserOnboardedMail($user));
            }
            DB::commit();
            return response()->json([
                'message' => 'Registration was successful',
            ])->setStatusCode(200, 'OK');

        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Something went wrong. Please try again',
            ])->setStatusCode(500, 'Oops');
        }
        // Send Welcome and Activation Mail

        return response()->json([
            'message' => 'Registration was successful',
        ])->setStatusCode(200, 'OK');
    }

    public function show($id)
    {}

    public function edit($id)
    {}

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username'       => 'unique:users|alpha_dash',
            'phone'          => 'unique:profiles',
            'address'        => '',
            'dob'            => '',
            'email'          => 'email|unique:users',
            'password'       => 'confirmed',
            'account_number' => '',
            'bvn'            => 'unique:bank_details|max:11',
            'avatar'         => 'image|mimes:jpeg,png,jpg|max:2048',
            'identification' => 'mimes:jpeg,png,jpg,pdf|max:2048',
            'utility_bill'   => 'mimes:jpeg,png,jpg,pdf|max:2048',

            // 'phone'    => 'required|numeric|max:11',
        ], [
            'moi.required' => 'Choose your means of Identification',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors())->setStatusCode(500, 'Internal Server Error');
        }
        $user = User::find($id);
        if ($request->has('identification')) {
            $file = $request->file('identification');
            $path = $file->hashName('identification');
            // $image = \Image::make($file);
            $user->update(['identification' => $path]);
            \Storage::disk('public')->put($path, $file);
        }

        if ($request->has('utility_bill')) {
            $file = $request->file('utility_bill');
            $path = $file->hashName('utility_bill');
            // $image = \Image::make($file);
            $user->update(['utility_bill' => $path]);
            \Storage::disk('public')->put($path, $file);
        }

        return redirect('/profile')->with('success', 'Documents were updated successfully');
    }

    public function verify($code)
    {
        if (!$code) {
            // throw new InvalidConfirmationCodeException;
            return redirect('/login')->with('danger', 'Code expired or not found');
        }
        $user = User::where('confirmation_code', $code)->first();
        if (!$user) {
            // throw new InvalidConfirmationCodeException;
            return redirect()->intended('/home')->with('danger', 'Your details was not found');
        } else {
            // update confirmed flag and nullify confirmation code
            $user->confirmed         = 1;
            $user->confirmation_code = null;

            $user->save();
            \Auth::login($user);
            return redirect()->intended('/home')->with('success', 'You have been verified successfully');

        }
    }

    public function checkAuth()
    {
        return response()->json([
            'status'     => 'false',
            'url_before' => url()->current(),
        ]);
    }

    public function get_onboarded_users()
    {

        return view('reports.user_downloader');
    }

    public function downloadExcel(Request $request, $type)
    {
        // check user role
        // if (\Entrust::can('update_cash_account')) {
            $users = User::select('users.id', \DB::raw("CONCAT(firstname,' ',lastname) as Name"), 'email', 'cash_account', 'securities_account')->
                join('profiles', 'users.id', '=', 'profiles.user_id')->get();

            if (count($users) <= 0) {
                return redirect('/download-users')->with('error', 'No Users onboarded today');
            }
            // TODO: change naming convention
            $data = json_decode(json_encode($users), true);
            $ex   = Excel::create(str_replace('-', '', 'TradeFIUsers' . Config::first()->TradeDate), function ($excel) use ($data) {
                $excel->sheet('Onboarded Users', function ($sheet) use ($data) {
                    $sheet->fromArray($data);
                });
            })->download($type);
        // } else {
        //     return back()->with('info', 'You do not have permissions to view this page');
        // }

    }

    public function kyc(Request $request)
    {
        $user = User::findorFail($request->id);

        if (\Entrust::can('update_cash_account')) {
            $user->update(['kyc_flag' => 1]);
            return response()->json('kyc updated', 200);
        } else {
            return response()->json('You don\'t have permission', 500);
        }

    }

    public function sec_account(Request $request)
    {
        if (\Entrust::hasRole(['ops_authorizer', 'ops_initiator', 'super_admin'])) {
            $user = User::findorFail($request->id);
            if (!is_null($user->securities_account)) {
                $user->update(['securities_account_flag' => 1]);
                return response()->json('securities account updated', 200);
            } else {
                return response()->json('securities account is empty', 500);
            }
        } else {
            return response()->json('You don\'t have permisions', 500);
        }

    }

    public function cash_account(Request $request)
    {
        if (\Entrust::hasRole(['ops_authorizer', 'ops_initiator', 'super_admin'])) {
            $user = User::findorFail($request->id);

            if (!is_null($user->cash_account)) {
                $user->update(['cash_account_flag' => 1]);
                return response()->json('cash account updated', 200);
            } else {
                return response()->json('cash account is empty', 500);
            }
        } else {
            return response()->json('You don\'t have permisions', 500);
        }
    }

    public function update_cash_account_field(Request $request)
    {
        $user = User::findorFail($request->id);
        if ($user->update(['cash_account' => $request->cash_account])) {
            return response()->json('Cash Account updated', 200);
        } else {
            return response()->json('Cash Account Updated', 200);
        }
    }

    public function update_sec_account_field(Request $request)
    {
        $user = User::findorFail($request->id);
        if ($user->update(['securities_account' => $request->securities_account])) {
            return response()->json('Securities Account updated', 200);
        } else {
            return response()->json('Securities Account Updated', 200);
        }
    }

    public function approval_list(Request $request)
    {
        $pending_updates             = UserPending::where('ApprovedBy', null)->get();
        $pending_profile_updates     = ProfilePending::where('ApprovedBy', null)->get();
        $pending_bank_detail_updates = BankDetailsPending::where('ApprovedBy', null)->get();
        // dd($pending_updates);
        return view('admin.users.pending', compact('pending_updates', 'pending_profile_updates', 'pending_bank_detail_updates'));
    }

    public function approval_show2($id)
    {
        // USERS
        if (\Entrust::hasRole(['ops_authorizer', 'super_admin'])) {

            $current_record = User::find($id);
            $user           = User::where('pending', '<>', '')
                ->where('id', $id)
                ->first();

            $diff_users = collect(json_decode($user->pending)->users)->diff(collect($current_record));
            // dd(($current_record));
            $comparison_users = array();
            foreach ($diff_users->all() as $key => $value) {
                array_push($comparison_users, [
                    'field' => $key,
                    'old'   => User::find($id)->$key,
                    'new'   => $value,
                ]);
            }

            $comparison_users = collect($comparison_users);
            // dd($comparison_users);
            // Profiles
            $current_profile_record = Profile::find($current_record->profile->id);

            // $current_record = Profile::find($current_record->profile->id);
            // dd($current_record);

            $diff_profiles = collect(json_decode($user->pending)->profiles)->diff(collect($current_profile_record));
            // dd($diff_profiles);
            $comparison_profiles = array();
            foreach ($diff_profiles->all() as $key => $value) {
                array_push($comparison_profiles, [
                    'field' => $key,
                    'old'   => Profile::find($current_record->profile->id)->$key,
                    'new'   => $value,
                ]);
            }

            $comparison_profiles = collect($comparison_profiles);

            // dd(User::find($id)->profile->id);

            $banking_details = BankDetail::where('pending', '<>', null)
                ->where('profile_id', User::find($id)->first()->profile->id)
                ->first();

            // dd($banking_details);

            return view('admin.users.pending_show', compact('comparison_users', 'comparison_profiles', 'banking_details', 'current_record'));
        } else {
            return back()->with('danger', 'You don\'t have permissions');
        }
    }

    public function approval_show($id)
    {
        // $user         = auth()->user();
        $profile              = User::find($id)->profile;
        $bank_detail          = BankDetail::where('profile_id', $profile->id)->first();
        $pending              = UserPending::where('user_id', $id)->first();
        $profile_pending      = ProfilePending::where('user_id', $id)->first();
        $user                 = User::find($pending->user->id);
        $pending2             = UserPending::where('id', $id)->get();
        $bank_details_pending = BankDetailsPending::where('profile_id', $profile->id)->first();
        return view('admin.users.pending_show', compact('pending', 'profile_pending', 'bank_details_pending', 'bank_detail', 'user'));
    }

    public function approval_post2(Request $request, $id)
    {
        $current_user_record = User::find($id);
        // dd($current_user_record);
        $current_profile_record = Profile::find($current_user_record->profile->id);
        // dd($current_profile_record);
        $user = User::where('pending', '<>', '')
            ->where('id', $id)
            ->first();
        // dd();
        $users_record_to_update    = collect(json_decode($user->pending)->users)->toArray();
        $profiles_record_to_update = collect(json_decode($user->pending)->profiles)->toArray();

        $current_user_record->update($users_record_to_update);
        $current_profile_record->update($profiles_record_to_update);

        $current_user_record->update(['pending' => '', 'pending_avatar' => '']);

        return redirect('/users/approve')->with('success', 'Updated');

        // $diff_users = collect(json_decode($user->pending)->users)->diff(collect($current_record));

    }

    public function approval_post(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();

            $pending   = UserPending::where('id', $id)->get(['id', 'username', 'email', 'avatar', 'user_id', 'moi', 'identification', 'utility_bill'])->first();
            $user_data = $pending->replicate(['user_id', 'ApprovedBy', 'deleted_at']);
            // Any extra columns?
            $pending->ApprovedBy = $user->id;
            $pending->save();
            // Fetch only the attributes
            $user_arr = $user_data->getattributes();
            // Copy & save to FCYTrade
            // $user_ = Staff::create($user_arr);
            $user_ = User::find($pending->user_id);
            // dd($user_arr);
            $user_->update($user_arr);
            // Soft delete from Pending
            $pending->delete();

            // profile update
            $profile_pending = ProfilePending::where('user_id', $pending->user_id)->first();
            // dd($profile_pending);
            $profile_data = $profile_pending->replicate(['user_id', 'ApprovedBy', 'deleted_at']);
            // Any extra columns?
            $profile_pending->ApprovedBy = $user->id;
            $profile_pending->save();
            // Fetch only the attributes
            $profile_arr = $profile_data->getattributes();
            // Copy & save to FCYTrade
            // $user_ = Staff::create($profile_arr);
            $profile = Profile::where('user_id', $profile_pending->user_id)->first();
            // dd($profile_arr);
            $profile->update($profile_arr);
            // Soft delete from Pending
            $profile_pending->delete();

            DB::commit();

            $pushNotifications = new PN([
                'instanceId' => env('PUSHER_PN_INSTANCE_ID'),
                'secretKey'  => env('PUSHER_PN_SECRET_KEY'),
            ]);

            // TODO : return full user profile and bank details data
            $bank_detail = $profile->bank_detail;
            // $profile_data = [

            // ];
            $publishResponse = $pushNotifications->publish(['private.' . $user_->id],
                array("fcm" => array("notification" => array(
                    "title" => "Profile Update",
                    "body"  => 'Your Profile update was approved',
                ),
                    "data"                              => [
                        'type'               => 'profile',
                        'id'                 => $profile->id,
                        'user_id'            => $profile->user_id,
                        'firstname'          => $profile->firstname,
                        'lastname'           => $profile->lastname,
                        'fullname'           => $profile->fullname,
                        'username'           => $profile->user->username,
                        'avatar'             => env('app_url') . '/storage/avatar/' . $profile->user->avatar,
                        'address'            => $profile->address,
                        'gender'             => $profile->gender,
                        'dob'                => $profile->dob,
                        'email'              => $profile->user->email,
                        'phone'              => $profile->phone,
                        'kin_address'        => $profile->kin_address,
                        'kin_fullname'       => $profile->kin_fullname,
                        'kin_relationship'   => $profile->kin_relationship,
                        'kin_phone'          => $profile->kin_phone,
                        'is_activated'       => (boolean) $profile->user->ActivatedFlag,
                        'changed_pin'        => (boolean) $profile->user->changed_pin,
                        'trading_experience' => $profile->trading_experience,
                        'income_bracket'     => $profile->income_bracket,
                        'bvn'                => $profile->user->profile->bank_detail->first()->bvn ?? '',
                        'book_balance'       => (string) $profile->user->gls->where('AccountTypeID', 1)->first()->BookBalance ?? '',
                        'cleared_balance'    => (string) $profile->user->gls->where('AccountTypeID', 1)->first()->ClearedBalance ?? '',
                        'bank_id'            => $profile->user->profile->bank_detail->first()->bank->id ?? '',
                        'bank_name'          => $profile->user->profile->bank_detail->first()->bank->name ?? '',
                    ]),
                ));

            return redirect('users/approve')->with('success', 'Profile changes approved successfully');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('users/approve')->with('error', 'There was a problem approving the changes.');
        }
    }

    public function reject(Request $request, $id)
    {

        $profile             = Profile::where('user_id', $id)->first();
        $pending             = UserPending::find($id)->first();
        $pending->ApprovedBy = '0';
        $pending->deleted_at = \Carbon\Carbon::now();
        $pending->save();
        // dd($pending);
        $pending2             = ProfilePending::where('user_id', $pending->user_id)->first();
        $pending2->ApprovedBy = '0';
        $pending2->deleted_at = \Carbon\Carbon::now();
        $pending2->save();

        return redirect('users/approve')->with('success', 'Profile changes were rejected successfully');
    }

    public function create_admin(Request $request)
    {
        // dd($request->role);
        $user = new User;
        try {
            DB::beginTransaction();
            
            $code = base64_encode(str_random(50));
            $password = password_generator(8);

            $username = $request->firstname . '.' . $request->lastname;

            $check_user = User::where('username', $request->firstname . '.' . $request->lastname)->orWhere('email', $request->email)->first();

            if($check_user && $check_user->username == $username){
              return redirect()->back()->with('error', 'The username "'.$username.'" is already taken.');
            } elseif($check_user && $check_user->email == $request->email) {
              return redirect()->back()->with('error', 'The email "'.$request->email.'" is already taken.');
            }

            $user = new User([
                'email'             => $request->email,
                'username'          => $username,
                // 'password'          => bcrypt($request->password),
                'confirmation_code' => $code,
                'admin'             => 1,
                'password' => bcrypt($password), //bcrypt(strtolower(substr($code, 0, 5))),
                'trading_pin' => '1234',
                'confirmed' => true,
                'ActivatedFlag' => true,
                'changed_pin' => true,
            ]);

            if (auth()->user()->company_id == '1') {
              $user->company_id = $request->company_id ?? '1';
            } else {
              $user->company_id = '2';
            }
            
            $user->trading_pin = $user->generatePin();
            #
            $user->save();
            $user->profile()->create([
                'firstname' => $request->firstname,
                'lastname'  => $request->lastname,
                'dob'       => '1960-10-01',
                'phone'     => (int) mt_rand(900000000, 1234567890) . '0',
            ]);
            // Cash GL Account
            $gl = new GL([
                'CustomerID'    => $user->id,
                'Description'   => 'Cash Account',
                'AccountTypeID' => 1,
                'CurrencyID'    => 1,
                'BranchID'      => 1,
                'SerialNo'      => count($user->profile->gls) + 1,
            ]);

            $gl->save();
            $role = $request->role;

            $user->attachRoles($role);

            if (!empty($request->email)) {
              Notification::send($user, new StaffInvitation($password));
            }

            DB::commit();

            return redirect()->back()->with('success', 'User was created successfully');

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->with('error', 'User was not created');
        }
    }

    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return redirect('/admin/users/create')->with('success', 'User was destroyed');
    }
}
