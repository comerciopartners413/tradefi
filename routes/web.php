<?php

Auth::routes();

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('/', 'PagesController@index');
Route::get('/timedout', 'PagesController@timedout');
Route::get('/get-new-token', 'PagesController@getNewToken');
Route::get('/tradefi-guide', 'PagesController@tradefi_guide')->name('tradefi-guide');
Route::get('/faq-e', 'PagesController@tradefi_faqe');
Route::get('/terms', 'PagesController@terms');
Route::get('/aml', 'PagesController@aml');
Route::get('/', 'PagesController@index');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('phpinfo', function () {
    echo phpinfo();
});
Route::get('/pricelist', 'HomeController@pricelist');
Route::get('/equities-list', 'HomeController@equitieslist');

Route::get('/change-pin', 'SettingController@change_pin')->name('change-pin');

Route::post('/change-pin', 'SettingController@change_pin_post')->name('change-pin.store');
Route::post('deposit/pay', 'DepositController@pay');
Route::get('pay', 'DepositController@pay_view');
Route::post('pay', 'DepositController@pay');
Route::post('deposit/pay2', 'DepositController@pay2');
Route::middleware(['auth', 'check_pass'])->group(function () {

    Route::get('/home', 'HomeController@index')->name('home')->middleware('check_pin');

    Route::get('cash_entries/customer_transfer', 'DepositController@customer_transfer')->name('customer_transfer');
    Route::post('cash_entries/customer_transfer', 'DepositController@customer_transfer_store');

    Route::get('cash_entries/bonds_custody_transfer', 'DepositController@bonds_custody_transfer')->name('bonds_custody_transfer');
    Route::post('cash_entries/bonds_custody_transfer', 'DepositController@bonds_custody_transfer_store');

    Route::patch('profile/up/{id}', 'ProfileController@update2')->middleware('check_pin');
    Route::resource('profile', 'ProfileController')->middleware('check_pin');
    Route::resource('ticket', 'TicketController')->middleware('check_pin');
    Route::resource('faqs', 'FaqController')->only(['index']);
    Route::resource('comment', 'CommentController')->middleware('check_pin');
    Route::get('portfolio/bonds', 'PortfolioController@getBondsPortfolio')->middleware('check_pin');
    Route::resource('portfolio', 'PortfolioController')->only('index')->middleware('check_pin');
    Route::get('bank_details/list/{id}', 'BankDetailController@bank_detail_list')->middleware('admin');
    Route::patch('bank_details/approve/{id}', 'BankDetailController@approve')->middleware('admin');
    Route::patch('bank_details/reject/{id}', 'BankDetailController@reject')->middleware('admin');
    Route::resource('bank-details', 'BankDetailController');
    Route::resource('blotter', 'BlotterController')->middleware('check_pin');

    Route::get('transactions/multipost', 'TransactionController@multipost')->name('transactions.multipost');
    Route::post('transactions/multipost', 'TransactionController@multipost_store')->name('transactions.multipost.store');
    Route::get('transactions/viewcompanies', 'TransactionController@BankDetails')->name('bankstatements');
    Route::get('transactions/showdetails', 'TransactionController@showDetails')->name('showDetails')->middleware('check_pin');
    Route::get('transactions/transactionlist', 'TransactionController@TransactionList')->name('Transaction_List');
    Route::post('transactions/transactionlistrange', 'TransactionController@TransactionListRange')->name('Transaction_List_Range');
    Route::get('transactions/{id}', 'TransactionController@show')->name('transactions.show');
    Route::match(['get', 'post'], '/transactions', 'TransactionController@index')->name('transactions.index');

    Route::post('trade-room/zerorized', 'TradeRoomController@suspend');
    Route::get('trade-room/easymode', 'TradeRoomController@easymode')->name('easymode')->middleware('check_pin');
    Route::post('trade-room/get-ticket-details', 'TradeRoomController@get_ticket_details');
    Route::post('trade-room/fetch-easy', 'TradeRoomController@fetchEasyModeTradeList');
    Route::post('trade-room/fetch-easy', 'TradeRoomController@fetchEasyModeTradeList');
    Route::post('trade-room/search', 'TradeRoomController@search');

    // normal
    Route::post('trade-room/post-trade', 'TradeRoomController@postTrade');

    Route::post('trade-room/post-deal', 'TradeRoomController@postDeal');

    // fetch tradelist

    Route::get('/fetch-tradelist', 'TradeRoomController@fetch_tradelist');

    // simulation
    Route::post('simulation/post-deal', 'SimulationController@postDeal');

    // Normal
    Route::post('trade-room/fetch-trade-list-for-security', 'TradeRoomController@fetchTradeListForSecurity');
    // Simulation
    Route::post('simulation/fetch-trade-list-for-security', 'SimulationController@fetchTradeListForSecurity');

    Route::post('trade-room-filter', 'TradeRoomController@index2');
    Route::post('trade-room/fetch-chart-data', 'TradeRoomController@fetchChartData');
    Route::resource('trade-room', 'TradeRoomController')->middleware('check_pin');
    Route::post('/deposit/bank-dep', 'DepositController@bank_deposit');
    Route::post('/deposit/bank-deps/approve/{id}', 'DepositController@bank_deposits_approve')->middleware('admin');
    Route::get('/deposit/bank-deps', 'DepositController@bank_deposits')->name('direct-deposits')->middleware('admin');
    Route::post('deposits/payment/query', 'DepositController@re_query');
    Route::get('deposit/all', 'DepositController@all')->name('deposits');

    Route::patch('deposit/send/{id}', 'DepositController@send');
    Route::resource('deposit', 'DepositController');
    Route::get('/deposit/details/{id}/{description}/{cpay_ref}/{amount}', 'DepositController@details');
    Route::patch('withdrawals/send/{id}', 'WithdrawalController@send');
    Route::post('withdrawals/check-password', 'WithdrawalController@check_password')->name('w-check-password');
    Route::resource('withdrawals', 'WithdrawalController');
    // Route::get('/reset-password', 'SettingController@reset_password');
    // Route::post('/reset-password', 'SettingController@reset_password');
    Route::post('/reset-trading-pin', 'SettingController@reset_trading_pin');

    // workflowData
    Route::resource('workflow', 'WorkflowController');
    // endWorkFlowData

    Route::post('/mark-as-read/{id}', 'HomeController@mark_as_read');
    Route::get('/last-5-trades', 'TradeRoomController@fetchLatestTrade');
    Route::post('/watch-security', 'HomeController@watchSecurity');
    Route::post('/remove-watchlist', 'HomeController@unWatchSecurity');
    Route::get('/getBalanceForSecurity/{id}', 'HomeController@getBalanceForSecurity');

    // simulation
    Route::get('/simulation/getBalanceForSecurity/{id}', 'SimulationController@getBalanceForSecurity');

    Route::get('/genie', 'GenieController@index');
    Route::post('/genie/handle', 'GenieController@handle');

    Route::resource('simulation', 'SimulationController');
    Route::resource('withdraw', 'WithdrawalController')->only('store');
    Route::get('report', 'ReportController@index')->name('report');

    // Securities
    // Reoder
    Route::patch('securities/send/{id}', 'SecurityController@send');
    Route::get('securities/re-order', 'SecurityController@reorder');
    // \reorder

    // Security Approver screens or General Approval Screen

    Route::post('/securities/benchmark', 'SecurityController@benchmark');
    Route::post('/securities/remove-benchmark', 'SecurityController@remove_benchmark');
    Route::get('/securities/make-spread', 'SecurityController@makeSpread')->name('securities.makeSpread');
    Route::patch('/securities-bonds-spread/{id}', 'SecurityController@spread_update_bonds');
    Route::patch('/securities-tbills-spread/{id}', 'SecurityController@spread_update_tbills');
    Route::post('/securities/make-spread', 'SecurityController@makeSpreadPost');
    Route::resource('securities', 'SecurityController');
    // End securities

    // menus and roles and permissions

    Route::get('roles/create_uba', 'RoleController@create_uba')->name('roles.create_uba');
    Route::get('roles/{id}/menus', 'RoleController@list_menus');
    Route::delete('roles/{menu_id}/{role_id}', 'RoleController@remove_menu');
    Route::resource('roles', 'RoleController');
    Route::get('/assignroles', 'UserRoleAssignmentController@create')->name('roleassignment');
    Route::post('/assignroles', 'UserRoleAssignmentController@store');

    Route::resource('permissions', 'PermissionController');

    Route::get('/assignmenus', 'MenuRoleAssignmentController@create')->name('menuassignment');
    Route::post('/assignmenus', 'MenuRoleAssignmentController@store');
    Route::resource('menus', 'MenuController');

    Route::get('/download-trades', 'TradeDownloaderController@get_trades')->name('download-trades');
    Route::get('/spread-income', 'TradeDownloaderController@spreadincome')->name('spread-income');
    Route::get('downloadExcel/{type}', 'TradeDownloaderController@downloadExcel');
    Route::get('downloadExcel2/{type}/{date}', 'TradeDownloaderController@downloadExcel2');
    Route::get('downloadExcelComercio/{type}', 'TradeDownloaderController@downloadExcelComercio');
    Route::get('downloadExcelComercio2/{type}/{date}', 'TradeDownloaderController@downloadExcelComercio2');

    Route::get('reports/settlement', 'Admin\ReportController@reports_settlement')->name('reports.settlement');
    Route::get('reports/settlement_gis', 'Admin\ReportController@reports_settlement_gis')->name('reports.settlement_gis');

    Route::get('download_settlement/{format}/{date}', 'TradeDownloaderController@download_settlement');
    Route::get('download_gis/{format}/{date}', 'TradeDownloaderController@download_gis');

    Route::get('instructions/aggregate', 'InstructionLetterController@aggregate')->name('instructions.aggregate');
    Route::get('instructions/download_aggregates/{pdf}/{date}', 'InstructionLetterController@download_aggregates')->name('instructions.download_aggregates');

});

