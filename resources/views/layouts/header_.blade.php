<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
   
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/favicon.ico') }}" type="image/x-icon" />
     <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>
    <!-- Page title -->
    <title>{{ config('app.name', 'TradeFI') }}</title>

    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    {{-- <link href="{{ asset('webapp/vendor/jquery/custom/li-scroller.css') }}" rel="stylesheet" type="text/css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('webapp/styles/custom1.css') }}"> --}}

    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ asset('webapp/vendor/fontawesome/css/font-awesome.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('webapp/vendor/animate.css/animate.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('webapp/vendor/bootstrap/css/bootstrap.css') }}" />

    <link rel="stylesheet" href="{{ asset('webapp/vendor/bootstrap/css/bootstrap-notifications.min.css') }}" />
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">
    <link rel="stylesheet" href="{{ asset('webapp/vendor/datatables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/vendor/select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/vendor/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/css/summernote.css') }}" />

    <!-- App styles -->
    <link rel="stylesheet" href="{{ asset('webapp/styles/pe-icons/pe-icon-7-stroke.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/styles/pe-icons/helper.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/styles/stroke-icons/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/vendor/toastr/toastr.min.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('webapp/styles/style.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('webapp/styles/scrollbar.css') }}"> --}}
     <link rel="stylesheet" href="{{ asset('webapp/styles/compiled.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.2.0/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.2.0/css/ion.rangeSlider.skinModern.css">
    <link rel="stylesheet" href="{{ asset('webapp/vendor/sweetalert2/sweetalert2.min.css')}}">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.10/sweetalert2.min.css" /> -->
   
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-129415842-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-129415842-1');
</script>


     @stack('styles')

</head>

