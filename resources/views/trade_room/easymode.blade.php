@extends('layouts.app')
@push('styles')

<style>
    .irs-single {
            background: #b87a0f;
                top: -8px;
                font-size: 14px;
                border: 1px solid #fff;
    }

    .irs-single::after {
            border-top-color: #f6a821;
                bottom: -13px;
                border: 6px solid transparent;
    }

    .irs-bar {
        background: url({{ asset('pages/img/slider-bg.jpg') }}) repeat-x;
            background-position: 0 -60px !important;
    }

    .irs-bar-edge {
        background: url({{ asset('pages/img/slider-bg.jpg') }}) repeat-x;
    background-position: 0 -90px;
}
</style>
@endpush
@section('content')
<div id="trademodal-event">
<div class="container-fluid" id="normalmodediv" style="display:none/*position:fixed;margin-right:inherit */">
                <div class="row">
                    <div class="col-md-4">
                        <label>Security Type</label>
                        <select class="select2_demo_1 form-control" style="width: 100%">
                            <option value="4">All</option>
                            <option value="2">TBills</option>
                            <option value="1">Bonds</option>

                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>From</label>
                        <input type="date" class="form-control" id="exampleInputName" placeholder="From">
                    </div>
                    <div class="col-md-4">
                        <label>To</label>
                        <input type="date" class="form-control" id="exampleInputName" placeholder="To">
                    </div>

                </div>

                <br/>
                <div class="row">
                    <div class="col-md-12 scrollbar" style="height:1000px" id="style-9">

                        <!-- trade card -->
                        <div class="row">

                            <div class="col-md-4">

                                <div class="panel panel-filled " style="border-radius:10px;">
                                    <div class="panel-body">
                                        <div class="btn-group pull-right m-b-md">
                                            <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal">Show Details</button>

                                            <!--    <button class="btn btn-default btn-xs">Order</button> -->
                                        </div>
                                        <h4 class="m-b-none"><a href="#"> FGN2030</a></h4>

                                        <div class="m-b-xs c-white small">20,000</div>

                                        <div class="row">
                                            <div class="col-md-8">

                                                <a href="#" data-toggle="modal" data-target="#myModal">
                                                    <div class="flot-chart-analytics">
                                                        <div class="flot-chart-content" id="metric9"></div>
                                                </a>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h3 class="m-b-none server1"><span style="color:#BE362E"><i class="fa fa-level-down"></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

                                                <div class=""><span style="color:#228b22">H 18.89</span></div>
                                                <div class=""><span style="color:#BE362E">L 16.38</span></div>
                                            </div>

                                        </div>
                                        <!-- row -->

                                        <div class="row">
                                            <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                <!--  <h4 class="m-b-none server1"> iSell </h4> -->
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
                                        <h4 class="m-b-none"><a href="#"> 12- Dec-2019</a></h4>

                                        <div class="m-b-xs c-white small">200,000</div>

                                        <div class="row">
                                            <div class="col-md-8">

                                                <div class="flot-chart-analytics">
                                                    <div class="flot-chart-content" id="metric7"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h3 class="m-b-none server1"><span style="color:#BE362E"><i class="fa fa-level-down"></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

                                                <div class=""><span style="color:#228b22">H 18.89</span></div>
                                                <div class=""><span style="color:#BE362E">L 16.38</span></div>
                                            </div>

                                        </div>
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
                                        <h4 class="m-b-none"><a href="#"> 6- Mar-2018</a></h4>

                                        <div class="m-b-xs c-white small">30,000</div>

                                        <div class="row">
                                            <div class="col-md-8">

                                                <div class="flot-chart-analytics">
                                                    <div class="flot-chart-content" id="metric8"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h3 class="m-b-none server1"><span style="color:#BE362E"><i class="fa fa-level-down"></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

                                                <div class=""><span style="color:#228b22">H 18.89</span></div>
                                                <div class=""><span style="color:#BE362E">L 16.38</span></div>
                                            </div>

                                        </div>
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
                                        <h4 class="m-b-none"><a href="#"> 4- FeB-2017</a></h4>

                                        <div class="m-b-xs c-white small">500,000</div>

                                        <div class="row">
                                            <div class="col-md-8">

                                                <div class="flot-chart-analytics">
                                                    <div class="flot-chart-content" id="metric4"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h3 class="m-b-none server1"><span style="color:#BE362E"><i class="fa fa-level-down"></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

                                                <div class=""><span style="color:#228b22">H 18.89</span></div>
                                                <div class=""><span style="color:#BE362E">L 16.38</span></div>
                                            </div>

                                        </div>
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
                                        <h4 class="m-b-none"><a href="#"> 4- Jan-2018</a></h4>

                                        <div class="m-b-xs c-white small">100,000</div>

                                        <div class="row">
                                            <div class="col-md-8">

                                                <div class="flot-chart-analytics">
                                                    <div class="flot-chart-content" id="metric6"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h3 class="m-b-none server1"><span style="color:#BE362E"><i class="fa fa-level-down"></i></span><span style="color:#FFD700">&nbsp;0.03</span></h3>

                                                <div class=""><span style="color:#228b22">H 18.89</span></div>
                                                <div class=""><span style="color:#BE362E">L 16.38</span></div>
                                            </div>

                                        </div>
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

            </div>
            <!-- end complex method -->

            <!-- easy method -->
            <div class="container-fluid" id="easymodediv" style="/*position:fixed;margin-right:inherit */">

                <div class="row" align="center">

                    <div class="col-md-12">
                        <div class="layout-slider-settings">
                            <label><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Lets get you started.....How much do you wish to invest in this trade?</label>
                        </div>
                        <br/>
                        <div class="layout-slider">
                            <input id="Slider2" type="slider" class="smartinput form-control text-center ranger" name="price" value=""  />
                            <input type="hidden" id="slider-real-value">
                        </div>
                        

                    </div>

                    <div class="col-md-12">
                        <br/>
                        <br/>
                        <label> <i class="fa fa-question-circle" aria-hidden="true"></i>&nbsp;What Security Type would you like to buy/sell?</label>
                        <select class="select2_demo_1 form-control" style="width: 30%" id="select_sec_type">
                            <option value="0" selected disabled>Select one Security</option>
                            <option value="2">Treasury bills</option>
                            <option value="1">Bonds</option>

                        </select>


                        {{-- Separate tenor days for tbills --}}

                        <br/>
                        <br/>
                        <div style="display: none;background: #232526;  /* fallback for old browsers */
