<?php

namespace TradefiUBA\Http\Controllers\Admin;

use TradefiUBA\Events\TradeRoomActivated;
use TradefiUBA\Http\Controllers\Controller;
use TradefiUBA\Notifications\TradeRoomActivation;
use TradefiUBA\User;
use TradefiUBA\Role;
use Event;
use Illuminate\Http\Request;
use Pusher\PushNotifications\PushNotifications as PN;
use DB;
use Excel;
use TradefiUBA\Config;
use TradefiUBA\Company;
use TradefiUBA\FootPrint;

use Notification;
use TradefiUBA\Notifications\SendAccounts;
use TradefiUBA\Notifications\UsersProfiled;

class AdminUserController extends Controller
{
    public function index()
    {
        if (\Entrust::hasRole(['admin', 'super_admin', 'ops_initiator', 'ops_authorizer'])) {
            $users = User::where('admin', 0)
                ->where('ActivatedFlag', 0)->whereHas('profile')->get();
            $activated_users = User::where('admin', 0)
                ->where('ActivatedFlag', 1)->get();
            $roles       = \DB::table('roles')->get();
            $admin_users = User::where('admin', 1)->get();
            $companies = Company::where('id', '!=', '1')->get();
            return view('admin.users.index', compact('users', 'activated_users', 'roles', 'admin_users', 'companies'));
        } else {
            return back()->with('error', 'You don\'t have permissions');
        }
        // dd($activated_users);
        // return response()->json($users);

    }

    public function create()
    {
      $footprint = (object) [
        'Title' => 'Create Admins',
      ];
      FootPrint::logTrail($footprint);

        $users = User::where('admin', 0)
            ->where('ActivatedFlag', 0)->get();
        $activated_users = User::where('admin', 0)
            ->where('ActivatedFlag', 1)->get();
        // if (auth()->user()->company_id == '1') {
          $roles       = \DB::table('roles')->get();
          $admin_users = User::where('admin', 1)->get();
        // } else {
        //   $roles       = \DB::table('roles')->where('company_id', '2')->get();
        //   $admin_users = User::where('admin', 1)->where('company_id', '2')->get();
        // }
        
        $companies = Company::all();
        return view('admin.users.create', compact('users', 'activated_users', 'roles', 'admin_users', 'companies'));
    }

    public function create_uba()
    {
      $footprint = (object) [
        'Title' => 'Create Admins (UBA)',
      ];
      FootPrint::logTrail($footprint);

        $users = User::where('admin', 0)
            ->where('ActivatedFlag', 0)->get();
        $activated_users = User::where('admin', 0)
            ->where('ActivatedFlag', 1)->get();

        $roles       = \DB::table('roles')->where('company_id', '2')->get();
        $admin_users = User::where('admin', 1)->where('company_id', '2')->get();

        
        // $companies = Company::all();
        return view('admin.users.create_uba', compact('users', 'activated_users', 'roles', 'admin_users', 'companies'));
    }