<body>
    <div id="spinner" style="display: none; padding-top:40vh" class="text-center">
      <img src="{{ asset('assets/img/spinner.gif') }}" alt="" width="40px">
    </div>
     <style>
        .content>div {
    opacity: 1;
}
        #accounts_spinner, #spinner {
    position: fixed;
    background: rgba(0, 0, 0, .5);
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 9999;
}
        #chartdiv,
        #bonds-chart, #tbills-chart {
            width: 95%;
            height: 250px;
        }
        #general-chart {
            width: 95%;
            height: 300px;
        }

        .custom-close {
            font-size: 20px;
            vertical-align: middle;
            margin-left: 10px;
        }

        h3.m-b-none.server1 {
            font-size: 20px;
        }

        .time-labels {
                font-size: 16px;
                color: #ff0000;
                margin-left: 10px;
                margin-top: 11px;
                position: relative;
                display: inline-block;
                text-transform: capitalize;
                font-weight: 600;
                word-spacing: 3px;
        }

        #one,#two, .countdown-timer{
            margin-top: 20px;
            padding: 0 10px;
        }
        .countdown-timer strong{
            color: #F44336;
        }

    </style>

    
    <div class="customloader"></div>
    <!-- Wrapper-->
    <div id="tradeFIapp">
        <div class="wrapper" >

            <!-- Header-->
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div id="mobile-menu">
                            <div class="left-nav-toggle">
                                <a href="#">
                                    <i class="stroke-hamburgermenu"></i>
                                </a>
                            </div>
                        </div>
                        <a class="navbar-brand" href="{{ route('home') }}" style="color: #565656">
                            <div align="center">
                                <img src="{{ asset('assets/images/logo-no-bg.jpg') }}" width="80px" align="middle"></div>
                        </a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <div class="left-nav-toggle">
                            <a href="">
                                <i class="stroke-hamburgermenu"></i>
                            </a>
                        </div>
                        <!--<form class="navbar-form navbar-left">
                        <input type="text" class="form-control" placeholder="Search data for analysis" style="width: 175px">
                    </form>-->
                        <ul class="nav navbar-nav navbar-right">
                            {{-- Show funds if user ain't admin --}}
                                @if(auth()->user()->admin != 1)

                                <li>
                                    <div id="one" class="pull-left"></div>
                                    <div id="two" class="pull-right"></div>
                                    <div class="countdown-timer"></div>
                                </li>

                                <li class="dropdown">
                                <a href="#" data-toggle="modal" data-target="#fundmodal" style="color: mediumseagreen;text-align: center"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;Available Balance :
                            <span style="color:chocolate"> 
                            {{-- {{ number_format(auth()->user()->profile->gls->first()->ClearedBalance, 2) }} --}}
                            <gl-component main_balance="{{ $gl_balance }}" :user_id="{{ auth()->user()->id }}">
                                {{ $gl_balance }}
                            </gl-component>
                             </span> 
                            </a>
                            </li>
                                @endif
                            {{--  --}}


                            {{-- Message Icon --}}
                            {{-- <li>
                              <a href="{{ route('inbox') }}" style="position:relative">
                                <div class="fa fa-envelope m-r-15 m-t-15 f20"></div>
                                  <span id="msg" class="badge badge-danger badge-notif" {{ (count(auth()->user()->unread_inbox) > 0)? '' : 'style=display:none' }}>{{ count(auth()->user()->unread_inbox) }}</span>
                              </a>
                            </li> --}}
                            
                                <notification :unreads="{{ auth()->user()->unreadNotifications }}" 
                                    :user-id="{{ auth()->user()->id }}"
                                    ></notification>
                           
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
                            <li class="profil-link">
                                <a href="#" data-toggle="dropdown" class=" dropdown-toggle">
                                    {{-- <img src="images/profile.jpg" class="img-circle" alt=""> --}}

                                    @if(auth()->user()->hasCustomAvatar())
                                    <img src="{{ asset('storage/avatar/'.auth()->user()->avatar) }}" alt="avatar">

                                    @else
                                    <span style="display: inline-block;" class="abbr-avatar">{{ auth()->user()->abbreviation(auth()->user()->profile->firstname) }}</span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('profile.index') }}"><i class="fa fa-user" aria-hidden="true"></i> My Profile</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

            </nav>
            <!-- End header-->

            <!-- Navigation-->
            <aside class="navigation scrollbar" id="style-9">
                <nav class="">

                    <div class="visible-xs balance-mobile" style="margin-top: 20px">
                        <p>Cash Balance</p>
                        <div class="amount" style="cursor: pointer" data-toggle="modal" data-target="#fundmodal">
                            <gl-component main_balance="{{ $gl_balance }}" :user_id="{{ auth()->user()->id }}">
                                {{ $gl_balance }}
                            </gl-component>
                        </div>
                        <p style="margin-top: 10px">
                            <a href="/logout">LOG OUT</a>
                        </p>
                    </div>
                    
                    {{-- @include('layouts.menus') --}}

                    {{-- Menus --}}
                    <ul class="nav luna-nav">
                        <li class="active">
                            <a href="{{ route('home') }}"> <i class="pe-7s-display1 c-accent"> </i>&nbsp; My Dashboard</a>
                        </li>
                      
                        @foreach ($parent_menus as $menu)
                            <li>
                              <a href="{{ ($menu->route != '#')? route($menu->route) : "#menu".$menu->id }}" data-toggle="collapse" aria-expanded="false">
                                {{ $menu->name }}
                                @if (count($menu->children) > 0)<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>@endif
                              </a>
                              <ul id="menu{{ $menu->id }}" class="nav nav-second collapse">
                                @forelse ($menu->children as $child)
                                  @if (auth()->user()->hasMenu($child->id) || auth()->user()->company_id == '1')
                                    <li>
                                        <a href="{{ route($child->route) }}"> <i class="fa fa-genderless c-accent"> </i>&nbsp;&nbsp; {{ $child->name }}</a>
                                    </li>
                                  @endif
                                @empty  
                                @endforelse
                              </ul>
                            </li>
                          
                        @endforeach
                    </ul>
                    {{-- End Menus --}}

                </nav>
                <!--   <div align="center">  <img  src="images/genie1.png" width="120px" align="middle">  </div>  -->
            </aside>
            <!-- End navigation-->

            <!-- Main content-->
            <section class="content" id="contentdiv">
               <div class="container-fluid">
                    @yield('content')
                 <?php $tradedate = TradefiUBA\Config::select('TradeDate')->first();?>
               </div>
            </section>
            <!-- End main content-->
                @yield('feeds')

        </div>
    <!-- End wrapper-->

    <!-- Includable Modals -->