Route::post('user/check-trading-pin', 'UserController@check_trading_pin');
Route::get('users/verify/{code}', 'UserController@verify')->name('users.verify');
Route::get('/checkauth', 'UserController@checkAuth')->name('auth.check'); //check if current user is signed in elsewhere
Route::post('/users/create-admin', 'UserController@create_admin');
Route::get('/download-users', 'UserController@get_onboarded_users')->name('download-users');
Route::get('download-users/{type}', 'UserController@downloadExcel');
//
Route::post('users/update-securities-account', 'UserController@update_sec_account_field');
Route::post('users/update-cash-account', 'UserController@update_cash_account_field');
//
Route::post('users/kyc-flag', 'UserController@kyc');
Route::post('users/sec-flag', 'UserController@sec_account');
Route::post('users/cash-flag', 'UserController@cash_account');
Route::get('users/roles', 'UserController@roles');
Route::post('users/roles', 'UserController@post_roles');
Route::get('users/approve', 'UserController@approval_list')->name('approve-updates')->middleware('admin');
Route::patch('users/approve/{id}', 'UserController@approval_post')->middleware('admin');
Route::patch('users/reject/{id}', 'UserController@reject')->middleware('admin');
Route::get('users/approve/{id}', 'UserController@approval_show')->middleware('admin');
Route::resource('users', 'UserController');
Route::resource('holidays', 'HolidayController');
// Workflow
Route::get('approvallist', 'ApprovalController@checklist')->name('approvallist');
Route::get('approvallist-inventory', 'ApprovalController@checklist_inventory')->name('approvallist_inventory');
Route::get('approvallist-dd', 'ApprovalController@checklist_dd')->name('approvallist_dd');
Route::post('approvallist/approve', 'ApprovalController@approve');
Route::post('approvallist/reject', 'ApprovalController@reject');
Route::post('/reset-password', 'SettingController@reset_password');

