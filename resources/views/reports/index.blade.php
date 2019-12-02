@extends('layouts.app')
@section('content')
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">

                            <div class="pull-right text-right" style="line-height: 14px">
                                <div class="row">

                                    <div class="col-md-6 col-xs-12">

                                        <small class="stat-label">Net Account Value</small>
                                        <h3 class="m-t-xs"> <span style="color:#46be8a">
                                            ₦{{ number_format($net_account_value, 2)  }}
                                            </span>
                                        </h3>

                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <small class="stat-label">Total Unrealized Gain</small>
                                         <h3 class="m-t-xs"> <span style="color:#FFD700">₦{{ number_format($total_unrealized_gain, 2) }}</span></h3> 
                                    </div>

                                </div>

                            </div>
                            <!-- pull right -->
                            <div class="header-icon">

                                <i class="pe page-header-icon pe-7s-graph3"></i>
                            </div>
                            <div class="header-title">
                                <h3>My Reports</h3>
                                <small>
                               Monitor Your Earnings
                            </small>
                            </div>

                        </div>
                        <hr>
                    </div>
                </div>

                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="hide"><a data-toggle="tab" href="#tab-12" aria-expanded="true">Cash Flow</a></li>
                        <li class="active"><a data-toggle="tab" href="#tab-13" aria-expanded="false">Profit or Loss</a></li>
                    </ul>
                    <div class="tab-content">

                        <div id="tab-12" class="tab-pane hide">

                            <div class="panel-body">

                                <div class="col-md-4">
                                    <select class="select2_demo_1 form-control" style="width: 100%">
                                        <option value="1">Next 1 year</option>

                                        <option value="5">Custom</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" id="exampleInputName" placeholder="From">
                                </div>
                                <div class="col-md-4 ">
                                    <input type="date" class="form-control" id="exampleInputName" placeholder="To">
                                </div>
                                <br/>
                                <br/>
                                <div class="row">
                                    <br/>
                                    <br/>
                                    <div class="col-md-12">
                                        <div>
                                            <canvas id="barOptions" height="90%"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel-filled">
                                        <div class="panel-heading">
                                            <div class="panel-tools">
                                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                                <a class="panel-close"><i class="fa fa-times"></i></a>
                                            </div>
                                            Securities
                                        </div>
                                        <div class="">


                                        <div class="tabs-container">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#cashflow-tbills" aria-expanded="false">Treasury Bills</a></li>
                                                <li class=""><a data-toggle="tab" href="#cashflow-bonds" aria-expanded="false">FGN Bonds</a></li>
                                            </ul>
                                            <div class="tab-content">

                                                <div id="cashflow-tbills" class="tab-pane active">
                                                    <div class="panel-body">
                                                        <table id="tableExample3" style="color: #fff" class="table table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Maturity</th>
                                                                    <th>Nominal Amount</th>
                                                                    <th>Holding Value</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($trading_pl_tbills as $cf)
                                                                <tr>
                                                                    <td>{{ $cf->Security }}</td>
                                                                    <td>{{ number_format($cf->Position, 2) }}</td>
                                                                    <td> {{ number_format($cf->CashValue, 2) }} </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                                <div id="cashflow-bonds" class="tab-pane ">
                                                    <div class="panel-body">
                                                        <table id="tableExample3" style="color: #fff" class="table table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Maturity</th>
                                                                    <th>Nominal Amount</th>
                                                                    <th>Holding Value</th>
                                                                    <th>Next Coupon Date</th>
                                                                    <th>Coupon Recievable</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($trading_pl_bonds as $cf)
                                                                <tr>
                                                                    <td>{{ $cf->Security }}</td>
                                                                    <td>{{ number_format($cf->Position, 2) }}</td>
                                                                        <th>{{ number_format($cf->CashValue, 2) }}</th>
                                                                    <td>{{ \Carbon\Carbon::parse($cf->NextCouponDate)->toFormattedDateString() }}</td>
                                                                    <td> {{ number_format($cf->Coupon, 2) }} </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div id="tab-13" class="tab-pane active">
                            <div class="panel-body">
                                <div class="row hide">
                                    <div class="col-md-4">
                                        <select class="select2_demo_1 form-control" style="width: 100%" onclick="contentselection()">
                                            <option value="1">Tbills</option>

                                            <option value="5">Bonds</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" id="exampleInputName" placeholder="From">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" id="exampleInputName" placeholder="To">
                                    </div>

                                </div>
                                <!-- s1 -->
                                <div class="" id="s1" style="display: block">
                                    <div class="row hide">
                                        <br/>
                                        <br/>
                                        <div class="col-md-6">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="panel-tools">
                                                        <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                                        <a class="panel-close"><i class="fa fa-times"></i></a>
                                                    </div>
                                                    Bond Capital Gains
                                                </div>
                                                <div class="panel-body">
                                                    <div class="flot-chart">
                                                        <div class="flot-chart-content" id="flotExample1"></div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="panel-tools">
                                                        <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                                        <a class="panel-close"><i class="fa fa-times"></i></a>
                                                    </div>
                                                    Total Capital Gains
                                                </div>
                                                <div class="panel-body">
                                                    <div class="flot-chart">
                                                        <div class="flot-chart-content" id="flotExample2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel-filled">
                                                <div class="panel-heading">
                                                    <div class="panel-tools">
                                                        <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                                        <a class="panel-close"><i class="fa fa-times"></i></a>
                                                    </div>
                                                    {{-- Securities for date range selected --}}
                                                </div>

                                                <div class="tabs-container">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active"><a data-toggle="tab" href="#pl-tbills" aria-expanded="false">Treasury Bills</a></li>
                                                        <li class=""><a data-toggle="tab" href="#pl-bonds" aria-expanded="false">FGN Bonds</a></li>
                                                        <!--   <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="true">Estimated Income</a></li>
                                                       <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">Gains and Losses</a></li> -->
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div id="pl-tbills" class="tab-pane active">
                                                            <div class="panel-body">
                                                                 <div class="table-responsive">

                                                        <table style="color: #fff" class="table table-striped table-hover datatablesPL">
                                                            <thead>
                                                                <tr>
                                                                    <th>Maturity</th>
                                                                    <th>Nominal Amount</th>
                                                                    <th>Discount Rate</th>
                                                                    <th>Price</th>
                                                                    <th>Yield</th>
                                                                    <th>Market Rate</th>
                                                                    <th>Realised P/L</th>
                                                                    <th>Interest to Date</th>
                                                                    <th>Holding Value</th>
                                                                    <th>Market Value</th>
                                                                    <th>Capital Gain/Loss</th>
                                                                    <th>Total Income</th>
                                                                    <th>Percentage Gain/Loss</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($trading_pl_tbills as $pl_tbills)
                                                                <tr class="ibuy">
                                                                    <td style="width: 100px">{{ $pl_tbills->Security }}</td>
                                                                    <td>{{ number_format($pl_tbills->Position, 2) }}</td>
                                                                    <td> {{ number_format($pl_tbills->DiscountRate, 2) }}% </td>
                                                                    <td>{{ number_format($pl_tbills->Price, 2) }}</td>
                                                                    <td>{{ number_format($pl_tbills->Yield, 2) }}%</td>
                                                                    <td> {{ number_format($pl_tbills->ClosingDiscRate, 2) }}% </td>
                                                                    <td>{{ number_format($pl_tbills->TradingPL, 2) }}</td>
                                                                    <td>{{ number_format($pl_tbills->Int2Date, 2) }}</td>
                                                                    <td>{{ number_format($pl_tbills->CashValue, 2) }}</td>
                                                                    <td>{{ number_format($pl_tbills->MarketValue, 2) }} </td>
                                                                    <td> {{ number_format($pl_tbills->CapitalGainLoss, 2) }}</td>
                                                                    <td>{{ number_format($pl_tbills->TotalIncome, 2) }}</td>
                                                                    <td>{{ number_format($pl_tbills->PercentGainLoss, 2) }}%</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <th></th>
                                                                <th>{{ number_format($trading_pl_tbills->sum('Position'), 2) }}</th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th>{{ number_format($trading_pl_tbills->sum('TradingPL'),2) }}</th>
                                                                <th></th>
                                                                <th>{{ number_format($trading_pl_tbills->sum('CashValue'),2) }}</th>
                                                                <th>{{ number_format($trading_pl_tbills->sum('MarketValue'),2) }}</th>
                                                                <th>{{ number_format($trading_pl_tbills->sum('CapitalGainLoss'),2) }}</th>
                                                                <th>{{ number_format($trading_pl_tbills->sum('TotalIncome'),2) }}</th>
                                                                <th>{{ $trading_pl_tbills->sum('CashValue') <= 0 ? 0 : number_format($trading_pl_tbills->sum('CapitalGainLoss') / $trading_pl_tbills->sum('CashValue') * 100, 2) }}%</th>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                            </div>
                                                        </div>

                                                        <div id="pl-bonds" class="tab-pane">
                                                            <div class="panel-body">
                                                                <div class="table-responsive">

                                                        <table style="color: #fff" class="table table-striped table-hover datatablesPL">
                                                            <thead>
                                                                <tr>
                                                                    <th>Maturity</th>
                                                                    <th>Nominal Amount</th>
                                                                    <th>Clean Price</th>
                                                                    <th>Dirty Price</th>
                                                                    <th>Yield</th>
                                                                    <th>Market Price</th>
                                                                    <th>Realised P/L</th>
                                                                    <th>Interest to Date</th>
                                                                    <th>Holding Value</th>
                                                                    <th>Market Value</th>
                                                                    <th>Capital Gain/Loss</th>
                                                                    <th>Total Income</th>
                                                                    <th>Percentage Gain/Loss</th>
                                                                    <th>Next Coupon Date</th>
                                                                    <th>Coupon Recievable</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($trading_pl_bonds as $pl_bonds)
                                                                <tr class="ibuy">
                                                                    <td style="width: 100px">{{ $pl_bonds->Security }}</td>
                                                                    <td>{{ number_format($pl_bonds->Position, 2) }}</td>
                                                                    <td> {{ number_format($pl_bonds->CleanPrice, 2) }} </td>
                                                                    <td>{{ number_format($pl_bonds->DirtyPrice, 2) }}</td>
                                                                    <td>{{ number_format($pl_bonds->Yield, 2) }}%</td>
                                                                    <td> {{ number_format($pl_bonds->ClosingMktPrice, 2) }} </td>
                                                                    <td>{{ number_format($pl_bonds->TradingPL, 2) }}</td>
                                                                    <td>{{ number_format($pl_bonds->Int2Date, 2) }}</td>
                                                                    <td>{{ number_format($pl_bonds->CashValue, 2) }}</td>
                                                                    <td>{{ number_format($pl_bonds->MarketValue, 2) }} </td>
                                                                    <td> {{ number_format($pl_bonds->CapitalGainLoss, 2) }}</td>
                                                                    <td>{{ number_format($pl_bonds->TotalIncome, 2) }}</td>
                                                                    <td>{{ number_format($pl_bonds->PercentGainLoss, 2) }}%</td>
                                                                    <td>{{ \Carbon\Carbon::parse($pl_bonds->NextCouponDate)->toFormattedDateString() }}</td>
                                                                    <td> {{ number_format($pl_bonds->Coupon, 2) }} </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>

                                                            <tfoot>
                                                                <th></th>
                                                                <th>{{ number_format($trading_pl_bonds->sum('Position'),2) }}</th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th>{{ number_format($trading_pl_bonds->sum('TradingPL'),2) }}</th>
                                                                <th></th>
                                                                <th>{{ number_format($trading_pl_bonds->sum('CashValue'),2) }}</th>
                                                                <th>{{ number_format($trading_pl_bonds->sum('MarketValue'),2) }}</th>
                                                                <th>{{ number_format($trading_pl_bonds->sum('CapitalGainLoss'),2) }}</th>
                                                                <th>{{ number_format($trading_pl_bonds->sum('TotalIncome'),2) }}</th>
                                                                <th>{{ $trading_pl_bonds->sum('CashValue') <= 0 ? 0 : number_format($trading_pl_bonds->sum('CapitalGainLoss') / $trading_pl_bonds->sum('CashValue') * 100, 2) }}%</th>
                                                                <th></th>
                                                                <th>{{ number_format($trading_pl_bonds->sum('Coupon'),2) }}</th>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <!-- s1 -->

                                <!-- s2 -->
                                <div class="hide" id="s2" style="display: none">
                                    <div class="row">
                                        <br/>
                                        <br/>
                                        <div class="col-md-6">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="panel-tools">
                                                        <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                                        <a class="panel-close"><i class="fa fa-times"></i></a>
                                                    </div>
                                                    Treasury Bills Capital Gains
                                                </div>
                                                <div class="panel-body">
                                                    <div class="flot-chart">
                                                        <div class="flot-chart-content" id="flotExample1"></div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="panel-tools">
                                                        <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                                        <a class="panel-close"><i class="fa fa-times"></i></a>
                                                    </div>
                                                    Total Capital Gains
                                                </div>
                                                <div class="panel-body">
                                                    <div class="flot-chart">
                                                        <div class="flot-chart-content" id="flotExample2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel-filled">
                                                <div class="panel-heading">
                                                    <div class="panel-tools">
                                                        <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                                        <a class="panel-close"><i class="fa fa-times"></i></a>
                                                    </div>
                                                    Securities for date range selected
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive">

                                                        <table id="tableExample5" style="color: #fff" class="table table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Maturity</th>
                                                                    <th>Nominal Amount</th>
                                                                    <th>Discount Value</th>
                                                                    <th>Purchase Date</th>
                                                                    <th>Sale Date</th>
                                                                    <th>Purchase Rate</th>
                                                                    <th>Sale Rate</th>
                                                                    <th>Sale Value</th>
                                                                    <th>Total Gain</th>
                                                                    <th>Gain on Trans</th>
                                                                    <th>Annualized Gn</th>
                                                                    <th>Cumm Gn</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="ibuy">
                                                                    <td>18-Jan-18</td>
                                                                    <td>300000000</td>
                                                                    <td> 235,069,231.04 </td>
                                                                    <td>20-Jan-17</td>
                                                                    <td>27-Jan-17 </td>
                                                                    <td> 74.91 </td>
                                                                    <td>74.95</td>
                                                                    <td> 713,424.66 </td>
                                                                    <td>239311878.45</td>
                                                                    <td><span class="gr"><i class="fa fa-level-up"></i> 4.24 </span> </td>
                                                                    <td> 1.80% </td>
                                                                    <td>94.1%</td>
                                                                    <td>4.24</td>
                                                                </tr>
                                                                <!-- <tr class="ibuy">
                                                                    <td>FGN BOND  9.35 31-AUG-2017</td>
                                                                    <td>1000000</td>
                                                                    <td>101.2</td>
                                                                    <td>102.3</td>
                                                                    <td class="red"><i class="fa fa-level-down"></i> 1.10</td>
                                                                    <td> 0.00 </td>
                                                                </tr>
                                                                 <tr class="isell">

                                                                    <td>USD/NGN  </td>
                                                                    <td> 240,000 </td>
                                                                     <td>102.1</td>
                                                                     <td>16.25</td>
                                                                <td><span class="red"><i class="fa fa-level-down"></i> 4% </span></td>
                                                                    <td> 0.00 </td>
                                                                 </tr>-->
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <!-- s2 -->

                            </div>
                        </div>
                        <!-- tab13-->

                    </div>

       @endsection