background: -webkit-linear-gradient(to left, #414345, #232526);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to left, #414345, #232526); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
; padding: 10px; border-radius: 10px;" id="sc">

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
                                    <select id="benchmark-selector" class=" form-control tbills" style="width: 30%">
                                        <option value="0" selected disabled>Select Benchmark</option>
                                        <option value="90">90</option>
                                        <option value="180">180 days</option>
                                        <option value="364">364 days</option>
                                    </select>

                                    <select id="benchmark-selector" class=" form-control bonds" style="width: 30%">
                                        <option value="0" selected disabled>Select Benchmark</option>
                                        <option value="{{ 365 }}">1 yr</option>
                                        <option value="{{ 365 * 3 }}">3 yrs</option>
                                        <option value="{{ 365 * 5 }}">5 yrs</option>
                                    </select>
                                </div>
                                <!-- <div class="col-md-3 col-xs-12"><label>From</label>
                              <input type="date" class="form-control" id="exampleInputName" placeholder="From">
                           </div>
                            <div class="col-md-3 col-xs-12"><label>To</label>
                              <input type="date" class="form-control" id="exampleInputName" placeholder="To">
                            </div> -->
                                <div class="col-md-2 col-xs-12">
                                    <button id="easy-mode-search-button" class="btn  btn-cons m-t-10" style="background-color:#C68B34;border-color:#C68B34;color:#f2f6f7" type="submit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                                </div>
                                <div class="col-md-2 col-xs-3">

                                </div>

                            </div>
                            <hr/>
                            <br/>
                             <div class="loader-placeholder"></div>
                            <br/>

                            <!-- maturities content 1 -->
                           <div class="row tradecard-container-easy-mode" id="mc1" style="display: none">
                                
                                
                            </div>
                            <!-- end maturities content 1 -->


                        </div>

                    </div>
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
                                    <p class="pull-left cost_details">
                                        <b>Consideration</b> <br><span class="c-accent">0.00</span>
                                    </p>
                                    <p class="pull-right gl"></p>
                                </table>
                                <p class="volume-error"></p>
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

                            <div>
                                <div class="row">
                                    <div class="pull-left col-sm-6">
                                        <form action="#" autocomplete="off">
                                    <div class="">
                                        {{-- <input type="password" class="form-control" placeholder="Transaction Code" name="trading-pin-sell" autocomplete="off" style="height: 30px"> --}}
                                        {{-- <span class="input-group-btn">
                                            <button class="btn btn-sm btn-success check-trading-pin" style="color: #fff;background: #20a57b;">ok</button>
                                        </span> --}}
                                    </div>
                                </form>
                                </div>
                                <div class="pull-right">
                                    <a href="#" data-dismiss="modal" class="btn btn-w-md btn-accent btn-rounded">Dismiss Window</a>
                                </div>
                                </div>
                                
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
                                    <p class="pull-left cost_details">
                                        <b>Consideration</b> <br><span class="c-accent">0.00</span>
                                    </p>
                                    <p class="pull-right gl"></p>
                                </table>
                                <p class="volume-error"></p>
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

                            <div>
                                <div class="row">
                                    <div class="pull-left col-sm-6">
                                        <form action="#" autocomplete="off">
                                    <div class="">
                                        
                                           {{--  <input type="password" class="form-control" placeholder="Transaction Code" name="trading-pin-buy" autocomplete="off" style="height: 30px"> --}}
                                   {{--  <span class="input-group-btn">
                                        <button class="btn btn-sm btn-success" style="color: #fff; background: #20a57b;">ok</button>
                                    </span> --}}
                                    </div>
                                    </form>
                                </div>
                                <div class="pull-right">
                                    <a href="#" data-dismiss="modal" class="btn btn-w-md btn-accent btn-rounded">Dismiss Window</a>
                                </div>
                                </div>
                                
                                <div class="clearfix"></div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection




{{-- push styles --}}
@push('styles')
	<style type="text/css">
		section.content {
			margin-right:300px;
			margin-top: 40px;
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
	</style>
@endpush


{{-- push scripts --}}

@push('scripts')
 <!-- Resources -->
        <script src="{{ asset('webapp/scripts/traderoom.js') }}"></script>
        <script src="https://www.jqueryscript.net/demo/Simple-jQuery-Html5-Based-360-Degree-Countdown-Timer-countdown360/src/jquery.countdown360.js"></script>
        <script src="{{ asset('js/traderoom.js') }}"></script>
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
                var gl_balance_for_cash = {{ auth()->user()->gls->where('AccountTypeID', 1)->first()->ClearedBalance }}
                // volume.smartInput();
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
                 $.getJSON('/getBalanceForSecurity/'+securityId, function(data) {
                    gl_balance_for_bonds = data;
                    $("#trademodal #bucketDetails .gl").html('<b>Security Balance </b><br><span class="c-accent">' + accounting.formatNumber(gl_balance_for_bonds, 2)+ '</span>');
                 });
                 // volume.smartInput();
                
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

             $(function(){
                 $('.ranger').ionRangeSlider({
                    grid: true,
                    min: 100000,
                    max: {{ auth()->user()->gls->first()->ClearedBalance }},
                    prefix: "₦",
                    step: 100000,
                    extra_classes: 'tred',
                    onStart: function (data) {
                        $("#slider-real-value").val(data.from);
                    },
                    onChange: function (data) {
                        $("#slider-real-value").val(data.from);
                         $(".tradecard-container-easy-mode").html('');
                    }
                 });
             })

             buy_toggler({{ auth()->user()->id }}, function(){
                // $("#trademodal-buy #bucketDetails-buy").find("[name=volume]").smartInput();
                var volume =  $("#trademodal-buy #bucketDetails-buy").find("[name=volume]");
                var price = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('dirtyPrice');
                var product = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('productId');
                var gl_balance_for_cash = {{ auth()->user()->gls->where('AccountTypeID', 1)->first()->ClearedBalance }}
                // volume.smartInput();

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
                 $.getJSON('/getBalanceForSecurity/'+securityId, function(data) {
                    gl_balance_for_bonds = data;
                    $("#trademodal #bucketDetails .gl").html('<b>Security Balance </b><br><span class="c-accent">' + accounting.formatNumber(gl_balance_for_bonds, 2)+ '</span>');
                 });
                
                // var cost = volume.val() * price/100
                // volume.smartInput();
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

       

        {{-- Timer for modal --}}
        <script>
            $("#Slider2").keyup(function(e) {
                e.preventDefault();
                $(".tradecard-container-easy-mode").html('');

                // $("#tradecard-container-easy-mode").show();

                 $('#select_sec_type').select2("val", 0);


            });

        $("#select_sec_type").change(function(e) {
            e.preventDefault();
            if($(this).val() == 1 ) {
                console.log('Bonds');
                $("#benchmark-selector.tbills").hide();
                $("#benchmark-selector.bonds").show();

            } else {
                console.log('TBills');
                $("#benchmark-selector.bonds").hide();
                $("#benchmark-selector.tbills").show();
            }
            $('#sc').show();

        });


         $("#benchmark-selector.bonds").change(function(e) {
             e.preventDefault();
             $LengthOfInvestment = $(this).val()
         });

          $("#benchmark-selector.tbills").change(function(e) {
             e.preventDefault();
             $LengthOfInvestment = $(this).val()
         });




                // onchange of select box
                $(".tradecard-container-easy-mode").html('');
                $('#easy-mode-search-button').click(function(e) {
                    e.preventDefault();
                    // perform ajax call to send params to Easy Trade Procedure
                    var LengthOfInvestment = $LengthOfInvestment;
                    $.ajax({
                        url: '/trade-room/fetch-easy',
                        type: 'POST',
                        data: {
                            Amount: $("#slider-real-value").val(),
                            ProductID:  $('#select_sec_type').select2("val"),
                            LengthOfInvestment: LengthOfInvestment
                        },
                        beforeSend: function(){
                            $('.loader-placeholder').show();
                            $('.loader-placeholder').text('Loading Securities...');
                        }
                    })
                    .done(function(data) {

                            if(data.length == 0) {
                                $('.loader-placeholder').show();
                                $('.loader-placeholder').text('No Results');
                            }

                        $('.loader-placeholder').hide();
                       $('.tradecard-container-easy-mode').show();
                       
                       console.log(data)
                       $(".tradecard-container-easy-mode").html('');
                       $.each(data, function(index, val) {
                            $(".tradecard-container-easy-mode").append(`
                            <div class="col-md-4">

                                    <div class="panel panel-filled " style="border-radius:10px;">
                                        <div class="panel-body">
                                            <div class="btn-group pull-right m-b-md">
                                                <button class="btn btn-default btn-xs" style="color: #fff">
                                                    <span class="fa fa-cog"></span>
                                                </button>
                                                <!-- <button class="btn btn-default btn-xs">Order</button> -->
                                            </div>
                                            <h5 class="" style="margin-bottom: 20px; margin-top: 5px;"><a href="#"> ${ val.Description } </a></h5>

                                            <div class="m-b-xs c-white small">Volume: <b>${ accounting.formatNumber(val.Volume, 2) }</b></div> <br>

                                            <div class="row">
                                                <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">

                                                    <!--   <h4 class="m-b-none server1">  iSell </h4> -->
                                                    <a href="#" class="btn-link trade-modal-toggler-for-sell" data-security-id="${ val.SecurityID }">
                                                        <h4 class="m-b-none server1">iSell </h4></a>

                                                    <h5> <span class="usage3">${ accounting.formatNumber(val.BuyPrice, 2) }</span></h5>
                                                </div>
                                                <div class="col-md-2" align="center">&nbsp;</div>
                                                <div class="col-md-5 tradeCard2" align="center" style=" background-color: #6E6D76; border-radius:10px; ">
                                                    <!--  <h4 class="m-b-none server1">  iBuy </h4> -->
                                                    <a href="#"  class="btn-link trade-modal-toggler-for-buy" data-security-id="${ val.SecurityID }" data-volume="${ val.Volume}">
                                                        <h4 class="m-b-none server1">iBuy </h4></a>

                                                    <h5> <span class="usage9">${ accounting.formatNumber(val.SellPrice, 2) }</span> </h5>
                                                </div>
                                            </div>

                                            <!--   <small><i class="fa fa-clock-o"></i> Last active in: 14.08.2017</small> -->
                                        </div>

               </div>
           </div>
                        `);
                       });


                      buy_toggler({{ auth()->user()->id }}, function(){
                // $("#trademodal-buy #bucketDetails-buy").find("[name=volume]").smartInput();
                var volume =  $("#trademodal-buy #bucketDetails-buy").find("[name=volume]");
                var price = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('dirtyPrice');
                var product = $("#trademodal-buy #bucketDetails-buy").find('.deal-btn').data('productId');
                var easymode_generated_volume = $(".tradecard-container-easy-mode").find('.trade-modal-toggler-for-buy').data('volume');
                console.log(';;;;;;')
                console.log($(this))
                var gl_balance_for_cash = {{ auth()->user()->gls->where('AccountTypeID', 1)->first()->ClearedBalance }}
                // volume.smartInput();
                volume.attr('disabled', 'disabled');
                //var cost = volume.val() * price/100
                // $("#trademodal-buy #bucketDetails-buy .gl").html('<b>Cash Balance </b><br> <span class="c-accent">' + accounting.formatNumber(gl_balance_for_cash, 2)+'</span>');
                // update consideration
                var consideration = accounting.unformat(easymode_generated_volume) * price / 100
                $("#trademodal-buy #bucketDetails-buy .cost_details").html('<b>Consideration</b> <br> ' + '<span class="c-accent">'+accounting.formatNumber(consideration, 2) + '</span>');
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
                         $("#trademodal #bucketDetails").find('.volume-error').html("Insufficient Security volume");
                    } else {
                         $(this).removeClass('exceeded')
                          $("#trademodal #bucketDetails").find('.volume-error').html("");
                    }
                    $("#trademodal #bucketDetails .cost_details").html('<b>Consideration </b><br><span class="c-accent">' + accounting.formatNumber(consideration, 2)+'</span>');
                });

             })
                       
                    })
                    .fail(function(error) {
                        console.log(error);
                        $('.loader-placeholder').show();
                        $('.loader-placeholder').text('No result');
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
                      $("#trademodal #bucketDetails .cost_details").html('<b>Consideration </b><br><span class="c-accent">' + accounting.formatNumber(0, 2)+'</span>');
                         $("#trademodal-buy #bucketDetails-buy .cost_details").html('<b>Consideration </b><br><span class="c-accent">' + accounting.formatNumber(0, 2)+'</span>');
                });
                $(".smartinput").smartInput();

        </script>
@endpush