Route::get('/change_pass', 'SettingController@change_pass')->name('change_pass');
Route::get('/audit-trail', 'FootPrintController@index')->name('audit_trail');
Route::post('trades/confirm', 'ApprovalController@confirm_trades')->name('confirm_trades');

// roles
// Route::post('/roles', 'Admin\AdminUserController@create_role');

Route::get('/uba/create_admins', 'Admin\AdminUserController@create_uba')->name('admin.users.create_uba');

Route::resource('news', 'NewsController')->only(['show', 'index']);
// Admin groups
Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth']], function () {
    Route::get('tickets/close/{ticket_id}', 'TicketController@close');
    Route::get('tickets/{ticket_id}', 'TicketController@show_ticket_admin');
    Route::get('tickets', 'TicketController@tickets_admin')->name('admin_tickets');

    Route::namespace ('Admin')->group(function () {
        Route::get('/deposit/bank-dep', 'DepositController@approved_deposits_ajax')->name('admin.approved_deposits_ajax');
        // coupon payment
        Route::get('/coupon-payment', 'CouponPaymentController@get_list')->name('get-coupon');
        Route::post('/coupon-payment', 'CouponPaymentController@post_list')->name('post-coupon');
        // ----

        // cash release
        Route::get('/cash-release', 'CashReleaseController@get_list')->name('get-cr');
        Route::post('/cash-release', 'CashReleaseController@post_list')->name('post-cr');
        // /cash release

        // Audit Trail
        Route::get('/audits', 'AuditController@index')->name('audits.index');
        Route::post('/audits', 'AuditController@store')->name('audits.store');

        // / Audit trail

        Route::get('pricelog', 'ReportController@pricelog')->name('pricelog');
        Route::post('users/activate/{id}', 'AdminUserController@activate');
        Route::post('users/save_company', 'AdminUserController@save_company')->name('save_company');
        Route::post('trades', 'ReportController@trades_post');
        Route::get('trades', 'ReportController@trades')->name('view_trades');
        Route::any('trades_uba', 'ReportController@trades_uba')->name('view_trades_uba');
        Route::get('trades/custodyfees', 'ReportController@trades_custody')->name('custodyfees');
        Route::resource('users', 'AdminUserController', ['as' => 'admin']);
        Route::resource('deposits', 'DepositController', ['as' => 'admin']);
        Route::get('custody', 'DepositController@custody', ['as' => 'admin'])->name('admin.custody.index');
        Route::post('custody', 'DepositController@custody_store', ['as' => 'admin'])->name('admin.custody.store');
        Route::patch('custody/send/{id}', 'DepositController@send_custody');

        Route::resource('news', 'NewsController', ['as' => 'admin']);
        Route::post('macros/save', 'MacroController@save'); //iis made me do these
        Route::resource('macros', 'MacroController', ['as' => 'admin']);
        Route::post('fx/save', 'FXController@save'); //iis made me do these
        Route::resource('fx', 'FXController', ['as' => 'admin']);
        Route::patch('inventory/send/{id}', 'InventoryController@send');
        Route::post('get-inventory', 'InventoryController@get_inventory');
        Route::get('inventory/today', 'InventoryController@inventory_today')->name('inventory_today');
        Route::resource('inventory', 'InventoryController', ['as' => 'admin']);

        Route::resource('faqs', 'FaqController', ['as' => 'admin'])->only(['index', 'store', 'update', 'destroy']);
    });

});