@if(auth()->user()->ActivatedFlag != 0)
    <div class="modal right fade in" id="fundmodal" role="dialog" aria-hidden="true" style="max-height: 100%; overflow-y: auto;">
        <div class="modal-dialog">
            <div class="modal-content-wrapper">
                <div class="modal-content" style="">
                    <!--<div class="modal-header clearfix text-left">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
X</button>
</div>-->
                    <div class="modal-body ">

                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">close &nbsp;<i class="fa fa-times"></i>
</button>-->

                                <a href="#" data-dismiss="modal" aria-hidden="true">Close &nbsp;<i class="fa fa-times"></i>
</a>

                            </div>
                            <div class="text-right col-md-6 col-xs-12" style="">
                                <i class="pe-7s-server c-accent"></i>
                                <h4 class="stat-label">Available Cash Balance</h4> 
                                <span class="m-t-lg bold"> <span style="color:#ffdead">₦{{ $gl_balance }} </span> </span>
                                <h4 class="stat-label">Book Balance</h4> 
                                <span class="m-t-lg bold"> <span style="color:#ffdead">₦{{ $book_balance }} </span> </span>
                            </div>
                        </div>

                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-reconcile" aria-expanded="false">Deposit</a></li>
                                <li><a data-toggle="tab" href="#tab-bank-deposit" aria-expanded="false">Fund Your Wallet</a></li>
                                <li><a data-toggle="tab" href="#tab-withdraw" aria-expanded="false">Withdraw</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-reconcile" class="tab-pane active">
                                    <div class="panel-body">
                                        
                                        <?php $uniqid = uniqid('TRADEFI'); ?>
                                            {{-- {{ Form::open(['action' => 'DepositController@store']) }} --}}
                                            
                                            <form name="cpay" action='https://centralpay.nibss-plc.com.ng/CentralPayPlus/pay'> 
                                            

                                           {{ csrf_field() }}

                                            <input type="hidden" name="merchant_id" value="{{ env('CP_MERCHANT_ID') }}" />
                                            <input type="hidden" name="product_id" value="0000000001" />
                                            <input type="hidden" name="product_description" value="TradeFI Account Credit" />
                                             <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label> Deposit Amount </label>
                                                <input type="text" name="fake_amount" id="fake_amount"  placeholder="Enter Here" class="smartinput form-control " required="" aria-required="true">
                                                (A 1.5% fee will be charged on your deposit by NIBSS, capped at N2,000 for deposit of N140,000 and above). Please note that minimum deposit is N100,000
                                                <br><br>
                                                <p class="text-info">Identification is required for deposits of 5M and above</p>
                                                <input type="hidden" name="amount" value="">
                                            </div>
                                        </div>
                                                
                                        </div>
                                            <input type="hidden" name="currency" value="566" />
                                            <input type="hidden" name="transaction_id" value="{{ $uniqid }}" />
                                            <input type="hidden" name="response_url" value="{{ url('/pay') }}" />
                                            <input type="hidden" name="hash" id="hash" value="{{ hash('sha256', env('CP_MERCHANT_ID').'0000000001'.'TradeFI Account Credit'.'100000'.'566'.$uniqid.url('/pay').env('CP_SECRET')) }}" />

                                            <button class="btn  btn-cons m-t-10" style="background-color:#C68B34;border-color:#C68B34;color:#f2f6f7" type="submit">Proceed to Payment</button>

                                            <div class="pull-right">
                                                <span>Secured Payment by NIBSS</span> &nbsp;&nbsp; <img src="{{ asset('assets/images/nibsslogo.png') }}" width="60" alt="Nibss">
                                            </div>

                                            <div class="clearfix"></div>
                                        
                                        </form>
                                    </div>
                                </div>


                                <div id="tab-withdraw" class="tab-pane">
                                    <div class="panel-body">
                                        @include('errors.list')
                                        <form id="form-withdrawal" method="post" class="p-t-15" role="form" action="{{ action('WithdrawalController@store') }}">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Amount to Withdraw</label>
                                                        <input type="text" id="withdrawal-amount" name="Amount" placeholder="Enter Amount" class="form-control smartinput2" required="" aria-required="true">
                                                        {{-- Hidden fields for withdrawals --}}
                                                    <input type="hidden" name="GLIDDebit" value="{{ \DB::table('tblGL')->select('GLRef')
                                                        ->where('CustomerID', auth()->user()->id)
                                                        ->where('AccountTypeID', 1)
                                                        ->first()->GLRef }}">
                                                         <input type="hidden" name="GLIDCredit" value="1">
                                                         <input type="hidden" name="PostDate" value="{{ $tradedate->TradeDate }}" class="form-control" readonly="">
                                                         <input type="hidden" name="ValueDate" value="{{ $tradedate->TradeDate }}" class="form-control" readonly="">

                                                    </div>

                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Bank Name</label>
                                                        {{ Form::select('BankID', ['' => ''] + $banks->pluck('name','id')->toArray(), auth()->user()->profile->bank_detail ?  auth()->user()->profile->bank_detail->bank_id : null,['class' => 'select2_demo_1  form_control', 'style'=>"width: 100%", 'disabled', ]) }}
                                                    </div>
                                                </div>




                                            </div>

                                            <p class="text-info">A withdrawal fee of =N= 52.50 will be charged per withdrawal</p>

                                            <input type="hidden" name="InputterID" id="InputterID" value="{{ auth()->user()->id }}">
                                            <input type="hidden" name="CustomerID" id="CustomerID" value="{{ auth()->user()->id }}">
                                            <input type="hidden" name="PostingTypeID" id="PostingTypeID" value="2">

                                            <button id="withdrawal-submit" class="btn  btn-cons m-t-10" style="background-color:#C68B34;border-color:#C68B34;color:#f2f6f7" type="submit">Withdraw</button>

                                        </form>
                                    </div>
                                </div>

                                <div id="tab-bank-deposit" class="tab-pane">
                                    <div class="panel-body">
                                        @include('errors.list')
                                        <span style="font-size: 13px">Account name: <b class="text-white">CPAM Trade FI Custody</b></span><br>

                                        <span style="font-size: 13px">Account number: <b class="text-white">0026014912</b></span><br>

                                        <span style="font-size: 13px">Bank: <b class="text-white">Stanbic IBTC</b></span><br>

                                        <span style="font-size: 13px">Payment Ref: <b class="text-white">Your TradeFi username and name</b></span><br>

                                        <span style="font-size: 13px" class="text-info"><b>Please note: Put your name and username on TradeFi as payment ref to ensure you get value</b></span> <br><br>
                                        <form id="form-bank-deposit" method="post" class="p-t-15" role="form" action="{{ action('DepositController@bank_deposit') }}" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                
                                            <div class="form-group col-md-6">
                                                            <label class="" for="file-selector2">
                                                                Upload Proof of Payment
                                                            </label>
                                                             <input id="file-selector2" type="file" name="pop">
                                                            {{-- <span class='label label-default' id="upload-file-info2"></span> --}}
                                                        </div>
    
                                            </div>

                                            <input type="hidden" name="CustomerID" id="CustomerID" value="{{ auth()->user()->id }}">

                                            <button class="btn  btn-cons m-t-10" style="background-color:#C68B34;border-color:#C68B34;color:#f2f6f7" type="submit">Submit</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    @else
    @endif

