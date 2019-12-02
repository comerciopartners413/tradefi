<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>
    <link rel="icon" href="{{ asset('assets/favicon.ico" type="image/x-icon') }}" />
    <!-- Page title -->
    <title>{{ config('app.name', 'Comercio\'s TradeFI') }}</title>

    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('webapp/vendor/jquery/custom/li-scroller.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('webapp/styles/custom1.css') }}">
    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ asset('webapp/vendor/fontawesome/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/vendor/animate.css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/vendor/bootstrap/css/bootstrap.css') }}" />

    <link rel="stylesheet" href="{{ asset('webapp/vendor/bootstrap/css/bootstrap-notifications.min.css') }}" />
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">
    <link rel="stylesheet" href="{{ asset('webapp/vendor/datatables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/vendor/select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/vendor/sweetalert2/sweetalert2.min.css') }}">

    <!-- App styles -->
    <link rel="stylesheet" href="{{ asset('webapp/styles/pe-icons/pe-icon-7-stroke.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/styles/pe-icons/helper.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/styles/stroke-icons/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/vendor/toastr/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('webapp/styles/scrollbar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.2.0/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.2.0/css/ion.rangeSlider.skinModern.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     @stack('styles')

</head>

<body>
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

        .custom-close {
                font-size: 20px;
    vertical-align: middle;
    margin-left: 10px;
        }

        h3.m-b-none.server1 {
    font-size: 20px;
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
                            <img src="https://arkounting.com.ng/tradefiprocess/webapp/images/TFI Official Logo no background.jpg" width="80px" align="middle"></div>
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

                            @yield('simulation_balance')

                            <li class="dropdown">
                            <a href="#" data-toggle="modal" data-target="#fundmodal" style="color: mediumseagreen;text-align: center"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;Available Balance :
                        <span style="color:chocolate"> 
                        {{-- {{ number_format(auth()->user()->profile->gls->first()->ClearedBalance, 2) }} --}}
                        <gl-component main_balance="{{ number_format(auth()->user()->gls->first()->ClearedBalance, 2) }}" :user_id="{{ auth()->user()->id }}">
                            {{ number_format(auth()->user()->gls->first()->ClearedBalance, 2) }}
                        </gl-component>
                         </span> 
                        </a>
                        </li>
                            @endif
                        {{--  --}}
                        
                            <notification :unreads="{{ auth()->user()->unreadNotifications }}" 
                                :user-id="{{ auth()->user()->id }}"
                                ></notification>
                       
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
                        <li class="profil-link">
                            <a href="#" data-toggle="dropdown" class=" dropdown-toggle">
                                {{-- <img src="images/profile.jpg" class="img-circle" alt=""> --}}
                                <span style="display: inline-block;" class="abbr-avatar">{{ auth()->user()->abbreviation(auth()->user()->profile->firstname) }}</span>
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
        <aside class="navigation">
            <nav>

                <div class="visible-xs balance-mobile">
                    <p>Cash Balance</p>
                    <div class="amount" style="cursor: pointer" data-toggle="modal" data-target="#fundmodal">
                        <gl-component main_balance="{{ number_format(auth()->user()->gls->first()->ClearedBalance, 2) }}" :user_id="{{ auth()->user()->id }}">
                            {{ number_format(auth()->user()->gls->first()->ClearedBalance, 2) }}
                        </gl-component>
                    </div>
                    <p>
                        <a href="/logout">LOG OUT</a>
                    </p>
                </div>
                <ul class="nav luna-nav">
                    <!-- <li class="nav-category">
                    Home Section
                </li>-->



                    <li class="active">
                        <a href="{{ route('home') }}"> <i class="pe-7s-display1 c-accent"> </i>&nbsp; My Dashboard</a>
                    </li>
                    <!--  <li class="active">
                    <a href="#monitoring" data-toggle="collapse" aria-expanded="true">
                        Analytics<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="monitoring" class="nav nav-second collapse in">
                        <li class="active"><a href="{{ route('home') }}"> <i class="pe-7s-display1 c-accent"> </i>&nbsp; My Dashboard</a></li>

                    </ul>
                </li>-->
                    <!--  <li class="nav-category">
                   Trading Section
                </li>  -->
                    <li>
                        <a href="#uielements" data-toggle="collapse" aria-expanded="false">
                       My Trade Room<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                        <ul id="uielements" class="nav nav-second collapse">
                            <li><a href="{{ route('trade-room.index') }}"><i class="fa fa-money"></i>&nbsp; Trade Room</a></li>
                            
                             @if(auth()->user()->admin)
                            <li>
                                <a href="{{ route('trade-room.create') }}"><i class="fa fa-money"></i>&nbsp;Create Trade</a>
                            </li>
                             @endif
                            <li class=""><a href="{{ route('easymode') }}"><i class="fa fa-money "></i>&nbsp; Easy Mode</a></li>
                            <li class="divider"></li>
                            {{-- <li><a href="bondsfiltered.html">FGN Bonds</a></li>
                            <li><a href="billsfiltered.html">Treasury bills</a></li> --}}

                        </ul>
                    </li>
                     @if(!auth()->user()->admin)
                    <li>
                        <a href="#tables" data-toggle="collapse" aria-expanded="false">
                        My Information<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                        <ul id="tables" class="nav nav-second collapse">
                            <li>
                                <a href="{{ route('profile.index') }}"> <i class="pe-7s-user"> </i>&nbsp;&nbsp; My Profile</a>
                            </li>
                            <li><a href="{{ route('portfolio.index') }}"><i class="pe-7s-wallet"></i>&nbsp; My Portfolio</a></li>
                            <li><a href="{{ route('blotter.index') }}"><i class="pe-7s-display2"></i>&nbsp; My Blotter</a></li>
                            <li><a href="{{ route('transactions.index') }}"><i class="pe-7s-date"></i>&nbsp; My Transactions</a></li>
                            <li><a href="{{ url('report') }}"><i class="fa fa-line-chart"></i>&nbsp;My Reports</a></li>
                            
                        </ul>
                    </li>

                     <li class="">
                        <a href="{{ url('/forum') }}"> <i class="pe-7s-users c-accent"> </i>&nbsp; Forum</a>
                    </li>
                    
                    @endif

                   @if(auth()->user()->admin)
                   <li>
                        <a href="#users" data-toggle="collapse" aria-expanded="false">
                        Users <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                        <ul id="users" class="nav nav-second collapse">
                            <li>
                                <a href="{{ url('admin/users') }}"> <i class="fa fa-user "> </i>&nbsp; View Users<br></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#deposits" data-toggle="collapse" aria-expanded="false">
                        Dep. &amp; Withdrawals <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                        <ul id="deposits" class="nav nav-second collapse">
                            <li>
                                <a href="{{ url('admin/deposits') }}">Deposits</a>
                            </li>

                            <li>
                                <a href="{{ url('/withdrawals') }}">Withdrawals</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#dash-data" data-toggle="collapse" aria-expanded="false">
                        Dashboard Data <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                        <ul id="dash-data" class="nav nav-second collapse">
                            <li><a href="{{ route('admin.macros.index') }}"><i class="fa sticky-note-o"></i>&nbsp;Update Macros</a></li>
                            <li><a href="{{ route('admin.fx.index') }}"><i class="fa sticky-note-o"></i>&nbsp;Update FX Prices</a></li>
                            <li>
                        </ul>
                    </li>
                    <li>
                        <a href="#setup" data-toggle="collapse" aria-expanded="false">
                        Setup <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                        <ul id="setup" class="nav nav-second collapse">
                            <li>
                                <a href="{{ route('securities.create') }}"><i class="fa sticky-note-o"></i>&nbsp;
                                    Add Instruments
                                </a>
                            </li>
                            
                            <li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('/download-trades')}}" >
                        Download Trades for Stanbic </a>
                        
                </li>
                    </li>
                   @endif
                    <!-- <li class="nav-category">
                    Support Section
                </li> -->
                    <li>
                        <a href="#extras1" data-toggle="collapse" aria-expanded="false">
                        Support <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                        <ul id="extras1" class="nav nav-second collapse">
                            <li>
                                <a href="{{ route('ticket.index') }}"> <i class="fa fa-sticky-note-o "> </i>&nbsp; Tickets</a>
                            </li>
                            <li>
                                <a href="faqs.html"> <i class="fa fa-support"> </i>&nbsp; FAQs</a>
                            </li>

                        </ul>
                    </li>
                    @if(auth()->user()->admin)
                    <li>
                        <a href="#" target="_blank">
                            <!-- <span class="badge pull-right">2</span> -->
                            <i class="fa fa-line-chart"></i>&nbsp; Reports <span class="nav-icon"> </span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="/tradefi-guide" target="_blank">
                            <!-- <span class="badge pull-right">2</span> -->
                            TradeFi Guide &nbsp; <span class="nav-icon"> <i class="fa fa-external-link"></i> </span>
                        </a>
                    </li>

                    <li class="nav-info">
                        <div align="center"> <img src="{{ asset('webapp/images/genie1.png') }}" width="100px" align="middle">
                            <br/>
                            <div class="m-t-xs">
                                <!--  <span class="security">FGN Bonds  </span> interests has marked up by <span class="gr"> 3%  </span>in the <span class="c-white"> last 7days...</span>It will be wise to have a peice of the pie.  -->
                                <span class="security"> How can I advise you? </span> </div>
                        </div>
                    </li>
                </ul>

            </nav>
            <!--   <div align="center">  <img  src="images/genie1.png" width="120px" align="middle">  </div>  -->
        </aside>
        <!-- End navigation-->

        <!-- Main content-->
        <section class="content" id="contentdiv">
            @yield('content')
            

            