Route::group(['middleware' => ['log.activity', 'auth']], function () {

    Route::resource('config', 'ConfigController');
    Route::get('/execeod', 'ConfigController@execeod')->name('execeod');
    Route::post('/execeod', 'ConfigController@execeodpost');

    // use profile
    Route::get('/user/profile/@{user}', 'ProfileController@getUser')->name('user.profile.index');

    // auth routing
    Route::group(['middleware' => ['auth']], function () {

        // MESSAGES
        Route::get('messages/inbox', 'MessageController@inbox')->name('inbox');
        Route::get('messages/sent', 'MessageController@sent_messages')->name('sent_messages');
        Route::get('messages/compose', 'MessageController@compose')->name('compose_message');
        Route::post('messages/send', 'MessageController@send_message')->name('send_message');
        Route::post('messages/reply/{parent_id}', 'MessageController@reply_message')->name('reply_message');
        Route::get('message/{id}/{reply?}', 'MessageController@view_message')->name('view_message');
        Route::get('search_messages', 'MessageController@search_messages')->name('search_messages');
        Route::get('download-file/{dir}/{filename}', function ($dir, $filename) {
            return response()->download(storage_path("app/public/" . $dir . "/" . $filename));
        })->name('download_file');
        Route::post('messages/store_subject', 'MessageController@store_subject')->name('store_subject');
        Route::get('messages/confirm_upload', 'MessageController@confirm_upload')->name('confirm_upload');
        Route::post('messages/confirm_upload', 'MessageController@post_confirm_upload')->name('post_confirm_upload');
        Route::get('price_upload/first_approval', 'PriceUploadController@first_approval')->name('price_upload.first_approval');
        Route::post('price_upload/first_approval', 'PriceUploadController@post_first_approval')->name('price_upload.post_first_approval');
        Route::post('price_upload/first_approval_selected', 'PriceUploadController@post_first_approval_selected')->name('price_upload.post_first_approval_selected');
        Route::get('price_upload/history', 'PriceUploadController@history')->name('price_upload.history');

        Route::get('not_profiled', 'Admin\AdminUserController@not_profiled')->name('not_profiled');
        Route::get('pending_accounts', 'Admin\AdminUserController@pending_accounts')->name('pending_accounts');
        Route::get('profiled_accounts', 'Admin\AdminUserController@profiled_accounts')->name('profiled_accounts');
        Route::post('send_onboarded', 'Admin\AdminUserController@send_onboarded')->name('admin.users.send_onboarded');
        Route::get('dl_pending_accounts', 'Admin\AdminUserController@dl_pending_accounts')->name('dl_pending_accounts');
        Route::post('ul_profiled_accounts', 'Admin\AdminUserController@ul_profiled_accounts')->name('ul_profiled_accounts');

        Route::group(['prefix' => 'forum'], function () {
            // auth forum routes
            // topics
            Route::get('/topics/create', 'TopicsController@showCreateForm')->name('forum.topics.create.form');
            Route::post('/topics/create', 'TopicsController@create')->name('forum.topics.create.submit');

            // subscriptions
            Route::get('/topics/{topic}/subscription/status', 'SubscriptionsController@getSubscriptionStatus')->name('forum.topics.topic.subscription.status');
            Route::post('/topics/{topic}/subscription', 'SubscriptionsController@handleSubscription')->name('forum.topics.topic.subscription.submit');

            // posts
            Route::post('/topics/{topic}/posts/create', 'PostsController@create')->name('forum.topics.posts.create.submit');
            Route::get('/topics/{topic}/posts/{post}/edit', 'PostsController@edit')->name('forum.topics.topic.posts.post.edit');
            Route::post('/topics/{topic}/posts/{post}/update', 'PostsController@update')->name('forum.topics.topic.posts.post.update');
            Route::delete('/topics/{topic}/posts/{post}/delete', 'PostsController@destroy')->name('forum.topics.topic.posts.post.delete');

            // reports
            Route::post('/topics/{topic}/report', 'TopicsReportController@report')->name('forum.topics.topic.report.report');
            Route::post('/topics/{topic}/posts/{post}/report', 'PostsReportController@report')->name('forum.topics.topic.posts.post.report.report');

            // auth.elevated refers to moderator || admin roles
            Route::group(['middleware' => ['auth.elevated']], function () {
                Route::delete('/topics/{topic}', 'TopicsController@destroy')->name('forum.topics.topic.delete');
            });
        });

        // user routing
        Route::group(['prefix' => 'user'], function () {

            Route::group(['prefix' => 'chat/threads'], function () {
                // user messaging
                Route::get('/', 'MessagesThreadController@index')->name('user.chat.threads.index');
                Route::post('/create', 'MessagesThreadController@create')->name('user.chat.threads.create');

                Route::get('/@{user}/messages', 'MessagesController@index')->name('user.chat.threads.thread.messages.index');
                Route::get('/@{user}/messages/fetch', 'MessagesController@fetchMessages')->name('user.chat.threads.thread.messages.fetch');
                Route::post('/@{user}/messages', 'MessagesController@create')->name('user.chat.threads.thread.messages.create');
            });

            Route::group(['prefix' => 'profile'], function () {
                // user profile
                Route::get('/@{user}/settings', 'ProfileSettingsController@index')->name('user.profile.settings.index');
                Route::post('/@{user}/settings/update/', 'ProfileSettingsController@update')->name('user.profile.settings.update');
            });

        });

        // admin routing
        Route::group(['prefix' => 'admin', 'middleware' => ['auth.admin']], function () {
            // admin dashboard
            Route::get('/dashboard', 'AdministratorDashboardController@index')->name('admin.dashboard.index');
            Route::post('/dashboard/update', 'AdministratorDashboardController@update')->name('admin.dashboard.update');
            Route::post('/dashboard/invite', 'AdministratorDashboardController@invite')->name('admin.dashboard.invite');
            // config

            //
            Route::delete('/dashboard/users/{user}', 'AdministratorDashboardController@destroy')->name('admin.dashboard.user.destroy');
        });

        // moderator dashboard, also accessible by admin (auth.elevated)
        Route::group(['prefix' => 'moderator', 'middleware' => ['auth.elevated']], function () {
            Route::get('/dashboard', 'ModeratorDashboardController@index')->name('moderator.dashboard.index');
            Route::delete('/dashboard/reports/{report}', 'ModeratorDashboardController@destroy')->name('moderator.dashboard.reports.report.destroy');
        });

    });

    // public forum routing
    Route::group(['prefix' => 'forum'], function () {
        // view topics and topic posts
        Route::get('/', 'TopicsController@index')->name('forum.topics.index');
        Route::get('/topics/{topic}', 'TopicsController@show')->name('forum.topics.topic.show');

        // check status of content, in relation to reporting
        Route::get('/topics/{topic}/report/status', 'TopicsReportController@status')->name('forum.topics.topic.report.status');
        Route::get('/topics/{topic}/posts/{post}/report/status', 'PostsReportController@status')->name('forum.topics.topic.posts.post.report.status');
    });

});
Route::get('paystack', 'PaymentController@index');
Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay');
Route::get('/paystack/callback', 'PaymentController@handleGatewayCallback');