</div>
    <!-- Vendor scripts -->

    <link rel="stylesheet" href="{{ asset('webapp/vendor/amcharts/export.css') }}" type="text/css" media="all" />

    <script src="{{ asset('assets/js/all.js') }}"></script>
    <script  src="{{ asset('js/accounting.min.js') }}"></script>
    <script  src="{{ asset('js/jquery.idle.js') }}"></script>

    <script src="{{ asset('assets/plugins/summernote/js/summernote.min.js') }}" charset="utf-8"></script>

    <script  src="{{ asset('js/jquery.rss.min.js') }}"></script>
    <script src="{{ asset('webapp/scripts/luna.js') }}"></script>
    <script  src="{{ asset('js/sha256.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/autonumeric/autoNumeric.min.js') }}"></script>
    <script src="{{ asset('js/traderoom_countdown.js') }}"></script>
    <script src="{{ asset('js/moment-timezone.js') }}"></script>
    <script src="{{ asset('js/moment-timezone-with-data-2012-2022.js') }}"></script>
    <script src="{{ asset('js/moment-timezone-with-data.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.13/plugins/responsive/responsive.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.10/sweetalert2.min.js"></script>
     <script  src="{{ asset('js/countdown.min.js') }}"></script>
    @stack('scripts')
    <script type="text/javascript">
        // Function for Confirmation modals
        function confirm2(the_title, the_html, form_id, modalClass = ''){
        swal({title:the_title, html: the_html, type:"warning",showCancelButton:!0,confirmButtonClass:"btn btn-primary",cancelButtonClass:"btn btn-danger",confirmButtonText:"Yes",cancelButtonText:"No", animation: false, customClass: modalClass }).then(function(){ $('#'+form_id).submit(); }).catch(swal.noop);
      }

      
        $(function(){
            function display_next_trade_hour(){
           let open_countdown = window.countdown( new Date(), new Date('{{ TradefiUBA\Config::start_trade_time() }}'));
           let close_countdown = window.countdown( new Date(), new Date('{{ \Carbon\Carbon::now()->setTimeFromTimeString("19:00:00") }}'));
           // console.log(countdown.toString());
           let trade_start_time = '{{ TradefiUBA\Config::start_trade_time() }}' ;
           let trade_end_time   = '{{ TradefiUBA\Config::start_trade_time()->setTimeFromTimeString("19:00:00") }}';
           if (( '{{ \Carbon\Carbon::now() }}' < trade_start_time) || ('{{ \Carbon\Carbon::now() }}' > trade_end_time)) {
                $(".countdown-timer").html( '<b>Market Closed!</b> Will Open in: ' + open_countdown.toHTML("strong").toString());
           } else {
                $(".countdown-timer").html( '<b>Market Open!</b> Will Close in: ' + close_countdown.toHTML("strong").toString());
           }
           
        }
setInterval(display_next_trade_hour, 1000);
        });
        $(window).load(function() {
            $(".customloader").fadeOut("slow");
        })
        $('.smartinput').smartInput();
        
        $(document).idle({
          onIdle: function(){
              document.location.href = '/timedout';  
          },
          onActive: function(){},
          idle: {{ (config('session.lifetime') * 60 * 1000)}}
        });

       
 

