@extends('layouts.app')

@push('styles')
    <style>
    body {
        font-size: 1.5rem !important;
    }

    .grey-class{
            background: grey !important;
            cursor: not-allowed;
    }

    .updated-content-notifier {
        width: 300px;
    display: none;
    margin: auto;
    position: fixed;
    z-index: 5;
    cursor: pointer;
    top: -100px;
    background: gold;
    color: #24262d;
    font-weight: bold;
    padding: 10px 20px;
    text-align: center;
    border-radius: 25px;
    left: 0;
    right: 0;
    transition: top .2s ease-in-out;
    }
        .security-name {
                color: #fff;
        font-weight: bold;
        /* margin-top: 10px; */
        font-size: 18px;
        }
        .exceeded {
            background-color: #f84c4c;
            color: #fff;
        }

        .tradecard-container .m-t-none {
            width: 120px
        }

        .close-btn {
            border-radius: 50% !important;
            min-width: 30px !important;
            padding: 0;
            height: 30px;
            line-height: 30px;
            color: #fff;
        }
        .inline-block {
            display: inline-block;
            /*margin-bottom: 10px;*/
            font-weight: 700;
        }

        .inline-block > p{
            float: left;
            margin-bottom: 0;
            margin-right: 25px;
        }

        .inline-block .value {
            margin-left: 3px;
        }

        .volume-error {
            display: block;
            text-align: center;
            font-weight: bold;
        }

        hr {
            margin: 10px 0;
        }

        .panel.panel-filled {
            overflow-y: hidden;
    /*height: auto !important;*/
        }
    </style>
    <!--flot -->

    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="webapp/flot/excanvas.min.js'"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="{{ asset('webapp/flot/jquery.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('webapp/flot/jquery.flot.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('webapp/flot/jquery.flot.time.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('webapp/flot/jquery.flot.selection.js') }}"></script>

    <!-- -->

    <!-- bin/jquery.slider.min.css -->
    <link rel="stylesheet" href="{{ asset('webapp/vendor/slider/css/jslider.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('webapp/vendor/slider/css/jslider.blue.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('webapp/vendor/slider/css/jslider.plastic.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('webapp/vendor/slider/css/jslider.round.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('webapp/vendor/slider/css/jslider.round.plastic.css') }}" type="text/css">
    <!-- end -->

    

    <!-- bin/jquery.slider.min.js') }} -->
    <script type="text/javascript" src="{{ asset('webapp/vendor/slider/js/jshashtable-2.1_src.js') }}"></script>
    <script type="text/javascript" src="{{ asset('webapp/vendor/slider/js/jquery.numberformatter-1.2.3.js') }}"></script>
    <script type="text/javascript" src="{{ asset('webapp/vendor/slider/js/tmpl.js') }}"></script>
    <script type="text/javascript" src="{{ asset('webapp/vendor/slider/js/jquery.dependClass-0.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('webapp/vendor/slider/js/draggable-0.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('webapp/vendor/slider/js/jquery.slider.js') }}"></script>
    <script src="{{ 'webapp/vendor/chart.js/dist/Chart.min.js' }}"></script>
    <!-- end -->

    <style>
        #contentdiv {
            margin-right:300px;
        }
    </style>
