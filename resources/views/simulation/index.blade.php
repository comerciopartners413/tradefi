@extends('layouts.app')

@push('styles')
    <style>
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
    <!-- end -->

    <style>
    	#contentdiv {
    		margin-right:300px;
    	}
    </style>
@endpush
@section('simulation_balance')
<b>Simulation:</b> <span><b><del>N</del></b>{{ number_format(TradefiUBA\GLSIM::where('CustomerID', auth()->user()->id)->first()->ClearedBalance, 2) }}</span>
@endsection
@section('content')

 <div class="container-fluid" id="normalmodediv" style="/*position:fixed;margin-right:inherit */">
    <div id="trademodal-event">
    {{-- @{{ gl_balance }} --}}
                <div class="row">
               {{ Form::open(['action' => 'TradeRoomController@index2']) }}
                    <div class="col-md-3">
                        <label>Security Type</label>
                        <select name="SecurityType" class="select2_demo_1 form-control" style="width: 100%">
                            <option value="3">All</option>
                            <option value="1">Bonds</option>
                            <option value="2">TBills</option>
                            

                        </select>
                    </div>
                    <div class="col-md-3">
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
                    <div class="col-md-3">
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
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success" style="margin-top: 25px">Search</button>
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
								<div class="col-md-4">

                                <div class="panel panel-filled " style="border-radius:10px; height: 310px">
                                    <div class="panel-body">
                                        <div class="btn-group pull-right m-b-md">
                                            <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal">
                                                Details
                                            </button>

                                            <!--    <button class="btn btn-default btn-xs">Order</button> -->
                                        </div>
                                        <h4 class="m-t-none pull-left" style="width: 100px"><a href="#">{{ $tl->Description }}</a></h4>

                                        {{-- <div class="m-b-xs c-white small">Sell Quantity: {{ number_format($tl->BuyQuantity) }}</div>
                                           <div class="m-b-xs c-white small">Buy Quantity: {{ number_format($tl->SellQuantity) }}</div> --}}

                                        <div class="row">
                                            <div class="col-md-8">

                                                <a href="#" data-toggle="modal" data-target="#myModal">
                                                    <div class="flot-chart-analytics">
                                                        <div class="flot-chart-content metric9" data-security-id="{{ $tl->SecurityID }}"></div>
                                                </a>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h3 class="m-b-none server1"><span style="color:#BE362E"><i class=""></i></span><span style="color:#FFD700">&nbsp;{{ number_format($tl->Max - $tl->Min, 2) }}</span></h3>

                                                <div class=""><span style="color:#228b22">H {{ number_format($tl->Max, 2) }}</span></div>
                                                <div class=""><span style="color:#BE362E">L {{ number_format($tl->Min, 2) }}</span></div>
                                            </div>

                                        </div>
                                        <!-- row -->

                                        <div class="row">
                                            <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                <!--  <h4 class="m-b-none server1">  iSell </h4> -->
                                                <a href="#"  class="btn-link trade-modal-toggler-for-sell" data-security-id="{{ $tl->SecurityID }}">
                                                    <h4 class="m-b-none server1">iSell </h4></a>

                                                <h5> <span class="usage11">{{number_format( $tl->BuyPrice, 2) }}</span></h5>
                                            </div>
                                            <div class="col-md-2" align="center">&nbsp;</div>
                                            <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                <!--     <h4 class="m-b-none server1">  iBuy </h4> -->
                                                <a href="#"  class="btn-link trade-modal-toggler-for-buy" data-security-id="{{ $tl->SecurityID }}">
                                                    <h4 class="m-b-none server1">iBuy </h4></a>

                                                <h5> <span class="usage12">{{ number_format($tl->SellPrice, 2) }}</span> </h5>
                                            </div>
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
                                                <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                    <!--   <h4 class="m-b-none server1">  iSell </h4> -->
                                                    <a href="#" data-toggle="modal" data-target="#trademodal" class="btn-link">
                                                        <h4 class="m-b-none server1">iSell </h4></a>

                                                    <h5> <span class="usage3">12</span></h5>
                                                </div>
                                                <div class="col-md-2" align="center">&nbsp;</div>
                                                <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
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
                                                <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                    <h4 class="m-b-none server1">  iSell </h4>

                                                    <h5> <span class="usage3">12</span></h5>
                                                </div>
                                                <div class="col-md-2" align="center">&nbsp;</div>
                                                <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
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
                                                <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                    <h4 class="m-b-none server1">  iSell </h4>

                                                    <h5> <span class="usage3">12</span></h5>
                                                </div>
                                                <div class="col-md-2" align="center">&nbsp;</div>
                                                <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
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
                                                <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                    <h4 class="m-b-none server1">  iSell </h4>

                                                    <h5> <span class="usage3">12</span></h5>
                                                </div>
                                                <div class="col-md-2" align="center">&nbsp;</div>
                                                <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
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
                                                <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                    <h4 class="m-b-none server1">  iSell </h4>

                                                    <h5> <span class="usage3">12</span></h5>
                                                </div>
                                                <div class="col-md-2" align="center">&nbsp;</div>
                                                <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
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
                                                <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                    <h4 class="m-b-none server1">  iSell </h4>

                                                    <h5> <span class="usage3">12</span></h5>
                                                </div>
                                                <div class="col-md-2" align="center">&nbsp;</div>
                                                <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
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
                                                        <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                            <!--  <h4 class="m-b-none server1">  iSell </h4> -->
                                                            <a href="#" data-toggle="modal" data-target="#trademodal" class="btn-link">
                                                                <h4 class="m-b-none server1">iSell </h4></a>

                                                            <h5> <span class="usage11">12</span></h5>
                                                        </div>
                                                        <div class="col-md-2" align="center">&nbsp;</div>
                                                        <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
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
                                                        <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                            <h4 class="m-b-none server1">  iSell </h4>

                                                            <h5> <span class="usage3">12</span></h5>
                                                        </div>
                                                        <div class="col-md-2" align="center">&nbsp;</div>
                                                        <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
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
                                                        <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                            <h4 class="m-b-none server1">  iSell </h4>

                                                            <h5> <span class="usage11">12</span></h5>
                                                        </div>
                                                        <div class="col-md-2" align="center">&nbsp;</div>
                                                        <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
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
                                                        <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                            <h4 class="m-b-none server1">  iSell </h4>

                                                            <h5> <span class="usage11">12</span></h5>
                                                        </div>
                                                        <div class="col-md-2" align="center">&nbsp;</div>
                                                        <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
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
                                                        <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                            <h4 class="m-b-none server1">  iSell </h4>

                                                            <h5> <span class="usage3">12</span></h5>
                                                        </div>
                                                        <div class="col-md-2" align="center">&nbsp;</div>
                                                        <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
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

            <div class="v-timeline vertical-container scrollbar" id="style-1" style="height: 700px;overflow-x: hidden; overflow-y: scroll;">
                <trade-aside>
                </trade-aside>
            </div>

        </aside>

        
        <div class="modal left fade in scrollbar" id="trademodal" role="dialog" aria-hidden="true" style="max-height: 100%; overflow-y: auto;">
            <div class="modal-dialog">
                <div class="modal-content-wrapper">
                    <div class="modal-content">
                        <div class="modal-body " style="padding:10px">