// new Date() < new Date("{{-- \Carbon\Carbon::parse(TradefiUBA\Config::start_trade_time()) --}}") || 
        // setInterval(display_next_trade_hour, 5000);
        // steps
        // checkif today is a wekend then check if next trade date has
        
        
    </script>

    <!-- Styles -->
    <style>
        #chartdiv,
        #bonds-chart, #tbills-chart {
            width: 95%;
            height: 250px;
        }
        #general-chart {
            width: 95%;
            height: 300px;
        }

    </style>

    <script>
        $(function() {

            $("ul#ticker01").liScroll();

            $("#demo4").bootstrapNews({
                newsPerPage: 1,
                autoplay: true,
                pauseOnHover: true,
                navigation: false,
                direction: 'up',
                newsTickerInterval: 5000,
                onToDo: function() {
                    //console.log(this);
                }
            });

           
        });

         $('[id=fake_amount]').keyup(function(e) {
                console.log('keyedup');
                e.preventDefault();
                $initial_amount = $('[name=fake_amount]').val() ;

                $amount = parseInt($initial_amount) * 100;
                $('[name=amount]').val($amount);
                var uniqid = $('[name=transaction_id]').val();
                // console.log(uniqid)
                 $('#hash').val(sha256('{{ env('CP_MERCHANT_ID') }}'+'0000000001'+'TradeFI Account Credit'+$amount+'566'+uniqid+'{{ url('/pay') }}'+'{{ env('CP_SECRET') }}'));

               
            });   
         
    </script>

    

    <script type="text/javascript">
        $(function() {

            $('.datatable').DataTable({
                dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
                order: [],
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                buttons: [{
                    extend: 'copy',
                    className: 'btn-sm'
                }, {
                    extend: 'excel',
                    title: 'TradeFi Excel Export',
                    className: 'btn-sm'
                }, {
                    extend: 'pdf',
                    title: 'TradeFi Pdf Export',
                    className: 'btn-sm'
                }, {
                    extend: 'print',
                    className: 'btn-sm'
                }]
            });
            $('#table1').DataTable({});
            $('#table2').DataTable({});
            $(".select2_demo_1").select2({
                placeholder: "Select One",
                allowClear: true
            });
            $(".select2_demo_2").select2({
                placeholder: "Select a state",
                allowClear: true
            });

            var options = {
         todayHighlight: true,
         autoclose: true,
         // endDate: today,
         format: 'yyyy-mm-dd'
     };
     $('.dp').datepicker(options);

            $("#demo3").bootstrapNews({
                newsPerPage: 1,
                autoplay: true,
                pauseOnHover: true,
                navigation: false,
                direction: 'up',
                newsTickerInterval: 2500,

                onToDo: function() {
                    //console.log(this);
                }
            });
        });
    </script>

    <script>
        var globalOptions = {
            responsive: true,
            legend: {
                labels: {
                    fontColor: "#90969D"
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: "#90969D"
                    },
                    gridLines: {
                        color: "#37393F"
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontColor: "#90969D"
                    },
                    gridLines: {
                        color: "#37393F"
                    }
                }]
            }
        };

    </script>



    <!-- Chart code -->
   

    <script type="text/javascript">
        $(window).load(function() {
            $(".pace").fadeOut("slow");

        });

        $(function() {
            Pace.stop();
            Pace.options = {
                ajax: false, // disabled
                document: false, // disabled
                eventLag: false, // disabled
                elements: {
                    selectors: ['body'],
                },
                restartOnRequestAfter: false,
                restartOnPushState: false
            };

            
            // withdrawal security
            $('#withdrawal-submit').click(function(e) {
                AutoNumeric.unformat($('.smartinput2').val(), { currencySymbol : '₦ '});
                let amount = AutoNumeric.unformat($('.smartinput2').val(), { currencySymbol : '₦ '});
                console.log(AutoNumeric.unformat($('.smartinput2').val(), { currencySymbol : '₦ '}));
                $('.smartinput2').val(amount);
                e.preventDefault();
                $(this).attr('disabled', 'disabled');
                if(amount == '' || amount <= 0){
                    // alert('Enter an amount to withdraw');
                    return false;
                }
                var _this = $(this);
                   swal({
                      title: 'Enter Pin',
                      text:'Enter your trading pin to continue',
                      input: 'password',
                      animation: false,
                      width: '350px',
                      color: '#44B366',
                      customClass: 'animated tada',
                      showCancelButton: true,
                      confirmButtonText: 'Proceed',
                      confirmButtonColor:   '#44B366',
                      inputPlaceholder : 'Enter your Trading pin',
                      showLoaderOnConfirm: true,
                      preConfirm: function (password) {
                         _this.attr('disabled', 'disabled');
                            var promise = new Promise(function (resolve, reject) {
                                $.ajax({
                                    url: '/withdrawals/check-password',
                                    type: 'POST',
                                    data: {password: password},
                                })
                                .done(function() {
                                    // $('#withdrawal-submit').removeAttr('disabled');
                                    
                                    resolve();

                                })
                                .fail(function() {
                                   
                                    // $('#withdrawal-submit').removeAttr('disabled');
                                     reject('Wrong Pin');
                                })
                                .always(function() {
                                    console.log("complete");
                                });
                            });
                            promise.then(function(success){
                               $('#form-withdrawal').submit();
                            }).catch(function(error){
                                $('#withdrawal-submit').removeAttr('disabled');
                                swal.disableLoading();
                                swal.showValidationError(error);
                            });
                            return promise;

                          },
                          allowOutsideClick: false,
                          onClose: function(){
                             $('#withdrawal-submit').removeAttr('disabled');
                            // alert('closed')
                          }
                    });
            });
             });
    </script>

 <script>
        AutoNumeric.multiple('.smartinput2', {
            currencySymbol : '₦ ',
            decimalCharacter : '.',
            unformatOnSubmit: true,
            modifyValueOnWheel: false,
            minimumValue: 0,
            decimalPlaces: 2,
            decimalPlacesRawValue: 0,
        });

             setInterval(function(){
                $('.current-time').html(moment.tz('Africa/Lagos').format('MMM Do YYYY, h:mm:ss a'));
             },1000)
    

             
    $(document)
  .ajaxStart(function () {
    $('#spinner').show();
  })
  .ajaxStop(function () {
    $('#spinner').hide();
  });

              $(document).on('ready',function(){
          // $('#spinner').show();
          // Pace.on('start', function() {
          //   $('#spinner').show();
          // });
          // Pace.on('restart', function() {
          //   $('#spinner').show();
          // });
          // Pace.on('stop', function() {
          //   $('#spinner').hide();
          // });
          // Pace.on('done', function() {
          //   $('#spinner').hide();
          // });
        });
        $(window).on('beforeunload', function(){
          $('#spinner').show();
          setTimeout(function(){
            $('#spinner').hide();
          }, 5000);
        });
      </script>



    {{-- notifications --}}
    @if(session('success'))
