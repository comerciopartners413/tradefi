@extends('layouts.app')

@push('styles')
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

    <script type="text/javascript" src="{{ asset('webapp/vendor/slider/js/jquery-1.7.1.js') }}"></script>

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
    		/*margin-right:300px;*/
    	}
    </style>
@endpush
@section('content')

 <div class="container-fluid" id="normalmodediv" style="/*position:fixed;margin-right:inherit */">
                {{-- <h3>Post to Trade Room</h3> --}}
               {{ Form::open(['action' => 'TradeRoomController@postTrade']) }}
               <div class="row">
                 <div class="form-group col-sm-3">
                        {{ Form::label('SecurityID', 'Security') }}
                        {{ Form::select('SecurityID',$securities->pluck('Description','SecurityRef'), null,['class' => 'form-control']) }}
                    </div>

                    <div class="form-group col-sm-3">
                        {{ Form::label('TransactionTypeID', 'Transaction Type') }}
                        {{ Form::select('TransactionTypeID',$transaction_types->pluck('TransactionType','TransactionTypeRef'), null,['class' => 'form-control']) }}
                    </div>

                    <div class="form-group col-sm-3">
                        {{ Form::label('Quantity') }}
                        {{ Form::text('Quantity',null, ['class' => 'form-control', 'placeholder' => 'Enter Quantity']) }}
                    </div>

                    <div class="form-group col-sm-3">
                        {{ Form::label('Price') }}
                        {{ Form::text('Price',null, ['class' => 'form-control', 'placeholder' => 'Enter Price']) }}
                    </div>
              </div>
              <div class="" style="margin-bottom: 30px">
                  <button class="btn btn-success">Post</button>
              </div>
              {{-- Default PriceMaker to Stanbic --}}
                {{ Form::hidden('PriceMakerID', 1) }}
                {{ Form::close() }}

               <div class="dynamic-form">
                   
               </div>

                <div class="row">
                    <div class="col-md-12 scrollbar" style="height:1000px" id="style-9">

                        <!-- trade card -->
                        <div class="row">

                            {{-- Start Trade Card --}}
                            

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
            <div class="container-fluid" id="easymodediv" style="/*position:fixed;margin-right:inherit */display:none">

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
                                   <h3 class="m-b-none server1"><span style="color:#BE362E"><i class="fa fa-level-down"></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

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
                                   <h3 class="m-b-none server1"><span style="color:#BE362E"><i class="fa fa-level-down"></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

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
                                   <h3 class="m-b-none server1"><span style="color:#BE362E"><i class="fa fa-level-down"></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

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
                                   <h3 class="m-b-none server1"><span style="color:#BE362E"><i class="fa fa-level-down"></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

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
                                   <h3 class="m-b-none server1"><span style="color:#BE362E"><i class="fa fa-level-down"></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

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





@push('scripts')
 <!-- Resources -->
        <script src="{{ asset('webapp/scripts/traderoom.js') }}"></script>
        <script src="{{ asset('js/jquery.tabledit.js') }}"></script>
        <script>
            $(function(){
                // $('.datatable').dataTable({});
            });
        </script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
@endpush