    public function create_role(Request $request)
    {
        $role = new Role($request->all());
        if ($role->save()) {
            return redirect('users/roles')->with('success', 'Role was added');
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        $companies = Company::where('id', '!=', '1')->get();
        /* TODO: Use permissions instead, since they can create roles. */

        // if (\Entrust::hasRole(['admin', 'ops_initiator', 'ops_authorizer', 'admin_authorizer', 'super_admin'])) {
            return view('admin.users.show', compact('user', 'companies'));
        // } else {
        //     return redirect()->back()->with('error', 'You don\'t have permissions');
        // }
    }

    // activate users for trading
    public function activate(Request $request, $id)
    {
        $user = User::find($id);
        if (
            !is_null($user->securities_account)
            && !is_null($user->cash_account)
            && $user->kyc_flag == true
            && $user->securities_account_flag == true
            && $user->cash_account_flag == true
        ) {
            if (\Entrust::can('approve_traderoom')) {
                // activate user with the above $id
                if ($user->update(['ActivatedFlag' => 1])) {
                    Event::fire(new TradeRoomActivated($user));
                    $user->notify(new TradeRoomActivation($user));
                    // push notifiction to mobile
                    $pushNotifications = new PN([
                        'instanceId' => env('PUSHER_PN_INSTANCE_ID'),
                        'secretKey'  => env('PUSHER_PN_SECRET_KEY'),
                    ]);

                    $publishResponse = $pushNotifications->publish(['private.' . $user->id],
                        array("fcm" => array("notification" => array(
                            "title" => "Traderoom Activated",
                            "body"  => "Congratulations! You are ready to trade.",
                        ),
                            "data"                              => [
                                'type' => 'activation',
                            ]),
                        ));
                    return response()->json('Success')->setStatusCode(200);
                }
            } else {
                return response()->json('You don\'t have permission')->setStatusCode(500);
            }
        } else {
            return response()->json('Traderoom can\'t be activated yet because cash and securities account are not available')->setStatusCode(500);
        }

    }

    public function save_company(Request $request)
    {
      $user = User::find($request->user_id);
      if (!empty($user)) {
        $user->company_id = $request->company_id;
        $user->update();
        return $user;
      }
      return response('Invalid request', 403, []);
    }

    public function not_profiled()
    {
      // if (\Entrust::hasRole(['admin', 'super_admin', 'ops_initiator', 'ops_authorizer'])) {
        // $users = User::where('admin', 0)->where('ActivatedFlag', 0)->whereHas('profile')->orderBy('created_at', 'desc')->get();
        $company_id = Company::where('name', 'uba')->first()->id;
        $users = User::where('admin', 0)->whereHas('profile')->where('securities_account_flag', false)->where('uba_access', false)->where('company_id', $company_id)->orderBy('created_at', 'desc')->get();
        // $activated_users = User::where('admin', 0)
        //     ->where('ActivatedFlag', 1)->get();
        // $roles       = \DB::table('roles')->get();
        // $admin_users = User::where('admin', 1)->get();
        return view('admin.users.not_profiled', compact('users', 'activated_users', 'roles', 'admin_users'));
      // } else {
      //     return back()->with('error', 'You don\'t have permissions');
      // }
    }

    public function pending_accounts()
    {
      $footprint = (object) [
        'Title' => 'Pending User Accounts',
        'Details' => 'View pending users'
      ];
      FootPrint::logTrail($footprint);

        $users = User::whereHas('profile')->where('securities_account_flag', false)->where('uba_access', true)->orderBy('created_at', 'desc')->get();
        return view('admin.users.pending_accounts', compact('users', 'activated_users', 'roles', 'admin_users'));
    }

    public function profiled_accounts()
    {
      $footprint = (object) [
        'Title' => 'Profiled User Accounts',
        'Details' => 'View profiled users'
      ];
      FootPrint::logTrail($footprint);
      
        $users = User::whereHas('profile')->where('securities_account_flag', true)->orderBy('created_at', 'desc')->get();
        return view('admin.users.profiled_accounts', compact('users', 'activated_users', 'roles', 'admin_users'));
    }

    public function send_onboarded(Request $request)
    {

      try {
        DB::beginTransaction();
        $users = User::whereIn('users.id', $request->selected_ids);
        $users->update([
          'uba_access' => true
        ]);

        $users = $users->select('users.id', \DB::raw("CONCAT(firstname,' ',lastname) as Name"), 'email', 'cash_account', 'securities_account')->
        join('profiles', 'users.id', '=', 'profiles.user_id')
        // ->where('securities_account_flag', false)
        ->get();

        if (count($users) <= 0) {
          return redirect()->back()->with('error', 'No accounts to send');
        }

        $hash = uniqid();        
        $data = json_decode(json_encode($users), true);
        $ex   = Excel::create('users-' . $hash, function ($excel) use ($data) {
          $excel->sheet('Onboarded Users', function ($sheet) use ($data) {
              $sheet->fromArray($data);
          });
        })->store('xlsx', storage_path('app/public/excel/users'));


        // $hash = uniqid();
        // $ex   = Excel::create('users-' . $hash, function ($excel) use ($users) {
        //     $excel->sheet('TradeFi', function ($sheet) use ($users) {
        //         // $sheet->fromArray($data);
        //         $sheet->row(1, array( 'ID', 'First Name', 'Last Name', 'Email Address', 'Gender', 'DOB', 'Phone Number', 'Cash Account No.', 'Securities Account No.', 'Bank Name', ' Bank Account Number', 'BVN', 'Next of Kin Name', 'NextofKin Relationship', 'NextofKin Phone', 'NextofKin Address' ));//->setStyle(array( 'font' => array('bold' => true) ));
        //         $count = 2;
        //         foreach ($users->get() as $key => $user) {
        //           $sheet->row($count, array(
        //             $user->id,
        //             $user->profile->firstname ?? '',
        //             $user->profile->lastname ?? '',
        //             $user->email,
        //             $user->profile->gender ?? '',
        //             $user->profile->dob ?? '',
        //             $user->profile->phone ?? '',
        //             $user->cash_account,
        //             $user->securities_account,
        //             $user->profile->bank_detail->bank->name ?? '',
        //             $user->profile->bank_detail->account_number ?? '',
        //             $user->profile->bank_detail->bvn ?? '',
        //             $user->profile->kin_fullname ?? '',
        //             $user->profile->kin_relationship ?? '',
        //             $user->profile->kin_phone ?? '',
        //             $user->profile->kin_address ?? ''
        //           ));
        //           $count++;
        //         }
        //     });
        // })
        // ->store('xlsx', storage_path('app/public/excel/users'));
        
        // TODO: Send to UBA instead
        
        DB::commit();
        Notification::send(User::whereIn('id', ['2249', auth()->id])->get(), new SendAccounts($hash));

        //***==========
        $footprint = (object) [
          'Title' => 'Send User Accounts',
          'Details' => 'Sent '.count($users).' user accounts for profiling.'
        ];
        FootPrint::logTrail($footprint);
        //***=========
        
        return $users;

      } catch (Exception $e) {
        DB::rollback();
        return $e;
      }
      
    }

    // Download Accounts
    public function dl_pending_accounts()
    {
      // $users = User::whereHas('profile')->where('securities_account_flag', false)->where('uba_access', true)->orderBy('created_at', 'desc')->get();

      $users = User::select('users.id', \DB::raw("CONCAT(firstname,' ',lastname) as Name"), 'email', 'cash_account', 'securities_account')->
                join('profiles', 'users.id', '=', 'profiles.user_id')
                ->where('securities_account_flag', false)->where('uba_access', true)
                ->get();

      if (count($users) <= 0) {
          return redirect()->back()->with('error', 'No pending accounts');
      }

      // ***========
      $footprint = (object) [
        'Title' => 'User Account Management',
        'Details' => 'Download pending user accounts'
      ];
      FootPrint::logTrail($footprint);
      // ***========
      
      $data = json_decode(json_encode($users), true);
      $ex   = Excel::create(str_replace('-', '', 'TradeFIUsers' . date('Y-m-d')), function ($excel) use ($data) {
          $excel->sheet('Onboarded Users', function ($sheet) use ($data) {
              $sheet->fromArray($data);
          });
      })->download('xlsx');

    //   Excel::create('users-' . $hash, function ($excel) use ($users) {
    //     $excel->sheet('TradeFi', function ($sheet) use ($users) {
    //         $sheet->row(1, array( 'ID', 'First Name', 'Last Name', 'Email Address', 'Gender', 'DOB', 'Phone Number', 'Cash Account No.', 'Securities Account No.', 'Bank Name', ' Bank Account Number', 'BVN', 'Next of Kin Name', 'NextofKin Relationship', 'NextofKin Phone', 'NextofKin Address' ));//->setStyle(array( 'font' => array('bold' => true) ));
    //         $count = 2;
    //         foreach ($users as $key => $user) {
    //           $sheet->row($count, array(
    //             $user->id,
    //             $user->profile->firstname ?? '',
    //             $user->profile->lastname ?? '',
    //             $user->email,
    //             $user->profile->gender ?? '',
    //             $user->profile->dob ?? '',
    //             $user->profile->phone ?? '',
    //             $user->cash_account,
    //             $user->securities_account,
    //             $user->profile->bank_detail->bank->name ?? '',
    //             $user->profile->bank_detail->account_number ?? '',
    //             $user->profile->bank_detail->bvn ?? '',
    //             $user->profile->kin_fullname ?? '',
    //             $user->profile->kin_relationship ?? '',
    //             $user->profile->kin_phone ?? '',
    //             $user->profile->kin_address ?? ''
    //           ));
    //           $count++;
    //         }
    //     });
    // })
    // ->download('xlsx');
    }


    // Upload Accounts
    public function ul_profiled_accounts(Request $request)
    {
      $request->validate([
        'users_file' => 'file|mimes:xlsx,csv'
      ]);
      // $filename = $request->users_file->getClientOriginalName();

      // Get pending users, to avoid updating users not in this list.
      $pending_ids = User::select('id')->where('securities_account_flag', false)->where('uba_access', true)->get()->pluck('id')->toArray();
      
      try {
        // Get rows
        $rows = Excel::load($request->users_file, function($reader) {  
        })->get();
      } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Could not read file. Please try another file or contact an administrator.');
      }


      // Count how many users were updated.
      $count = 0;
      $users = [];
      $dupes = [];

      foreach ($rows as $row) {
        $user = User::find($row->id);
        $dupe = User::where('securities_account', $row->securities_account)->first();
        // If duplicate, collect account no, then next.
        if(!empty($dupe)) {
          $dupes[] = $dupe->securities_account;
          continue;
        }

        // User not found || No account in file || Account not numeric || User not in pending list
        if(empty($user) || empty($row->securities_account) || !in_array($row->id, $pending_ids))
        continue;

        $user->securities_account = $row->securities_account;
        $user->securities_account_flag = true;
        $user->company_id = '2';
        $user->update();
        $count++;
        $users[] = $user;
      }

      // dd($count);

      // ***========
      $footprint = (object) [
        'Title' => 'User Account Management',
        'Details' => 'Uploaded '.$count.' user accounts for profiling.'
      ];
      FootPrint::logTrail($footprint);
      // ***========

      if ($count > 0) {
        Notification::route('mail', config('app.tradefi_email'))->notify(new UsersProfiled($users));
        return redirect()->back()->with('success', $count.' accounts were updated successfully.');
      } elseif(!empty($dupes)) {
        return redirect()->back()->with('error', "Nothing was updated. The following account(s) are already assigned to another customer: ".implode(', ', $dupes));
      } else {
        return redirect()->back()->with('error', "Nothing was updated. Please check that the securities_account column contains the correct values, or that the accounts haven't already been profiled before.");
      }

    }
}