<script>
    // alert('success')
    toastr.success('{!! session('success') !!} ');
</script>

@elseif(session('error'))
<script>
      toastr.error('{!! session('error') !!}');
</script>
@elseif(session('info'))
<script>
      toastr.info('{!! session('info') !!}');
</script>
@elseif(session('warning'))
<script>
      toastr.warning('{!! session('warning') !!}');
</script>
@endif


<script>
    
// Start of Async Drift Code

// !function() {
//   var t;
//   if (t = window.driftt = window.drift = window.driftt || [], !t.init) return t.invoked ? void (window.console && console.error && console.error("Drift snippet included twice.")) : (t.invoked = !0, 
//   t.methods = [ "identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on" ], 
//   t.factory = function(e) {
//     return function() {
//       var n;
//       return n = Array.prototype.slice.call(arguments), n.unshift(e), t.push(n), t;
//     };
//   }, t.methods.forEach(function(e) {
//     t[e] = t.factory(e);
//   }), t.load = function(t) {
//     var e, n, o, i;
//     e = 3e5, i = Math.ceil(new Date() / e) * e, o = document.createElement("script"), 
//     o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + i + "/" + t + ".js", 
//     n = document.getElementsByTagName("script")[0], n.parentNode.insertBefore(o, n);
//   });
// }();
// drift.SNIPPET_VERSION = '0.3.1';
// drift.load('2mb7mv8tuuzm');

// End of Async Drift Code
</script>
</body>

</html>