Route::get('test', function () {
    return TradefiUBA\User::where('securities_account', '170079500004')->first();

    return TradefiUBA\User::select('securities_account', 'securities_account_flag')->where('admin', 0)->where('ActivatedFlag', 0)->whereHas('profile')->where('securities_account_flag', false)->where('uba_access', false)->orderBy('created_at', 'desc')->get();
    return public_path('storage/excel/users/users-5d543009eea42.xlsx');
    // $date = '2018-05-31';
    $date   = '2019-05-06';
    $trades = TradefiUBA\TradeData::select(DB::raw('SecurityID, MAX(TradeDate) as TradeDate, MAX(tblTradeData.SettlementDate) as SettlementDate, MAX(MaturityDate) as MaturityDate, MAX(IssueDate) as IssueDate, MAx(Tenor) as Tenor, wct.WAVG(Quantity, Yield) as Yield, SUM(Quantity) as FaceValue, SUM(DiscountAmount) as DiscountAmount'))
        ->join('tblSecurity', 'SecurityRef', '=', 'SecurityID')
        ->where('tblSecurity.ProductID', '2')
        ->where('TransactionTypeID', '1')
        ->whereDate('TradeDate', $date)
        ->groupBy('SecurityID')
        ->with('security')
        ->get();
    // dd($trades);
    $pdf = PDF::loadView('instructions.letters.tbs_buy', compact('trades', 'date'));
    return $pdf->stream();

});