@endpush
@section('content')
<div class="updated-content-notifier">Update Available. Click to refresh</div>
 <div class="container-fluid" id="normalmodediv" style="/*position:fixed;margin-right:inherit */">
    <div id="trademodal-event">
    {{-- @{{ gl_balance }} --}}
                <div class="row">
               {{ Form::open(['action' => 'TradeRoomController@index2']) }}
                    <div class="col-md-3 col-xs-4">
                        <label>Security Type</label>
                        <select name="SecurityType" class="select2_demo_1 form-control"  style="width: 100%">
                            <option {{ isset($ProductID) && $ProductID == 3 ? 'selected' : '' }} value="3">All</option>
                            <option {{ isset($ProductID) && $ProductID == 1 ? 'selected' : '' }} value="1">Bonds</option>
                            <option {{ isset($ProductID) && $ProductID == 2 ? 'selected' : '' }} value="2">TBills</option> 

                        </select>
                    </div>
                    <div class="col-md-3 col-xs-4">
                         <div class="form-group">
                <div class="controls">
                    {{ Form::label('From', 'From') }}
                    <div class="input-group date dp">
                        {{ Form::text('From', null, ['class' => 'form-control', 'placeholder' => 'Pick Date',]) }}
                        <span class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </span>
                    </div>
                </div>
            </div>
                    </div>
                    <div class="col-md-3 col-xs-4">
                         <div class="form-group">
                <div class="controls">
                    {{ Form::label('To', 'To') }}
                    <div class="input-group date dp">
                        {{ Form::text('To', null, ['class' => 'form-control', 'placeholder' => 'Pick Date',]) }}
                        <span class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </span>
                    </div>
                </div>
            </div>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <button type="submit" class="btn btn-success col-xs-12" style="margin-top: 25px">Search</button>
                    </div>
               {{ Form::close() }}
               

                </div>

                <br/>
                <div class="row">
                    <div class="col-md-12 scrollbar" style="height:1000px" id="style-9">

                        <!-- trade card -->
                        <div class="row" id="tradecard-container">

                            {{-- Start Trade Card --}}
                            @foreach($tradelist as $tl)
                                <div class="col-md-4 col-xs-6">

                                <div class="panel panel-filled " style="border-radius:10px; min-height: 310px">
                                    <div class="panel-body">
                                        
                                        <h4 class="m-t-none pull-left" style="width: 100% ;  "><a href="#">{{ $tl->Description }}</a></h4>

                                        <div class="clearfix"></div>

                                        {{-- <div class="m-b-xs c-white small">Sell Quantity: {{ number_format($tl->BuyQuantity) }}</div>
                                           <div class="m-b-xs c-white small">Buy Quantity: {{ number_format($tl->SellQuantity) }}</div> --}}

                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                <h3 class="m-b-none server1 pull-left" style="    margin-top: 0; margin-right: 10px;
                                                font-size: 16px;"><span style="color:#BE362E"><i class=""></i></span><span style="color:#FFD700">{{-- number_format($tl->Max - $tl->Min, 2) --}}</span>
                                                </h3>

                                                <div class="pull-left" style="    margin-right: 10px;"><span style="color:#228b22">H {{ number_format($tl->Max, 2) }}</span></div>
                                                <div class="pull-left"><span style="color:#BE362E">L {{ number_format($tl->Min, 2) }}</span></div>

                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="col-md-10 col-xs-12">

                                                <a href="#" data-toggle="modal" data-target="#myModal">
                                                    <div style="margin-top: 15px; margin-bottom: 10px">
                                                        <canvas class="lineOptions" height="250" data-maturity="{{ $tl->MaturityDate }}"></canvas>
                                                    </div>
                                                </a>
                                            </div>
                                            

                                        </div>
                                        <!-- row -->

                                        <div class="row">
                                            <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                <!--  <h4 class="m-b-none server1">  iSell </h4> -->
                                                <a href="#"  class="btn-link trade-modal-toggler-for-sell" data-security-id="{{ $tl->SecurityID }}">
                                                    <h4 class="m-b-none server1">iSell </h4>
                                                </a>

                                                <h5> <span class="usage11">{{number_format( $tl->BuyYield, 2) }}</span></h5>
                                            </div>
                                            <div class="col-md-2 col-xs-2" align="center">&nbsp;</div>
                                            
                                            @if($tl->buy_quantity <= env('APP_MIN_BUY_QUANTITY')) 
                                            <div class="col-md-5 col-xs-5 tradeCard2 grey-class" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                <!--     <h4 class="m-b-none server1">  iBuy </h4> -->
                                                <a href="#"  class=" btn-link " data-security-id="{{ $tl->SecurityID }}">
                                                    <h4 class="m-b-none server1">iBuy </h4>
                                                </a>

                                                <h5> <span class="usage12">{{ number_format($tl->SellYield, 2) }}</span> </h5>
                                            </div>
                                            @else
                                                <div class="col-md-5 col-xs-5 tradeCard2 " align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                    <!--     <h4 class="m-b-none server1">  iBuy </h4> -->
                                                    <a href="#"  class="btn-link trade-modal-toggler-for-buy" data-security-id="{{ $tl->SecurityID }}">
                                                        <h4 class="m-b-none server1">iBuy </h4>
                                                    </a>

                                                    <h5> <span class="usage12">{{ number_format($tl->SellYield, 2) }}</span> </h5>
                                                </div>
                                            @endif
                                        </div>

                                        <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                    </div>

                                </div>
                            </div>
                            @endforeach

                            {{-- End Trade Card --}}
                            <!-- col4 -->

                        </div>
                        <!-- row -->

                        <!-- trade card-->
                    </div>
                    <!--col8 -->

                </div>

            </div>
            <!-- end complex method -->

            <!-- easy method -->
            <div class="container-fluid" id="easymodediv" style="display:none !important">

                <div class="row" align="center">

                    <div class="col-md-12">
                        <div class="layout-slider-settings">
                            <label><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Lets get you started.....How much do you wish to invest in this trade?</label>
                        </div>
                        <br/>
                        <div class="layout-slider">
                            <input id="Slider2" type="slider" name="price" value="5000;50000" />
                        </div>
                        <script type="text/javascript" charset="utf-8">
                            jQuery("#Slider2").slider({
                                from: 5000,
                                to: 150000,
                                step: 1000,
                                dimension: '&nbsp;₦'
                            });
                        </script>

                    </div>

                    <br/>
                    <br/>

                    <div class="col-md-12">

                        <br/>
                        <br/>
                        <label> <i class="fa fa-question-circle" aria-hidden="true"></i>&nbsp;What Security Type would you like to buy/sell?</label>
                        <select class="select2_demo_1 form-control" style="width: 30%" onchange="contentselection()">
                            <option value="0" selected disabled>Select one Security</option>
                            <option value="1">Treasury bills</option>
                            <option value="2">Bonds</option>

                        </select>

                        <br/>
                        <br/>
                        <div style="display: none;background: #232526;  /* fallback for old browsers */
                            background: -webkit-linear-gradient(to left, #414345, #232526);  /* Chrome 10-25, Safari 5.1-6 */
                            background: linear-gradient(to left, #414345, #232526); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                            ; padding: 10px; border-radius: 10px;" id="sc">

                            <br/>
                            <br/>

                            <label> <i class="fa fa-yelp" aria-hidden="true"></i>&nbsp;Below are the securities that can be purchased/sold based on the amount you want to invest</label>

                            <br/>
                            <br/>
                            <div class="row">

                                <!--  <div class="col-md-2">

                           </div>-->

                                <div class="col-md-8">
                                    <label>
                                        <i class="fa fa-question-circle" aria-hidden="true"></i>&nbsp;How long would you like to invest for ?</label>
                                    <select class="select2_demo_1 form-control" style="width: 30%">
                                        <option value="0" selected disabled>Select Benchmark</option>
                                        <option value="1">90</option>
                                        <option value="2">180</option>
                                        <option value="2">364</option>
                                    </select>
                                </div>
                                <!-- <div class="col-md-3 col-xs-12"><label>From</label>
                              <input type="date" class="form-control" id="exampleInputName" placeholder="From">
                           </div>
                            <div class="col-md-3 col-xs-12"><label>To</label>
                              <input type="date" class="form-control" id="exampleInputName" placeholder="To">
                            </div> -->
                                <div class="col-md-2 col-xs-12">
                                    <button class="btn  btn-cons m-t-10" style="background-color:#C68B34;border-color:#C68B34;color:#f2f6f7" type="submit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                                </div>
                                <div class="col-md-2 col-xs-3">

                                </div>

                            </div>
                            <hr/>
                            <br/>
                            <br/>
                            <!-- maturities content 1 -->
                            <div class="row" id="mc1" style="display: none">
                                <div class="col-md-4">

                                    <div class="panel panel-filled " style="border-radius:10px;">
                                        <div class="panel-body">
                                            <div class="btn-group pull-right m-b-md">
                                                <button class="btn btn-default btn-xs" style="color: #fff">Show Details</button>
                                                <!-- <button class="btn btn-default btn-xs">Order</button> -->
                                            </div>
                                            <h5 class="m-b-none"><a href="#"> FGN MAR 2036</a></h5>

                                            <div class="m-b-xs c-white small">100,000</div>

                                            <div class="row">
                                                <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                    <!--   <h4 class="m-b-none server1">  iSell </h4> -->
                                                    <a href="#" data-toggle="modal" data-target="#trademodal" class="btn-link">
                                                        <h4 class="m-b-none server1">iSell </h4></a>

                                                    <h5> <span class="usage3">12</span></h5>
                                                </div>
                                                <div class="col-md-2 col-xs-2" align="center">&nbsp;</div>
                                                <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                    <!--  <h4 class="m-b-none server1">  iBuy </h4> -->
                                                    <a href="#" data-toggle="modal" data-target="#trademodal" class="btn-link">
                                                        <h4 class="m-b-none server1">iBuy </h4></a>

                                                    <h5> <span class="usage9">12</span> </h5>
                                                </div>
                                            </div>

                                            <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                        </div>

                                    </div>
                                </div>
                                <!-- col4 -->

                                <div class="col-md-4">

                                    <div class="panel panel-filled " style="border-radius:10px;">
                                        <div class="panel-body">
                                            <div class="btn-group pull-right m-b-md">
                                                <button class="btn btn-default btn-xs" style="color: #fff">Show Details</button>
                                                <!-- <button class="btn btn-default btn-xs">Order</button> -->
                                            </div>
                                            <h5 class="m-b-none"><a href="#"> FGN MAR 2026</a></h5>

                                            <div class="m-b-xs c-white small">100,000</div>

                                            <div class="row">
                                                <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                    <h4 class="m-b-none server1">  iSell </h4>

                                                    <h5> <span class="usage3">12</span></h5>
                                                </div>
                                                <div class="col-md-2 col-xs-2" align="center">&nbsp;</div>
                                                <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                    <h4 class="m-b-none server1">  iBuy </h4>

                                                    <h5> <span class="usage9">12</span> </h5>
                                                </div>
                                            </div>

                                            <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                        </div>

                                    </div>
                                </div>
                                <!-- col4 -->

                                <div class="col-md-4">

                                    <div class="panel panel-filled " style="border-radius:10px;">
                                        <div class="panel-body">
                                            <div class="btn-group pull-right m-b-md">
                                                <button class="btn btn-default btn-xs" style="color: #fff">Show Details</button>
                                                <!-- <button class="btn btn-default btn-xs">Order</button> -->
                                            </div>
                                            <h5 class="m-b-none"><a href="#"> FGN MAR 2037</a></h5>

                                            <div class="m-b-xs c-white small">100,000</div>

                                            <div class="row">
                                                <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                    <h4 class="m-b-none server1">  iSell </h4>

                                                    <h5> <span class="usage3">12</span></h5>
                                                </div>
                                                <div class="col-md-2 col-xs-2" align="center">&nbsp;</div>
                                                <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                    <h4 class="m-b-none server1"> iBuy </h4>

                                                    <h5> <span class="usage9">12</span> </h5>
                                                </div>
                                            </div>

                                            <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                        </div>

                                    </div>
                                </div>
                                <!-- col4 -->

                                <div class="col-md-4">

                                    <div class="panel panel-filled " style="border-radius:10px;">
                                        <div class="panel-body">
                                            <div class="btn-group pull-right m-b-md">
                                                <button class="btn btn-default btn-xs" style="color: #fff">Show Details</button>
                                                <!-- <button class="btn btn-default btn-xs">Order</button> -->
                                            </div>
                                            <h5 class="m-b-none"><a href="#"> FGN MAR 2066</a></h5>

                                            <div class="m-b-xs c-white small">100,000</div>

                                            <div class="row">
                                                <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                    <h4 class="m-b-none server1">  iSell </h4>

                                                    <h5> <span class="usage3">12</span></h5>
                                                </div>
                                                <div class="col-md-2 col-xs-2" align="center">&nbsp;</div>
                                                <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                    <h4 class="m-b-none server1">  iBuy </h4>

                                                    <h5> <span class="usage9">12</span> </h5>
                                                </div>
                                            </div>
                                            <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                        </div>

                                    </div>
                                </div>
                                <!-- col4 -->

                                <div class="col-md-4">

                                    <div class="panel panel-filled " style="border-radius:10px;">
                                        <div class="panel-body">
                                            <div class="btn-group pull-right m-b-md">
                                                <button class="btn btn-default btn-xs" style="color: #fff">Show Details</button>
                                                <!-- <button class="btn btn-default btn-xs">Order</button> -->
                                            </div>
                                            <h5 class="m-b-none"><a href="#"> FGN MAR 2019</a></h5>

                                            <div class="m-b-xs c-white small">100,000</div>

                                            <div class="row">
                                                <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                    <h4 class="m-b-none server1">  iSell </h4>

                                                    <h5> <span class="usage3">12</span></h5>
                                                </div>
                                                <div class="col-md-2 col-xs-2" align="center">&nbsp;</div>
                                                <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                    <h4 class="m-b-none server1">  iBuy </h4>

                                                    <h5> <span class="usage9">12</span> </h5>
                                                </div>
                                            </div>

                                            <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                        </div>

                                    </div>
                                </div>
                                <!-- col4 -->

                                <div class="col-md-4">

                                    <div class="panel panel-filled " style="border-radius:10px;">
                                        <div class="panel-body">
                                            <div class="btn-group pull-right m-b-md">
                                                <button class="btn btn-default btn-xs" style="color: #fff">Show Details</button>
                                                <!-- <button class="btn btn-default btn-xs">Order</button> -->
                                            </div>
                                            <h5 class="m-b-none"><a href="#"> FGN MAR 2017</a></h5>

                                            <div class="m-b-xs c-white small">100,000</div>

                                            <div class="row">
                                                <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                    <h4 class="m-b-none server1">  iSell </h4>

                                                    <h5> <span class="usage3">12</span></h5>
                                                </div>
                                                <div class="col-md-2 col-xs-2" align="center">&nbsp;</div>
                                                <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                    <h4 class="m-b-none server1">  iBuy </h4>

                                                    <h5> <span class="usage9">12</span> </h5>
                                                </div>
                                            </div>

                                            <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                        </div>

                                    </div>
                                </div>
                                <!-- col4 -->

                            </div>
                            <!-- end maturities content 1 -->

                            <!-- maturities content 2 -->

                            <div class="row" id="mc2" style="display: none">
                                <div class="col-md-12 scrollbar" style="/*height:1000px*/" id="style-9">

                                    <!-- trade card -->
                                    <div class="row">

                                        <div class="col-md-4">

                                            <div class="panel panel-filled " style="border-radius:10px;">
                                                <div class="panel-body">
                                                    <div class="btn-group pull-right m-b-md">
                                                        <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal">Show Details</button>

                                                        <!--    <button class="btn btn-default btn-xs">Order</button> -->
                                                    </div>
                                                    <h5 class="m-b-none"><a href="#"> 5-Feb-2023</a></h5>

                                                    <div class="m-b-xs c-white small">20,000</div>

                                                    <!--   <div class="row">
                                <div class="col-md-8">

                                    <a href="#" data-toggle="modal" data-target="#myModal">  <div class="flot-chart-analytics">
                                <div class="flot-chart-content" id="metric1"></div> </a>
                            </div>
                                </div>
                                <div class="col-md-4">
                                   <h3 class="m-b-none server1"><span style="color:#BE362E"><i class=""></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

                                           <div class=""><span style="color:#228b22">H 18.89</span></div>
                                            <div class=""><span style="color:#BE362E">L 16.38</span></div>
                                </div>

                            </div> -->
                                                    <!-- row -->

                                                    <div class="row">
                                                        <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                            <!--  <h4 class="m-b-none server1">  iSell </h4> -->
                                                            <a href="#" data-toggle="modal" data-target="#trademodal" class="btn-link">
                                                                <h4 class="m-b-none server1">iSell </h4></a>

                                                            <h5> <span class="usage11">12</span></h5>
                                                        </div>
                                                        <div class="col-md-2 col-xs-2" align="center">&nbsp;</div>
                                                        <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                            <!--     <h4 class="m-b-none server1">  iBuy </h4> -->
                                                            <a href="#" data-toggle="modal" data-target="#trademodal" class="btn-link">
                                                                <h4 class="m-b-none server1">iBuy </h4></a>

                                                            <h5> <span class="usage12">12</span> </h5>
                                                        </div>
                                                    </div>

                                                    <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                                </div>

                                            </div>
                                        </div>
                                        <!-- col4 -->

                                        <div class="col-md-4">

                                            <div class="panel panel-filled " style="border-radius:10px;">
                                                <div class="panel-body">
                                                    <div class="btn-group pull-right m-b-md">
                                                        <button class="btn btn-default btn-xs">Show Details</button>
                                                        <!-- <button class="btn btn-default btn-xs">Order</button> -->
                                                    </div>
                                                    <h5 class="m-b-none"><a href="#"> 12- Dec-2019</a></h5>

                                                    <div class="m-b-xs c-white small">200,000</div>

                                                    <!--     <div class="row">
                                <div class="col-md-8">

                                     <div class="flot-chart-analytics">
                                <div class="flot-chart-content" id="metric2"></div>
                            </div>
                                </div>
                                <div class="col-md-4">
                                   <h3 class="m-b-none server1"><span style="color:#BE362E"><i class=""></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

                                           <div class=""><span style="color:#228b22">H 18.89</span></div>
                                            <div class=""><span style="color:#BE362E">L 16.38</span></div>
                                </div>

                            </div> -->
                                                    <!-- row -->

                                                    <div class="row">
                                                        <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                            <h4 class="m-b-none server1">  iSell </h4>

                                                            <h5> <span class="usage3">12</span></h5>
                                                        </div>
                                                        <div class="col-md-2 col-xs-2" align="center">&nbsp;</div>
                                                        <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                            <h4 class="m-b-none server1">  iBuy </h4>

                                                            <h5> <span class="usage9">12</span> </h5>
                                                        </div>
                                                    </div>

                                                    <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                                </div>

                                            </div>
                                        </div>
                                        <!-- col4 -->

                                        <div class="col-md-4">

                                            <div class="panel panel-filled " style="border-radius:10px;">
                                                <div class="panel-body">
                                                    <div class="btn-group pull-right m-b-md">
                                                        <button class="btn btn-default btn-xs">Show Details</button>
                                                        <!-- <button class="btn btn-default btn-xs">Order</button> -->
                                                    </div>
                                                    <h5 class="m-b-none"><a href="#"> 6- Mar-2018</a></h5>

                                                    <div class="m-b-xs c-white small">30,000</div>

                                                    <!-- <div class="row">
                                <div class="col-md-8">

                                     <div class="flot-chart-analytics">
                                <div class="flot-chart-content" id="metric3"></div>
                            </div>
                                </div>
                                <div class="col-md-4">
                                   <h3 class="m-b-none server1"><span style="color:#BE362E"><i class=""></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

                                           <div class=""><span style="color:#228b22">H 18.89</span></div>
                                            <div class=""><span style="color:#BE362E">L 16.38</span></div>
                                </div>

                            </div>-->
                                                    <!-- row -->

                                                    <div class="row">
                                                        <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                            <h4 class="m-b-none server1">  iSell </h4>

                                                            <h5> <span class="usage11">12</span></h5>
                                                        </div>
                                                        <div class="col-md-2 col-xs-2" align="center">&nbsp;</div>
                                                        <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                            <h4 class="m-b-none server1">  iBuy </h4>

                                                            <h5> <span class="usage10">12</span> </h5>
                                                        </div>
                                                    </div>

                                                    <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                                </div>

                                            </div>
                                        </div>
                                        <!-- col4 -->

                                        <!-- row 2 -->

                                        <div class="col-md-4">

                                            <div class="panel panel-filled " style="border-radius:10px;">
                                                <div class="panel-body">
                                                    <div class="btn-group pull-right m-b-md">
                                                        <button class="btn btn-default btn-xs">Show Details</button>
                                                        <!-- <button class="btn btn-default btn-xs">Order</button>-->
                                                    </div>
                                                    <h5 class="m-b-none"><a href="#"> 4- FeB-2017</a></h5>

                                                    <div class="m-b-xs c-white small">500,000</div>

                                                    <!--  <div class="row">
                                <div class="col-md-8">

                                     <div class="flot-chart-analytics">
                                <div class="flot-chart-content" id="metric5"></div>
                            </div>
                                </div>
                                <div class="col-md-4">
                                   <h3 class="m-b-none server1"><span style="color:#BE362E"><i class=""></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

                                           <div class=""><span style="color:#228b22">H 18.89</span></div>
                                            <div class=""><span style="color:#BE362E">L 16.38</span></div>
                                </div>

                            </div>-->
                                                    <!-- row -->

                                                    <div class="row">
                                                        <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                            <h4 class="m-b-none server1">  iSell </h4>

                                                            <h5> <span class="usage11">12</span></h5>
                                                        </div>
                                                        <div class="col-md-2 col-xs-2" align="center">&nbsp;</div>
                                                        <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                            <a href="#" data-toggle="modal" data-target="#trademodal" class="btn-link">
                                                                <h4 class="m-b-none server1">iBuy </h4></a>

                                                            <h5> <span class="usage12">12</span> </h5>
                                                        </div>
                                                    </div>

                                                    <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                                </div>

                                            </div>
                                        </div>
                                        <!-- col4 -->

                                        <div class="col-md-4">

                                            <div class="panel panel-filled " style="border-radius:10px;">
                                                <div class="panel-body">
                                                    <div class="btn-group pull-right m-b-md">
                                                        <button class="btn btn-default btn-xs" style="color: #fff">Show Details</button>
                                                        <!-- <button class="btn btn-default btn-xs">Order</button> -->
                                                    </div>
                                                    <h5 class="m-b-none"><a href="#"> 4- Jan-2018</a></h5>

                                                    <div class="m-b-xs c-white small">100,000</div>

                                                    <!--   <div class="row">
                                <div class="col-md-8">

                                     <div class="flot-chart-analytics">
                                <div class="flot-chart-content" id="metric10"></div>
                            </div>
                                </div>
                                <div class="col-md-4">
                                   <h3 class="m-b-none server1"><span style="color:#BE362E"><i class=""></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

                                           <div class=""><span style="color:#228b22">H 18.89</span></div>
                                            <div class=""><span style="color:#BE362E">L 16.38</span></div>
                                </div>

                            </div>-->
                                                    <!-- row -->

                                                    <div class="row">
                                                        <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                            <h4 class="m-b-none server1">  iSell </h4>

                                                            <h5> <span class="usage3">12</span></h5>
                                                        </div>
                                                        <div class="col-md-2 col-xs-2" align="center">&nbsp;</div>
                                                        <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                            <h4 class="m-b-none server1">  iBuy </h4>
                                                            <h5> <span class="usage9">12</span> </h5>
                                                        </div>
                                                    </div>

                                                    <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                                </div>

                                            </div>
                                        </div>
                                        <!-- col4 -->
                                    </div>
                                    <!-- row -->

                                    <!-- trade card-->
                                </div>
                                <!--col8 -->

                            </div>

                            <!-- end maturities content 2 -->

                        </div>

                    </div>
                    <!-- end of easy mode -->

@endsection

@section('feeds')
<aside class="feed">

            <div class="v-timeline vertical-container scrollbar" id="style-1" style="height: 100%;overflow-x: hidden; padding: 5px 10px;">
                <h5 style="color: gold">Flash Trades.</h5>
                <trade-aside>
                </trade-aside> <hr>

                <div style="min-height: 300px;">
                    <h5 style="color: gold">Top News.</h5>

                    {{-- @foreach($news as $new)
                    <h5>{{ $new->title }}</h5>
                        {!! $new->body !!}
                        <hr>
                    @endforeach --}}
                    <div id="rss-feeds"></div>
                    
                </div>
            </div>

        </aside>

        
        <div class="modal left fade in scrollbar" id="trademodal" role="dialog" aria-hidden="true" style="max-height: 100%; overflow-y: auto;">
            <div class="modal-dialog">
                <div class="modal-content-wrapper">
                    <div class="modal-content">
                        <div class="modal-body " style="padding:10px">
<div class="pull-left">
    <span class="security-name">
                                
                            </span>
                                        <form action="#" autocomplete="off">
                                    <div class="form-group">
                                        {{-- <label for="">Enter Trading Pin</label> --}}
                                       
                                        {{-- <span class="input-group-btn">
                                            <button class="btn btn-sm btn-success check-trading-pin" style="color: #fff;background: #20a57b;">ok</button>
                                        </span> --}}
                                    </div>
                                </form>
                                </div>

                                <div class="pull-right">
                                    <a href="#" data-dismiss="modal" class="btn btn-w-md btn-accent btn-rounded close-btn">&times;</a>
                                </div>

                                <div class="clearfix"></div>
                                
                            <div class="table-responsive" id="bucketDetails">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            {{-- <th>Quantity</th> --}}
                                            <th>Price</th>
                                            <th>Volume</th>
                                            <th></th>
                                            <th>Pin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>
                                    <div class="inline-block">
                                        <p class="order-type">
                                    <span class="bold" style="color: #fff">Order Type: </span> <span class="text-danger value"> Sale</span>
                                    </p>
                                    <p class="yield-view">
                                        <span class="bold" style="color: #fff">Yield: </span> <span class="yield-value"> </span>
                                    </p>

                                    <p class="discount-rate-view">
                                        <span class="bold" style="color: #fff">Discount Rate: </span> <span class="discount-rate-value"> </span>
                                    </p>
                                    </div> <br> <hr>
                                    <p class="pull-left cost_details">
                                       <b>
                                            Consideration <br>
                                        ₦0
                                       </b>
                                    </p>
                                    <p class="pull-right gl"></p>
                                </table>
                                <span class="volume-error text-danger"></span>
                            </div>

                            <div id="orderSelector" style="background: #ffd89b;  /* fallback for old browsers */
background: -webkit-linear-gradient(to bottom, #19547b, #ffd89b);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to bottom, #19547b, #ffd89b); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
 border-radius:10px; display:none;padding: 10px 20px 10px 10px;color:white">

                                <div class="row">
                                    <div class="col-md-6">

                                        <h4 color: "#ffdead">Volume Details </h4>

                                    </div>
                                    <div class="col-md-6" align="right">
                                        <!-- <img id="cspio-logo" src="https://arkounting.com.ng/tradefiprocess/webapp/images/TFI Official Logo no background.jpg" width="100px"> -->
                                    </div>
                                </div>
                                <div align="center">

                                    <table style="color:black">
                                        <tbody>

                                            <tr>
                                                <td class="tdH">Security :</td>
                                                <td class="td2"><b><span>FGN2030</span></b></td>
                                            </tr>

                                            <tr>
                                                <td class="tdH">Volume : </td>
                                                <td class="td2">
                                                    <form id='myform' method='POST' action='#'>
                                                        <input type='button' value='-' class='qtyminus' field='quantity' />
                                                        <input type='text' name='quantity' value='0' class='qty' />
                                                        <input type='button' value='+' class='qtyplus' field='quantity' />
                                                    </form>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tdH">Price :</td>
                                                <td class="td2"><span>₦ 200,000</span> (<span style="color:green">₦378,000)</span>)</td>
                                            </tr>

                                        </tbody>
                                    </table>

                                    <hr/>

                                    <div class="row" align="right" id="btnbuy1">
                                        <button class="btn btn-w-md btn-default" onclick="reset_trade_action(2, 2.89)"><span class="ladda-label">Cancel Order</span></button>
                                        <button class="btn" style="background-color:gold; border-color:gold;color:black" onclick="trade_action_buy(2, 2.89)">Proceed &nbsp; <i class="fa fa-arrow-circle-o-right"></i></button>
                                    </div>

                                </div>

                            </div>
                            <!-- order details -->

                            <div id="orderDetails" style="background: #ffd89b;  /* fallback for old browsers */
background: -webkit-linear-gradient(to bottom, #19547b, #ffd89b);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to bottom, #19547b, #ffd89b); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
 border-radius:10px; color: black;display:none;padding: 10px 20px 10px 10px;">

                                <!-- <a href="#" onclick="reset_trade_action(2, 2.89)">Reset</a> -->
                                <div class="row">
                                    <div class="col-md-6">

                                        <h4>Ticket Details </h4>

                                    </div>
                                    <div class="col-md-6" align="right">
                                        <img id="cspio-logo" src="https://arkounting.com.ng/tradefiprocess/webapp/images/TFI Official Logo no background.jpg" width="100px">
                                    </div>
                                </div>
                                <div align="center">

                                    <table style="color:black">
                                        <tbody>
                                            <tr>
                                                <td class="tdH"> Name :</td>
                                                <td class="td2"><span>Christopher Enaboifo</span></td>
                                            </tr>

                                            <tr>
                                                <td class="tdH">Security :</td>
                                                <td class="td2"><b><span>FGN2030</span></b></td>
                                            </tr>

                                            <tr>
                                                <td class="tdH">Volume : </td>
                                                <td class="td2">
                                                    <!--  <form id='myform' method='POST' action='#'>
                                                  <input type='button' value='-' class='qtyminus' field='quantity' />
                                                  <input type='text' name='quantity' value='0' class='qty' />
                                                  <input type='button' value='+' class='qtyplus' field='quantity' />
                                              </form> -->
                                                    <b><span>30</span></b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tdH">Price :</td>
                                                <td class="td2"><span>₦ 600,000</span></td>
                                            </tr>
                                            <tr>
                                                <td class="tdH">Yield :</td>
                                                <td class="td2">11.23</td>
                                            </tr>
                                            <tr>
                                                <td class="tdH">Settlement :</td>
                                                <td class="td2"><span>January 1, 2019</span></td>
                                            </tr>

                                            <tr>
                                                <td class="tdH">Principal Accrued:</td>
                                                <td class="td2"><span id="prefix" contenteditable=""></span><span>Nil</span></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <hr/>

                                    <div class="row" align="right" id="btnbuy" style="display:none">
                                        <button class="btn btn-w-md btn-default" style="background-color:brown; border-color:brown;color:white" onclick="reset_trade_action(2, 2.89)"><span class="ladda-label">Cancel Order</span></button>
                                        <button class="btn" style="background-color:snow; border-color:snow;color:black" onclick="trade_proceed(2, 2.89)"><i class="fa fa-arrow-circle-o-left"></i> Go Back &nbsp; </button>
                                        <button class="btn" style="background-color:gold; border-color:gold;color:black" onclick="pay()">iBuy &nbsp; <i class="fa fa-arrow-circle-o-right"></i></button>
                                    </div>

                                    <div class="row" align="right" id="btnsell" style="display:none">
                                        <button class="btn btn-w-md btn-default" onclick="reset_trade_action(2, 2.89)"><span class="ladda-label">Cancel Order</span></button>
                                        <button class="btn" style="background-color:gold; border-color:gold;color:black" onclick="pay()">iSell &nbsp; <i class="fa fa-arrow-circle-o-right"></i></button>
                                    </div>

                                </div>

                            </div>
                            <!-- order details -->

                        </div>

                        <div class="modal-footer">
                            <div>
                                {{-- <span class="pull-left security-name">
                                
                            </span> --}}
                            <div class="countdown-sell pull-right" style="    margin-top: -10px;  margin-bottom: 10px;"></div>
                                <div class="clearfix"></div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>



        <div class="modal left fade in scrollbar" id="trademodal-buy" role="dialog" aria-hidden="true" style="max-height: 100%; overflow-y: auto;">
            <div class="modal-dialog">
                <div class="modal-content-wrapper">
                    <div class="modal-content">
                        <div class="modal-body " style="padding:10px">
                          <div class="pull-left">
                            
                            <span class="security-name"></span>
                                        <form action="#" autocomplete="off">
                                    <div class="form-group">
                                        {{-- <label for="">Enter Trading Pin</label> --}}
                                        {{-- <input type="password" class="form-control" placeholder="Transaction Code" name="trading-pin-buy" autocomplete="off" style="height: 30px"> --}}
                                        {{-- <span class="input-group-btn">
                                            <button class="btn btn-sm btn-success check-trading-pin" style="color: #fff;background: #20a57b;">ok</button>
                                        </span> --}}
                                    </div>
                                </form>
                                </div>

                                <div class="pull-right">
                                    <a href="#" data-dismiss="modal" class="btn btn-w-md btn-accent btn-rounded close-btn">&times;</a>
                                </div>

                                <div class="clearfix"></div>  
                            <div class="table-responsive" id="bucketDetails-buy">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            {{-- <th>Quantity</th> --}}
                                            <th>Price</th>
                                            <th>Volume</th>
                                            <th></th>
                                            <th>Pin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>
                                    <div class="inline-block">
                                        <p class="order-type">
                                    <span class="bold" style="color: #fff">Order Type: </span> <span class="text-success value"> Purchase</span>
                                    </p>
                                    <p class="yield-view">
                                        <span class="bold" style="color: #fff">Yield: </span> <span class="yield-value"> </span>
                                    </p>

                                    <p class="discount-rate-view">
                                        <span class="bold" style="color: #fff">Discount Rate: </span> <span class="discount-rate-value"> </span>
                                    </p>
                                    </div> <br>
                                    <hr>
                                    <p class="pull-left cost_details">
                                       <b>
                                            Consideration <br>
                                            ₦0
                                       </b>
                                    </p>
                                    <p class="pull-right gl"></p>
                                </table>
                                <span class="volume-error text-danger"></span>
                            </div>

                            <div id="orderSelector" style="background: #ffd89b;  /* fallback for old browsers */
background: -webkit-linear-gradient(to bottom, #19547b, #ffd89b);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to bottom, #19547b, #ffd89b); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
 border-radius:10px; display:none;padding: 10px 20px 10px 10px;color:white">

                                <div class="row">
                                    <div class="col-md-6">

                                        <h4 color: "#ffdead">Volume Details </h4>

                                    </div>
                                    <div class="col-md-6" align="right">
                                        <!-- <img id="cspio-logo" src="https://arkounting.com.ng/tradefiprocess/webapp/images/TFI Official Logo no background.jpg" width="100px"> -->
                                    </div>
                                </div>
                                <div align="center">

                                    <table style="color:black">
                                        <tbody>

                                            <tr>
                                                <td class="tdH">Security :</td>
                                                <td class="td2"><b><span>FGN2030</span></b></td>
                                            </tr>

                                            <tr>
                                                <td class="tdH">Volume : </td>
                                                <td class="td2">
                                                    <form id='myform' method='POST' action='#'>
                                                        <input type='button' value='-' class='qtyminus' field='quantity' />
                                                        <input type='text' name='quantity' value='0' class='qty' />
                                                        <input type='button' value='+' class='qtyplus' field='quantity' />
                                                    </form>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tdH">Price :</td>
                                                <td class="td2"><span>₦ 200,000</span> (<span style="color:green">₦378,000)</span>)</td>
                                            </tr>

                                        </tbody>
                                    </table>

                                    <hr/>

                                    <div class="row" align="right" id="btnbuy1">
                                        <button class="btn btn-w-md btn-default" onclick="reset_trade_action(2, 2.89)"><span class="ladda-label">Cancel Order</span></button>
                                        <button class="btn" style="background-color:gold; border-color:gold;color:black" onclick="trade_action_buy(2, 2.89)">Proceed &nbsp; <i class="fa fa-arrow-circle-o-right"></i></button>
                                    </div>

                                </div>

                            </div>
                            <!-- order details -->

                            <div id="orderDetails" style="background: #ffd89b;  /* fallback for old browsers */
background: -webkit-linear-gradient(to bottom, #19547b, #ffd89b);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to bottom, #19547b, #ffd89b); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
 border-radius:10px; color: black;display:none;padding: 10px 20px 10px 10px;">

                                <!-- <a href="#" onclick="reset_trade_action(2, 2.89)">Reset</a> -->
                                <div class="row">
                                    <div class="col-md-6">

                                        <h4>Ticket Details </h4>

                                    </div>
                                    <div class="col-md-6" align="right">
                                        <img id="cspio-logo" src="https://arkounting.com.ng/tradefiprocess/webapp/images/TFI Official Logo no background.jpg" width="100px">
                                    </div>
                                </div>
                                <div align="center">

                                    <table style="color:black">
                                        <tbody>
                                            <tr>
                                                <td class="tdH"> Name :</td>
                                                <td class="td2"><span>Christopher Enaboifo</span></td>
                                            </tr>

                                            <tr>
                                                <td class="tdH">Security :</td>
                                                <td class="td2"><b><span>FGN2030</span></b></td>
                                            </tr>

                                            <tr>
                                                <td class="tdH">Volume : </td>
                                                <td class="td2">
                                                    <!--  <form id='myform' method='POST' action='#'>
                                                  <input type='button' value='-' class='qtyminus' field='quantity' />
                                                  <input type='text' name='quantity' value='0' class='qty' />
                                                  <input type='button' value='+' class='qtyplus' field='quantity' />
                                              </form> -->
                                                    <b><span>30</span></b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tdH">Price :</td>
                                                <td class="td2"><span>₦ 600,000</span></td>
                                            </tr>
                                            <tr>
                                                <td class="tdH">Yield :</td>
                                                <td class="td2">11.23</td>
                                            </tr>
                                            <tr>
                                                <td class="tdH">Settlement :</td>
                                                <td class="td2"><span>January 1, 2019</span></td>
                                            </tr>

                                            <tr>
                                                <td class="tdH">Principal Accrued:</td>
                                                <td class="td2"><span id="prefix" contenteditable=""></span><span>Nil</span></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <hr/>

                                    <div class="row" align="right" id="btnbuy" style="display:none">
                                        <button class="btn btn-w-md btn-default" style="background-color:brown; border-color:brown;color:white" onclick="reset_trade_action(2, 2.89)"><span class="ladda-label">Cancel Order</span></button>
                                        <button class="btn" style="background-color:snow; border-color:snow;color:black" onclick="trade_proceed(2, 2.89)"><i class="fa fa-arrow-circle-o-left"></i> Go Back &nbsp; </button>
                                        <button class="btn" style="background-color:gold; border-color:gold;color:black" onclick="pay()">iBuy &nbsp; <i class="fa fa-arrow-circle-o-right"></i></button>
                                    </div>

                                    <div class="row" align="right" id="btnsell" style="display:none">
                                        <button class="btn btn-w-md btn-default" onclick="reset_trade_action(2, 2.89)"><span class="ladda-label">Cancel Order</span></button>
                                        <button class="btn" style="background-color:gold; border-color:gold;color:black" onclick="pay()">iSell &nbsp; <i class="fa fa-arrow-circle-o-right"></i></button>
                                    </div>

                                </div>

                            </div>
                            <!-- order details -->

                        </div>

                        <div class="modal-footer">
                            <div>
                                <span class="pull-left security-name">
                                
                            </span>
                            <div class="countdown-buy pull-right" style="    margin-top: -10px;
    margin-bottom: 10px;"></div>
    <div class="clearfix"></div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

        <!-- Trade Ticket after trade has been executed -->
    <div class="modal left fade in scrollbar" id="trade-ticket"  role="dialog" aria-hidden="true" style="max-height: 100%; overflow-y: auto;">
        <div class="modal-dialog">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 10px; padding-bottom: 0; border-bottom: 0">
                        <h4 class="text-warning">Ticket Details.</h4>
                    </div>
                    <div class="modal-body " style="padding:10px">
                        
                    </div>
                    <div class="modal-footer" style="padding: 10px">
                        <div class="pull-left">
                            <a href="/blotter" class="btn btn-sm btn-info">View Blotter</a>
                            <a href="#" data-dismiss="modal" class="btn btn-sm btn-success">Continue Trading</a>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-sm btn-warning" onclick="print_ticket()">Print Ticket</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal as an Iframe for news content -->
            <div class="modal fade" id="news-modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header text-center" style="padding: 10px">
                            <h4 class="modal-title">News Content</h4>
                            <p>Source: <em>Reuters</em></p>
                        </div>
                        <div class="modal-body" style="padding: 0">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
    
@endsection

@push('scripts')
 <!-- Resources -->
        <script src="{{ asset('webapp/scripts/traderoom.js') }}"></script>     
        <script src="https://www.jqueryscript.net/demo/Simple-jQuery-Html5-Based-360-Degree-Countdown-Timer-countdown360/src/jquery.countdown360.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.10/sweetalert2.min.js"></script>
        <script src="{{ asset('js/traderoom.js') }}"></script>
        <script src="{{ asset('js/printThis.js') }}"></script>
         <script>
            function print_ticket() {
                return $("#trade-ticket").printThis();
            }
    jQuery(function($) {
      $("#rss-feeds").rss("http://feeds.reuters.com/reuters/AfricaNigeriaNews",
      {
         layoutTemplate: "<ul id=\"demo3\" class='ulcust feed-container'>{entries}</ul>",
         limit: 10,
         ssl: true,
        entryTemplate:'<li class="news-item"><a href="{url}" target="_blank" ><b>{title}</b></a><p>{shortBodyPlain}</p></li>'
      })
      
    });


  $(window).bind("load", function() {
   // code here
    $("#demo3").bootstrapNews({
                newsPerPage: 4,
                autoplay: true,
                pauseOnHover: true,
                navigation: false,
                direction: 'up',
                newsTickerInterval: 5000,
                onToDo: function() {
                    //console.log(this);
                }
            });

     $('.news-item a').click(function(e) {
           e.preventDefault();

           $(this).removeAttr('target');
            var modal = $("#news-modal");
            var src_to_be_loaded = $(this).attr('href');
           modal.find('.modal-body').html(
            '<iframe src="'+src_to_be_loaded+'" frameborder="0" width="100%" height="500px"></iframe>'
            );
           
           modal.modal();
           return false;
            
      });

     makechart();
});
  </script>
 <script>

 function makechart() {

                    var chartUsersOptions = {
                    lines: {
                        show: true,
                        fill: false,
                        lineWidth: 2,
                    },
                     yaxis: {
                        min: 0,
                        max: 30,
                        tickSize: 10
                    },

                     xaxis: {
                        min: 0,
                        max: 30,
                    },


                    grid: {
                        borderWidth: 1,
                         hoverable: true, clickable: true, autoHighlight: true 
                    }
                };

                 var globalOptions = {
            responsive: true,
             tooltips: {
                mode: 'single',
            },
            fill: true,
            backgroundColor: "rgba(47, 50, 59,0.6)",
            legend: {
                display: false,
                labels:{
                    fontColor:"#90969D"
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: "#90969D",
                        display: false
                    },

                    gridLines: {
                        display: false,
                        color: "transparent"
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontColor: "#90969D",
                        min: 5,
                        max: 20,
                    },
                    gridLines: {
                        display: true,
                        color: "rgba(129, 134, 142, 0.2)"
                    },
                }]
            }
        };

        let c1 = document.getElementsByClassName("lineOptions");
       
   
        for (var i = 0; i < c1.length; i++) {
            // $('#spinner').show();
            let c = c1[i];
            // console.log('c', c);
            $.ajax({
                    url: '/trade-room/fetch-chart-data',
                    type: 'POST',
                    data: {
                        MaturityDate: $(c1[i]).data('maturity')
                    },
                })
                .done(function(data) {
                    // console.log(data.chart_data);
                     let  _data = [];
                     let  _labels = [];
                    
                    for (var a = 0 ; a < data.chart_data.length ; a++) {
                        _data.push(data.chart_data[a].Yield);
                       _labels.push(data.chart_data[a].ClosingDate);
                       // console.log(data.chart_data[a].Yield)
                    }
                    c.getContext("2d");
            new Chart(c, {type: 'line', data: {
            labels: _labels,
            datasets: [

                {
                    fill: 1,
                    backgroundColor:"#2f323b",
                    borderColor: "#f6a821",
                    pointBorderWidth: 0,
                    pointRadius: 0,
                    LineTension: 0,
                    pointBorderColor: '#f6a821',
                    borderWidth: 1,
                    data: _data
                }
            ]
        }, options: globalOptions});
                })
                .fail(function() {
                    // console.log("error");
                })
                .always(function() {
                    // console.log("complete");
                });
        }


        


                }
            new Vue({
                el: '#trademodal-event',
                data: {
                    // gl_balance: 0
                },
                created(){
                    this.listenForInventory();
                    Echo.channel('traderoom_creation').listen('TradeCreated', (e) => {
                            // console.log(e);
                            // this.gl_balance = e.quantity;

                            var trade_card = `
                                <div class="col-md-4">
                                <div class="panel panel-filled " style="border-radius:10px; min-height: 310px">
                                    <div class="panel-body">
                                        <div class="btn-group pull-right m-b-md">
                                            <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal">Show Details</button>

                                            <!--    <button class="btn btn-default btn-xs">Order</button> -->
                                        </div>
                                        <h4 class="m-t-none"><a href="#">${ e.description }</a></h4>

                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                <h3 class="m-b-none server1 pull-left" style="    margin-top: 0; margin-right: 10px;
                                                font-size: 16px;"><span style="color:#BE362E"><i class=""></i></span><span style="color:#FFD700">0.00</span>
                                                </h3>

                                                <div class="pull-left" style="    margin-right: 10px;"><span style="color:#228b22">H 0.00</span></div>
                                                <div class="pull-left"><span style="color:#BE362E">L 0.00</span></div>

                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="col-md-10 col-xs-12">

                                                <a href="#" data-toggle="modal" data-target="#myModal">
                                                    <div style="margin-top: 15px; margin-bottom: 10px">
                                                        <canvas class="lineOptions" height="250" data-maturity="${ e.MaturityDate }"></canvas>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                        <!-- row -->

                                        <div class="row">
                                            <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                <!--  <h4 class="m-b-none server1">  iSell </h4> -->
                                                <a href="#"  class="btn-link trade-modal-toggler-for-sell" data-security-id="${ e.security }">
                                                    <h4 class="m-b-none server1">iSell </h4></a>

                                                <h5> <span class="usage11 sell-price-container">${ e.buy_price }</span></h5>
                                            </div>
                                            <div class="col-md-2 col-xs-2" align="center">&nbsp;</div>
                                            <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                <!--     <h4 class="m-b-none server1">  iBuy </h4> -->
                                                <a href="#"  class="btn-link trade-modal-toggler-for-buy" data-security-id="${ e.security }">
                                                    <h4 class="m-b-none server1">iBuy </h4></a>

                                                <h5> <span class="usage12 buy-price-container">${ e.sell_price}</span> </h5>
                                            </div>
                                        </div>

                                        <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                    </div>

                                </div>
                            `;

                            // check if security card exists in view

                            if($('#tradecard-container').find(`[data-security-id=${e.security}]`).length > 0){
                                // console.log('tradecard is already on the view');
                                $('#tradecard-container').find(`[data-security-id=${e.security}]`).parent().find('.usage12').html(e.sell_price);
                                $('#tradecard-container').find(`[data-security-id=${e.security}]`).parent().find('.usage11').html(e.buy_price);
                                // console.log( $('#tradecard-container').find(`[data-security-id=${e.security}]`).parent().find('.usage11'));
                                // console.log(e.sell_price);
                            } else {
                                 $("#tradecard-container").append(trade_card);
                            }
                           
                      buy_toggler({{ auth()->user()->id }}, function(){
                // $("#trademodal-buy #bucketDetails-buy").find("[name=volume]").smartInput();
                var volume =  $("#trademodal-buy #bucketDetails-buy").find("[name=volume]");
                var price = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('dirtyPrice');
                var product = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('productId');
                var gl_balance_for_cash = {{ auth()->user()->gls->where('AccountTypeID', 1)->first()->ClearedBalance }}
                volume.smartInput();
                //var cost = volume.val() * price/100
                // $("#trademodal-buy #bucketDetails-buy .gl").html('<b>Cash Balance </b><br> <span class="c-accent">' + accounting.formatNumber(gl_balance_for_cash, 2)+'</span>');
                volume.keyup(function(e) {
                    // e.preventDefault();
                    // console.log('skrrra')
                    if(product == 1){
                        var cost = accounting.unformat($(this).val()) 
                        var consideration = accounting.unformat($(this).val()) * price / 100
                    } else {
                        var cost = accounting.unformat($(this).val()) 
                        var consideration = accounting.unformat($(this).val()) * price / 100
                    }
                    
                    if(consideration > gl_balance_for_cash){
                        $(this).addClass('exceeded')
                        $("#trademodal-buy #bucketDetails-buy").find('.volume-error').html("Insufficient Funds");
                    } else {
                         $(this).removeClass('exceeded');
                           $("#trademodal-buy #bucketDetails-buy").find('.volume-error').html("");
                    }
                    $("#trademodal-buy #bucketDetails-buy .cost_details").html('<b>Consideration</b> <br> ' + '<span class="c-accent">₦'+accounting.formatNumber(consideration, 2) + '</span>');
                });
             });
             sell_toggler({{ auth()->user()->id }}, function(){
                var volume = $("#trademodal #bucketDetails").find("[name=volume]");
                var price = $("#trademodal #bucketDetails").find('.deal-btn').data('dirtyPrice');
                 var securityId = $("#trademodal #bucketDetails").find('.deal-btn').data('securityId');
                 var product = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('productId');
                 var gl_balance_for_bonds ;
                 $.getJSON('/getBalanceForSecurity/'+securityId, function(data) {
                    gl_balance_for_bonds = data;
                    $("#trademodal #bucketDetails .gl").html('<b>Security Balance </b><br><span class="c-accent">' + accounting.formatNumber(gl_balance_for_bonds, 2)+ '</span>');
                 });
                 volume.smartInput();
                
                // var cost = volume.val() * price/100
                
                volume.keyup(function(e) {
                    // e.preventDefault();
                   if(product == 1){
                        var cost = accounting.unformat($(this).val()) 
                        var consideration = accounting.unformat($(this).val()) * price / 100
                    } else {
                        var cost = accounting.unformat($(this).val()) 
                        var consideration = accounting.unformat($(this).val()) * price / 100
                    }
                    if(cost > gl_balance_for_bonds){
                        $(this).addClass('exceeded')
                         $("#trademodal #bucketDetails").find('.volume-error').html("Insufficient Security Balance");
                    } else {
                         $(this).removeClass('exceeded')
                          $("#trademodal #bucketDetails").find('.volume-error').html("");
                    }
                    $("#trademodal #bucketDetails .cost_details").html('<b>Consideration </b><br><span class="c-accent">₦' + accounting.formatNumber(consideration, 2)+'</span>');
                });

             })
                    });

                Echo.channel('test-channel').listen('TestEvent', (e) => {
                    $.ajax({
                        url: '/fetch-tradelist',
                        type: 'GET',
                    })
                    .done(function(data) {
                        // console.log(data);
                        // REPOPULATE TRADELIST
                        var output = '<div></div>';
                        $("#tradecard-container").html(' ');
                           display_data(data);

                            buy_toggler({{ auth()->user()->id }}, function(){
                // $("#trademodal-buy #bucketDetails-buy").find("[name=volume]").smartInput();
                var volume =  $("#trademodal-buy #bucketDetails-buy").find("[name=volume]");
                var price = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('dirtyPrice');
                var product = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('productId');
                var gl_balance_for_cash = {{ auth()->user()->gls->where('AccountTypeID', 1)->first()->ClearedBalance }}
                volume.smartInput();
                volume.keyup(function(e) {
                    // e.preventDefault();
                    // console.log('skrrra')
                    if(product == 1){
                        var cost = accounting.unformat($(this).val()) 
                        var consideration = accounting.unformat($(this).val()) * price / 100
                    } else {
                        var cost = accounting.unformat($(this).val()) 
                        var consideration = accounting.unformat($(this).val()) * price / 100
                    }
                    
                    if(consideration > gl_balance_for_cash){
                        $(this).addClass('exceeded')
                         $("#trademodal-buy #bucketDetails-buy").find('.volume-error').html("Insufficient Funds");
                    } else {
                         $(this).removeClass('exceeded')
                          $("#trademodal-buy #bucketDetails-buy").find('.volume-error').html("");
                    }
                    $("#trademodal-buy #bucketDetails-buy .cost_details").html('<b>Consideration</b> <br> ' + '<span class="c-accent">₦'+accounting.formatNumber(consideration, 2) + '</span>');
                });
             });
             sell_toggler({{ auth()->user()->id }}, function(){
                var volume = $("#trademodal #bucketDetails").find("[name=volume]");
                var price = $("#trademodal #bucketDetails").find('.deal-btn').data('dirtyPrice');
                 var securityId = $("#trademodal #bucketDetails").find('.deal-btn').data('securityId');
                 var product = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('productId');
                 var gl_balance_for_bonds ;
                 $.getJSON('/getBalanceForSecurity/'+securityId, function(data) {
                    gl_balance_for_bonds = data;
                    $("#trademodal #bucketDetails .gl").html('<b>Security Balance </b><br><span class="c-accent">' + accounting.formatNumber(gl_balance_for_bonds, 2)+ '</span>');
                 });
                
                // var cost = volume.val() * price/100
                volume.smartInput();
                volume.keyup(function(e) {
                    // e.preventDefault();
                   if(product == 1){
                        var cost = accounting.unformat($(this).val()) 
                        var consideration = accounting.unformat($(this).val()) * price / 100
                    } else {
                        var cost = accounting.unformat($(this).val()) 
                        var consideration = accounting.unformat($(this).val()) * price / 100
                    }
                    if(cost > gl_balance_for_bonds){
                        $(this).addClass('exceeded')
                         $("#trademodal #bucketDetails").find('.volume-error').html("Insufficient Security Balance");
                    } else {
                         $(this).removeClass('exceeded')
                          $("#trademodal #bucketDetails").find('.volume-error').html("");
                    }
                    $("#trademodal #bucketDetails .cost_details").html('<b>Consideration </b><br><span class="c-accent">₦' + accounting.formatNumber(consideration, 2)+'</span>');
                });

             })


                    })
                    .fail(function() {
                        // console.log("error");
                    })
                    .always(function() {
                        // console.log("complete");
                    });
                    
                });



                },
                updated(){
                    this.listenForCreation();
                    this.listenForInventory();
                },
                methods: {
                    listenForCreation() {
                        Echo.channel('traderoom_creation').listen('TradeCreated', (e) => {
                            // console.log(e);
                        })
                    },

                    listenForInventory() {
                        Echo.channel('inventory-added-channel').listen('InventoryAddedEvent', (e) => {
                            document.querySelector('.updated-content-notifier').style.display = 'block';
                            document.querySelector('.updated-content-notifier').style.top = '100px';
                        });
                    }
                }
            })
        </script>
        <script type="text/javascript">
             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            buy_toggler({{ auth()->user()->id }}, function(){
                // $("#trademodal-buy #bucketDetails-buy").find("[name=volume]").smartInput();
                var volume =  $("#trademodal-buy #bucketDetails-buy").find("[name=volume]");
                var price = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('dirtyPrice');
                var product = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('productId');
                var gl_balance_for_cash = {{ auth()->user()->gls->where('AccountTypeID', 1)->first()->ClearedBalance }}
                volume.smartInput();
                volume.keyup(function(e) {
                    // e.preventDefault();
                    var deal_button =$('.deal-btn');
                    accounting.unformat($(this).val()) < 100000 ? $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').attr('disabled', 'disabled').addClass('disabled') : $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').removeClass('disabled').removeAttr('disabled') ;
                    if(product == 1){
                        var cost = accounting.unformat($(this).val()) 
                        var consideration = accounting.unformat($(this).val()) * price / 100
                    } else {
                        var cost = accounting.unformat($(this).val()) 
                        var consideration = accounting.unformat($(this).val()) * price / 100
                    }
                    
                    if(consideration > gl_balance_for_cash){
                        $(this).addClass('exceeded')
                         $("#trademodal-buy #bucketDetails-buy").find('.volume-error').html("Insufficient Funds");
                    } else {
                         $(this).removeClass('exceeded')
                          $("#trademodal-buy #bucketDetails-buy").find('.volume-error').html("");
                    }
                    $("#trademodal-buy #bucketDetails-buy .cost_details").html('<b>Consideration</b> <br> ' + '<span class="c-accent">₦'+accounting.formatNumber(consideration, 2) + '</span>');
                });
             });
             sell_toggler({{ auth()->user()->id }}, function(){
                var volume = $("#trademodal #bucketDetails").find("[name=volume]");
                var price = $("#trademodal #bucketDetails").find('.deal-btn').data('dirtyPrice');
                 var securityId = $("#trademodal #bucketDetails").find('.deal-btn').data('securityId');
                 var product = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('productId');
                 var gl_balance_for_bonds ;
                 $.getJSON('/getBalanceForSecurity/'+securityId, function(data) {
                    gl_balance_for_bonds = data;
                    $("#trademodal #bucketDetails .gl").html('<b>Security Balance </b><br><span class="c-accent">' + accounting.formatNumber(gl_balance_for_bonds, 2)+ '</span>');
                 });
                
                // var cost = volume.val() * price/100
                volume.smartInput();
                volume.keyup(function(e) {
                    // e.preventDefault();

                   if(product == 1){
                        var cost = accounting.unformat($(this).val()) 
                        var consideration = accounting.unformat($(this).val()) * price / 100
                    } else {
                        var cost = accounting.unformat($(this).val()) 
                        var consideration = accounting.unformat($(this).val()) * price / 100
                    }
                    if(cost > gl_balance_for_bonds){
                        $(this).addClass('exceeded')
                         $("#trademodal #bucketDetails").find('.volume-error').html("Insufficient Security Volume");
                    } else {
                         $(this).removeClass('exceeded')
                          $("#trademodal #bucketDetails").find('.volume-error').html("");
                    }
                    $("#trademodal #bucketDetails .cost_details").html('<b>Consideration </b><br><span class="c-accent">₦' + accounting.formatNumber(consideration, 2)+'</span>');
                });

             })

        </script>

       
        <script>
                $('.check-trading-pin').click(function(e) {
                e.preventDefault();
                // console.log($(this).parent().parent().find('[name=trading-pin]').val())
                var status = false;
                $.ajax({
                    url: 'user/check-trading-pin',
                    type: 'POST',
                    data: {Pin: $(this).parent().parent().find('[name=trading-pin]').val()}
                })
                .done(function(data, status,jqXHR) {
                    // console.log(jqXHR);
                    // if(data.message)
                    status = true;
                    
                    toastr.success('Pin Ok')
                    $(this).parent().parent().find('[name=trading-pin]').val(0);
                    return ok;
                })
                .fail(function() {
                    toastr.error('Incorrect Pin')
                    // ($(this).parent().parent().find('[name=trading-pin]').val(0)
                    // console.log("error");
                    status = false;
                })
                .always(function() {
                    // console.log("complete");
                });
                
            });

                // magic
                $('#trademodal, #trademodal-buy').on('hidden.bs.modal', function (e) {
                    // alert('dismissed')
                    $("#trademodal #bucketDetails").find("[name=volume]").val(0)
                     $("#trademodal-buy #bucketDetails-buy").find("[name=volume]").val(0)
                      $("#trademodal-buy #bucketDetails-buy [type=password]").val(' ');
                      $("#trademodal #bucketDetails .cost_details").html(' ')
                         $("#trademodal-buy #bucketDetails-buy .cost_details").html('Consideration ₦'+ 0.00);
                         $("[type=password]").val('');
                         $(".volume-error").html('');
                });
                $(".smartinput").smartInput();


                // chart / price changes 

                // Charts option for bonds

                

                // makechart();
                function display_data(data){
                    var count = data.length;
                     $.each(data, function(index, val) {
                                 $("#tradecard-container").append(`
                                         <div class="col-md-4">
                                <div class="panel panel-filled " style="border-radius:10px; min-height: 310px">
                                    <div class="panel-body">
                                        <div class="btn-group pull-right m-b-md">

                                            <!--    <button class="btn btn-default btn-xs">Order</button> -->
                                        </div>
                                        <h4 class="m-t-none"><a href="#">${ val.Description }</a></h4>

                                        <div class="row">

                                            <div class="col-md-12 col-xs-12">
                                                <h3 class="m-b-none server1 pull-left" style="    margin-top: 0; margin-right: 10px;
                                                font-size: 16px;"><span style="color:#BE362E"><i class=""></i></span><span style="color:#FFD700"></span>
                                                </h3>

                                                <div class="pull-left" style="    margin-right: 10px;"><span style="color:#228b22">H ${ accounting.formatNumber(val.Max, 2)}</span></div>
                                                <div class="pull-left"><span style="color:#BE362E">L ${ accounting.formatNumber(val.Min, 2)}</span></div>

                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="col-md-10 col-xs-12">

                                                <a href="#" data-toggle="modal" data-target="#myModal">
                                                    <div style="margin-top: 15px; margin-bottom: 10px">
                                                        <canvas class="lineOptions" height="250" data-maturity="${ val.MaturityDate }"></canvas>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                        <!-- row -->

                                        <div class="row">
                                            <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                <!--  <h4 class="m-b-none server1">  iSell </h4> -->
                                                <a href="#"  class="btn-link trade-modal-toggler-for-sell" data-security-id="${ val.SecurityID }">
                                                    <h4 class="m-b-none server1">iSell </h4></a>

                                                <h5> <span class="usage11 sell-price-container">${ accounting.formatNumber(val.BuyYield, 2) }%</span></h5>
                                            </div>
                                            <div class="col-md-2 col-xs-2" align="center">&nbsp;</div>
                                            <div class="col-md-5 col-xs-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                <!--     <h4 class="m-b-none server1">  iBuy </h4> -->
                                                <a href="#"  class="btn-link trade-modal-toggler-for-buy" data-security-id="${ val.SecurityID }">
                                                    <h4 class="m-b-none server1">iBuy </h4></a>

                                                <h5> <span class="usage12 buy-price-container">${ accounting.formatNumber(val.SellYield, 2)}%</span> </h5>
                                            </div>
                                        </div>

                                        <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                    </div>

                                </div>
                                    `);
                                 if (! --count){
                                    // console.log(data[index]);
                                    makechart();
                                 }
                            });
// makechart();
                }

                $('.updated-content-notifier').click(function(event) {
                    window.location.reload();
                });

               
                

        </script>
@endpush