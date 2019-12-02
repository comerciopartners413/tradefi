<?php

use Illuminate\Http\Request;
use TradefiUBA\User;
use TradefiUBA\Profile;
use TradefiUBA\GL;
use TradefiUBA\TransactionEntry;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/users', function (Request $request) {
//     return TradefiUBA\User::all();
// });

// Route::post('/add-user', function (Request $request) {
//     return $request->name;
// });

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware(['checkIp'])->group(function () {

    // CUSTOMER INFO
    // GET: customer_id
    Route::get('/customer/{id}', function (Request $request, $id) {
        $user = User::select('id', 'username', 'securities_account')->where('id', $id)->first();
        $profile = Profile::select('firstname', 'lastname', 'gender', 'dob', 'address', 'phone')->where('user_id', $id)->first();

        if (!empty($user) && !empty($profile)) {
          return [
            'status' => 'success',
            'message' => 'success',
            'data' => [
              'id' => $user->id,
              'firstname' => $profile->firstname,
              'lastname' => $profile->lastname,
              'gender' => $profile->gender,
              'dob' => $profile->dob,
              'address' => $profile->address,
              'phone' => $profile->phone,
              'securities_account' => $user->securities_account,
              ]
          ];
        } else {
          return [
            'status' => 'error',
            'message' => 'Customer account or profile not found',
            'data' => []
          ];
        }
        
    });


    // Balance in Cash Account
    // GET: customer_id
    Route::get('/customer/balance/{id}', function (Request $request, $id) {
      $user = User::select('id', 'username', 'securities_account')->where('id', $id)->first();
      $profile = Profile::select('firstname', 'lastname', 'gender', 'dob', 'address', 'phone')->where('user_id', $id)->first();
      $gl = GL::where('CustomerID', $user->id)->where('AccountTypeID', '1')->first();

      if(empty($gl)) {
        return [
          'status' => 'error',
          'message' => 'Cash account not found for this customer',
          'data' => []
        ];
      }

      if (!empty($user) && !empty($profile)) {
        return [
          'status' => 'success',
          'message' => 'success',
          'data' => [
            'id' => $user->id,
            'firstname' => $profile->firstname,
            'lastname' => $profile->lastname,
            // 'account_no' => $gl->AccountNo,
            'account_ref' => $gl->GLRef,
            'book_balance' => $gl->BookBalance,
            // 'cleared_balance' => $gl->ClearedBalance,
            'cash_account' => $user->cash_account,
            'securities_account' => $user->securities_account,
            ]
        ];
      } else {
        return [
          'status' => 'error',
          'message' => 'Customer account or profile not found',
          'data' => []
        ];
      }
      
    });


    // POST DEPOSIT
    // POST: customer_id, amount
    Route::post('/customer/deposit', function(Request $request){
      // customer_id, amount, account_no?
      $user = User::find($request->customer_id);
      $profile = Profile::select('firstname', 'lastname')->where('user_id', $request->customer_id)->first();
      $gl = GL::where('CustomerID', $request->customer_id)->where('AccountTypeID', '1')->first();
      if (empty($user) || empty($profile)) {
        return [
          'status' => 'error',
          'message' => 'Customer account not found',
          'data' => []
        ];
      }
      if (empty($gl)) {
        return [
          'status' => 'error',
          'message' => 'Deposit account not found',
          'data' => []
        ];
      }
      if (empty($request->amount) || $request->amount <= 0) {
        return [
          'status' => 'error',
          'message' => 'Invalid deposit amount',
          'data' => []
        ];
      }

      // All good? Post Deposit
      $trans = new TransactionEntry;
      $trans->PostingTypeID = '6';
      $trans->GLIDDebit = '1';
      $trans->GLIDCredit = $gl->GLRef;
      $trans->PostDate = date('Y-m-d');
      $trans->ValueDate = date('Y-m-d');
      $trans->Amount = $request->amount;
      $trans->Narration = 'Cash Deposit by '.$profile->firstname.' '.$profile->lastname;
      $trans->InputDatetime = date('Y-m-d H:i:s.v');
      $trans->save();

      return [
        'status' => 'success',
        'message' => 'Deposit sent successfully',
        'data' => [
          'id' => $user->id,
          'firstname' => $profile->firstname,
          'lastname' => $profile->lastname,
          // 'account_no' => $gl->GLRef,
          'cash_account' => $user->cash_account,
          'account_ref' => $gl->GLRef,
          'book_balance' => $gl->BookBalance,
          'amount' => $trans->Amount,
          'narration' => $trans->Narration,
          'post_date' => $trans->PostDate,
          'value_date' => $trans->ValueDate,
          'securities_account' => $user->securities_account,
          ]
      ];
    });

    Route::post('/customer-holdings', function(Request $request)
    {
      // $request->validate([
      //   'date' => 'date'
      // ]);

      $validator = Validator::make($request->all(), [
        'date' => 'date'
      ],
      [
        'date.date' => 'Invalid date format.'
      ]);

      if ($validator->fails()) {
        // return response()->json($validator->errors())->setStatusCode(403, 'Bad Request');
        return response()->json([
          'status' => 'error',
          'message' => 'Invalid date format',
          'data' => []
        ])->setStatusCode(403);
      }

      $formatted_date = date_format(date_create($request->date), 'Y-m-d');
      // return $formatted_date;
      $data         = \DB::select("
      EXEC procUBATradeDownloaderGIS '$formatted_date', '1'
      ");

      // return $data;
      // return array_column($data, 'INSTRUMENT');

      return response()->json([
        'status' => 'success',
        'message' => 'success',
        'data' => $data
      ]);
      
    });


    Route::post('/settled-trades', function(Request $request)
    {
      // $request->validate([
      //   'date' => 'date'
      // ]);

      $validator = Validator::make($request->all(), [
        'date' => 'date'
      ],
      [
        'date.date' => 'Invalid date format.'
      ]);

      if ($validator->fails()) {
        // return response()->json($validator->errors())->setStatusCode(403, 'Bad Request');
        return response()->json([
          'status' => 'error',
          'message' => 'Invalid date format',
          'data' => []
        ])->setStatusCode(403);
      }

      $formatted_date = date_format(date_create($request->date), 'Y-m-d');
      // return $formatted_date;
      $data         = \DB::select("
      EXEC procUBASettledTrades '$formatted_date'
      ");

      // return $data;
      // return array_column($data, 'INSTRUMENT');

      if (empty($data)) {
        return response()->json([
          'status' => 'error',
          'message' => 'No trades found for '.$request->date,
          'data' => $data
        ]);
      } else {
          return response()->json([
            'status' => 'success',
            'message' => 'success',
            'data' => $data
          ]);
      }
      
      
      
    });


});