Route::get('/documentation/api', function () {
    $url = "https://documenter.getpostman.com";
    return view('api_doc', compact('url'));
});

Route::get('/set_customer_role', function () {
    $users = TradefiUBA\User::where('admin', false)->get();
    // dd($users->pluck('username'));
    $role = TradefiUBA\Role::where('name', 'customer')->first();
    foreach ($users as $user) {
        $user->roles()->attach($role->id);
    }
    return 'Done';
});

Route::get('/create_uba_user', function () {
    try {
        DB::beginTransaction();
        $user = TradefiUBA\User::create([
            'username'          => 'UBA',
            'password'          => bcrypt('uba_admin'),
            'email'             => 'uba@uba.com',
            'confirmation_code' => base64_encode(str_random(50)),
            'admin'             => true,
            'company_id'        => '2',
            'trading_pin'       => '1234',
            'confirmed'         => true,
            'ActivatedFlag'     => true,
            'changed_pin'       => true,
            'changed_password'  => true,
        ]);

        $user->profile()->create([
            'firstname' => 'UBA',
            'lastname'  => 'UBA',
            'dob'       => '1960-10-01',
            'phone'     => (int) mt_rand(900000000, 1234567890) . '0',
        ]);

        $gl = new TradefiUBA\GL([
            'CustomerID'    => $user->id,
            'Description'   => 'Cash Account',
            'AccountTypeID' => 1,
            'CurrencyID'    => 1,
            'BranchID'      => 1,
            'SerialNo'      => count($user->profile->gls) + 1,
        ]);
        $gl->save();

        $role = TradefiUBA\Role::create([
            'name'         => 'uba',
            'display_name' => 'UBA Staff',
        ]);

        $user->roles()->attach($role->id);

        DB::commit();
        return 'Done';
    } catch (Exception $e) {
        DB::rollback();
    }

});

// Route::get('/reset-users', function(){
//   $users = ['1125', '1127', '1131', '1141', '1143', '1146', '1147', '1148', '1150', '1151', '1152', '1153', '1415'];
//   foreach ($users as $id) {
//     $user = TradefiUBA\User::find($id);
//     $user->securities_account = NULL;
//     $user->securities_account_flag = false;
//     $user->uba_access = false;
//     $user->update();

//     $gl = TradefiUBA\GL::where('CustomerID', $id)->where('Description', 'Cash Account')->where('AccountTypeID', '1')->first();
//     $gl->BookBalance = '0';
//     $gl->ClearedBalance = '0';
//     $gl->update();
//     $trades = TradefiUBA\TradeData::where('InputterID', $id)->delete();
//     $trans = TradefiUBA\Transaction::where('GLID', $gl->GLRef)->delete();
//     $entry = TradefiUBA\TransactionEntry::where('GLIDCredit', $gl->GLRef)->orWhere('GLIDDebit', $gl->GLRef)->delete();
//   }

//   return 'Done';
// });