<div class="pull-left">
                                        <form action="#" autocomplete="off">
                                    <div class="form-group">
                                        {{-- <label for="">Enter Trading Pin</label> --}}
                                        <input type="password" class="form-control" placeholder="Transaction Code" name="trading-pin-sell" autocomplete="off" style="height: 30px">
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
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            {{-- <th>Quantity</th> --}}
                                            <th>iSell</th>
                                            <th>Volume</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>
                                    <p class="pull-left cost_details"></p>
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
                                        <form action="#" autocomplete="off">
                                    <div class="form-group">
                                        {{-- <label for="">Enter Trading Pin</label> --}}
                                        <input type="password" class="form-control" placeholder="Transaction Code" name="trading-pin-buy" autocomplete="off" style="height: 30px">
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
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            {{-- <th>Quantity</th> --}}
                                            <th>iBuy</th>
                                            <th>Volume</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>
                                    <p class="pull-left cost_details"></p>
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
    
@endsection

@push('scripts')
 <!-- Resources -->
        <script src="{{ asset('webapp/scripts/traderoom.js') }}"></script>
        
        <script src="https://www.jqueryscript.net/demo/Simple-jQuery-Html5-Based-360-Degree-Countdown-Timer-countdown360/src/jquery.countdown360.js"></script>
        <script src="{{ asset('js/traderoomSIM.js') }}"></script>
 <script>

            new Vue({
                el: '#trademodal-event',
                data: {
                    // gl_balance: 0
                },
                created(){
                    Echo.channel('traderoom_creation').listen('TradeCreated', (e) => {
                            console.log(e);
                            // this.gl_balance = e.quantity;

                            var trade_card = `
                                <div class="col-md-4">
                                <div class="panel panel-filled " style="border-radius:10px; height: 310px">
                                    <div class="panel-body">
                                        <div class="btn-group pull-right m-b-md">
                                            <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal">Show Details</button>

                                            <!--    <button class="btn btn-default btn-xs">Order</button> -->
                                        </div>
                                        <h4 class="m-t-none"><a href="#">${ e.description }</a></h4>

                                        <div class="row">
                                            <div class="col-md-8">

                                                <a href="#" data-toggle="modal" data-target="#myModal">
                                                    <div class="flot-chart-analytics">
                                                        <div class="flot-chart-content" id="metric9"></div>
                                                </a>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h3 class="m-b-none server1"><span style="color:#BE362E"><i class=""></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

                                                <div class=""><span style="color:#228b22">H 0.00</span></div>
                                                <div class=""><span style="color:#BE362E">L 0.00</span></div>
                                            </div>

                                        </div>
                                        <!-- row -->

                                        <div class="row">
                                            <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                <!--  <h4 class="m-b-none server1">  iSell </h4> -->
                                                <a href="#"  class="btn-link trade-modal-toggler-for-sell" data-security-id="${ e.security }">
                                                    <h4 class="m-b-none server1">iSell </h4></a>

                                                <h5> <span class="usage11 sell-price-container">${ e.buy_price }</span></h5>
                                            </div>
                                            <div class="col-md-2" align="center">&nbsp;</div>
                                            <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
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
                                console.log('tradecard is already on the view');
                                $('#tradecard-container').find(`[data-security-id=${e.security}]`).parent().find('.usage12').html(e.sell_price);
                                $('#tradecard-container').find(`[data-security-id=${e.security}]`).parent().find('.usage11').html(e.buy_price);
                                console.log( $('#tradecard-container').find(`[data-security-id=${e.security}]`).parent().find('.usage11'));
                                console.log(e.sell_price);
                            } else {
                                 $("#tradecard-container").append(trade_card);
                            }
                           
                      buy_toggler({{ auth()->user()->id }}, function(){
                // $("#trademodal-buy #bucketDetails-buy").find("[name=volume]").smartInput();
                var volume =  $("#trademodal-buy #bucketDetails-buy").find("[name=volume]");
                var price = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('dirtyPrice');
                var product = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('productId');
                var gl_balance_for_cash = {{ auth()->user()->profile->gls->where('AccountTypeID', 1)->first()->ClearedBalance }}
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
                    $("#trademodal-buy #bucketDetails-buy .cost_details").html('<b>Consideration</b> <br> ' + '<span class="c-accent">'+accounting.formatNumber(consideration, 2) + '</span>');
                });
             });
             sell_toggler({{ auth()->user()->id }}, function(){
                var volume = $("#trademodal #bucketDetails").find("[name=volume]");
                var price = $("#trademodal #bucketDetails").find('.deal-btn').data('dirtyPrice');
                 var securityId = $("#trademodal #bucketDetails").find('.deal-btn').data('securityId');
                 var product = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('productId');
                 var gl_balance_for_bonds ;
                 $.getJSON('/simulation/getBalanceForSecurity/'+securityId, function(data) {
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
                         $("#trademodal #bucketDetails").find('.volume-error').html("Insufficient Security volume");
                    } else {
                         $(this).removeClass('exceeded')
                          $("#trademodal #bucketDetails").find('.volume-error').html("");
                    }
                    $("#trademodal #bucketDetails .cost_details").html('<b>Consideration </b><br><span class="c-accent">' + accounting.formatNumber(consideration, 2)+'</span>');
                });

             })
                    });

                },
                updated(){
                    this.listenForCreation();
                },
                methods: {
                    listenForCreation() {
                        Echo.channel('traderoom_creation').listen('TradeCreated', (e) => {
                            console.log(e);
                        })
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
                var gl_balance_for_cash = {{ auth()->user()->profile->gls->where('AccountTypeID', 1)->first()->ClearedBalance }}
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
                    $("#trademodal-buy #bucketDetails-buy .cost_details").html('<b>Consideration</b> <br> ' + '<span class="c-accent">'+accounting.formatNumber(consideration, 2) + '</span>');
                });
             });
             sell_toggler({{ auth()->user()->id }}, function(){
                var volume = $("#trademodal #bucketDetails").find("[name=volume]");
                var price = $("#trademodal #bucketDetails").find('.deal-btn').data('dirtyPrice');
                 var securityId = $("#trademodal #bucketDetails").find('.deal-btn').data('securityId');
                 var product = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('productId');
                 var gl_balance_for_bonds ;
                 $.getJSON('/simulation/getBalanceForSecurity/'+securityId, function(data) {
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
                    $("#trademodal #bucketDetails .cost_details").html('<b>Consideration </b><br><span class="c-accent">' + accounting.formatNumber(consideration, 2)+'</span>');
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
                    console.log("error");
                    status = false;
                })
                .always(function() {
                    console.log("complete");
                });
                
            });

                // magic
                $('#trademodal, #trademodal-buy').on('hidden.bs.modal', function (e) {
                    // alert('dismissed')
                    $("#trademodal #bucketDetails").find("[name=volume]").val(0)
                     $("#trademodal-buy #bucketDetails-buy").find("[name=volume]").val(0)
                      $("#trademodal-buy #bucketDetails-buy [type=password]").val(' ');
                      $("#trademodal #bucketDetails .cost_details").html(' ')
                         $("#trademodal-buy #bucketDetails-buy .cost_details").html(' ');
                         $("[type=password]").val('');
                         $(".volume-error").html('');
                });
                $(".smartinput").smartInput();


                // chart / price changes 

                // Charts option for bonds

                var chartUsersOptions = {
                    lines: {
                        show: true,
                        fill: false,
                        lineWidth: 2,
                    },
                     yaxis: {
                        min: 0,
                        max: 200,
                        tickSize: 50
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

                // chart options for tbills
                var chartUsersOptions2 = {
                    lines: {
                        show: true,
                        fill: false,
                        lineWidth: 2,
                    },

                     yaxis: {
                        min: 0,
                        max: 50,
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


                $.each($(".metric9"), function(index, val) {
                     $.ajax({
                    url: '/trade-room/fetch-chart-data',
                    type: 'POST',
                    data: {
                        SecurityID: $(val).data('securityId')
                    },
                })
                .done(function(data) {
                    console.log(data.chart_data);
                    // if(data.length > 0){
                        let  _data = [
                        [0,0]
                        ];
                    $.each(data.chart_data, function(i, v) {
                       _data.push([(v.Day), (v.Yield)]);
                       console.log(v.Yield)
                    });

                    // check if card is bonds or tbills
                    if(data.product == 1){
                        $(val).plot([_data], chartUsersOptions);
                    } else {
                        $(val).plot([_data], chartUsersOptions2);
                    }
                    
                    
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });
                });

                $("<div id='tooltip'></div>").css({
            position: "absolute",
            fontSize: '12px',
            borderRadius: '3px',
            display: "none",
            border: "1px solid #777",
            padding: "2px 5px",
            "background-color": "#000",
            opacity: 0.80
        }).appendTo("body");
               $(".metric9").bind("plothover", function (event, pos, item) {
                var str = "(" + pos.x.toFixed(2) + ", " + pos.y.toFixed(2) + ")";
                $("#hoverdata").text(str);
                if (item) {
                    console.log('item',item)
                    var x = item.datapoint[0].toFixed(0),
                        y = item.datapoint[1];

                    // $("#tooltip").html(y.toFixed(3) + '%, '+x+' days ago')
                    $("#tooltip").html('<b>'+y.toFixed(3) + '</b>%')
                        .css({top: item.pageY+5, left: item.pageX+5})
                        .fadeIn(200);
                } else {
                    $("#tooltip").hide();
                }
        });

               
                

        </script>
@endpush