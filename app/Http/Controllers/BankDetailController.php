<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\BankDetail;
use TradefiUBA\BankDetailsPending;
use TradefiUBA\Profile;
use DB;
use Illuminate\Http\Request;
use Pusher\PushNotifications\PushNotifications as PN;

class BankDetailController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $profile = auth()->user()->profile;
        if ($profile->bank_detail()->create($request->all())) {
            return redirect()->route('profile.index')->with('success', 'Bank details was added successfully');
        } else {
            return back()->withInput()->with('error', 'Bank details was not added');
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

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            \DB::beginTransaction();
            // bank_details table
            $profile                          = Profile::find($id);
            $bank_details_pending             = new BankDetailsPending;
            $bank_details_pending->profile_id = $profile->id;
            $bank_details_pending->fill($request->only(['account_number', 'bank_id', 'bvn']));
            $bank_details_pending->save();

            \DB::commit();
            return redirect('/profile')->with('success', 'Profile will be updated after approval');
        } catch (Exception $e) {

        }
    }
    public function bank_detail_list($id)
    {
        // $bank_detail     = BankDetail::find($id);
        $profile              = Profile::where('user_id', $id)->first();
        $bank_detail          = BankDetail::where('profile_id', $profile->id)->first();
        $bank_details_pending = BankDetailsPending::where('profile_id', $profile->id)->first();
        // dd($banking_details);
        return view('admin.users.bank_pending_show', compact('bank_details_pending', 'bank_detail'));
    }
    public function approve(Request $request, $id)
    {
        // approve pending bank information
        try {
            DB::beginTransaction();

            $user = auth()->user();

            // bank detail update
            $profile              = Profile::where('user_id', $id)->first();
            $bank_details_pending = BankDetailsPending::where('profile_id', $profile->id)->first();
            // dd($bank_details_pending);
            $bank_details_data = $bank_details_pending->replicate(['profile_id', 'ApprovedBy', 'deleted_at', 'bvn']);
            // Any extra columns?
            $bank_details_pending->ApprovedBy = $user->id;
            $bank_details_pending->save();
            // Fetch only the attributes
            $bank_details_arr = $bank_details_data->getattributes();
            // Copy & save to FCYTrade
            // $user_ = Staff::create($bank_details_arr);
            $bank_details             = BankDetail::where('profile_id', $profile->id)->first();
            $bank_details->updated_at = \Carbon\Carbon::now();
            // dd($bank_details_arr);
            $bank_details->update($bank_details_arr);
            // Soft delete from Pending
            $bank_details_pending->delete();

            DB::commit();

            $pushNotifications = new PN([
                'instanceId' => env('PUSHER_PN_INSTANCE_ID'),
                'secretKey'  => env('PUSHER_PN_SECRET_KEY'),
            ]);

            $publishResponse = $pushNotifications->publish(['private.' . $profile->user_id],
                array("fcm" => array("notification" => array(
                    "title" => "Bank Details Update",
                    "body"  => 'Bank Details have been approved',
                ),
                    "data"                              => [
                        'type'    => 'profile',
                        'profile' => $bank_details,
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
        $pending             = BankDetailsPending::where('profile_id', $profile->id)->first();
        $pending->ApprovedBy = '0';
        $pending->deleted_at = \Carbon\Carbon::now();
        $pending->save();

        return redirect('users/approve')->with('success', 'Profile changes were rejected successfully');
    }

    public function destroy($id)
    {
        //
    }
}