@push('scripts')
    <script>
            $(document).ready(function() {

                $(".select2_demo_1").select2();

                $('#tableExample3').DataTable({
                    dom: "<'row'<'col-sm-4'l><'col-sm-6'B><'col-sm-2'f>>tp",
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

                $('.datatablesPL').DataTable({
                    dom: "<'row'<'col-sm-4'l><'col-sm-6'B><'col-sm-2'f>>tp",
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

                $('#tableExample6').DataTable({
                    dom: "<'row'<'col-sm-4'l><'col-sm-6'B><'col-sm-2'f>>tp",
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

                var data1 = [
                    [0, 3],
                    [1, 6],
                    [2, 8],
                    [3, 9],
                    [4, 12],
                    [5, 14],
                    [6, 15],
                    [7, 12],
                    [8, 14],
                    [9, 12],
                    [10, 11],
                    [11, 10],
                    [12, 14],
                    [13, 16],
                    [14, 15],
                    [15, 15],
                    [16, 16],
                    [17, 12],
                    [18, 13],
                    [19, 15],
                    [20, 16],
                    [21, 18],
                    [22, 20],
                    [23, 23],
                    [24, 22],
                    [25, 21],
                    [26, 20],
                    [27, 17],
                    [28, 15],
                    [29, 14],
                    [30, 13],
                    [31, 10]
                ];

                var chartUsersOptions = {
                    points: {
                        show: true,
                        fill: true,
                        lineWidth: 1,
                        fillColor: "#f6a821"
                    },
                    grid: {
                        borderWidth: 0
                    }
                };

                $.plot($("#flotExample1"), [data1], chartUsersOptions);

                var chartUsersOptions = {
                    lines: {
                        show: true,
                        fill: false,
                        lineWidth: 2,
                        fillColor: "#f6a821"
                    },
                    grid: {
                        borderWidth: 0
                    }
                };

                $.plot($("#flotExample2"), [data1], chartUsersOptions);

                var data2 = [{
                    label: "bar",
                    data: [
                        [1, 12],
                        [2, 14],
                        [3, 18],
                        [4, 24],
                        [5, 28],
                        [6, 22],
                        [7, 20],
                        [8, 18],
                        [9, 17],
                        [10, 13],
                        [11, 15],
                        [12, 17]
                    ]
                }];

                var chartUsersOptions2 = {
                    bars: {
                        show: true,
                        fill: false,
                        lineWidth: 2,
                        fillColor: "#f6a821"
                    },
                    legend: {
                        show: false
                    },
                    grid: {
                        borderWidth: 0
                    }
                };

                $.plot($("#flotExample3"), data1, chartUsersOptions);

                var chartUsersOptions2 = {
                    lines: {
                        show: true,
                        steps: true
                    },
                    grid: {
                        borderWidth: 0
                    }
                };

                $.plot($("#flotExample4"), data1, chartUsersOptions);

            });

            /**
             * Data for Bar chart
             */

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
                            fontColor: "#90969D",
                            callback: function(value, index, values) {
                                return accounting.formatNumber(value);
                            }
                        },
                        gridLines: {
                            color: "#37393F"
                        }
                    }]
                }
            };

            var barData = {
                labels: {!! $months !!},
                datasets: [{
                    label: "InFlow",
                    backgroundColor: 'transparent',
                    borderColor: "#f6a821",
                    borderWidth: 1,
                    data: {!!  $inflow !!}
                }, {
                    label: "OutFlow",
                    backgroundColor: 'transparent',
                    borderColor: "#676B73",
                    borderWidth: 1,
                    data: {!! $outflow !!}
                }]
            };

            var c3 = document.getElementById("barOptions").getContext("2d");
            new Chart(c3, {
                type: 'bar',
                data: barData,
                options: globalOptions
            });

            function contentselection() {

                var x = document.getElementById('s1');
                var y = document.getElementById('s2');

                if (x.style.display === 'none') {
                    x.style.display = 'block';
                    y.style.display = 'none';
                    alert(3);
                } else {
                    x.style.display = 'none';
                    y.style.display = 'block';
                    alert(2);
                }

            }
        </script>
@endpush