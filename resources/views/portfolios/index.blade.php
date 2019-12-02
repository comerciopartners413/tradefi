@extends('layouts.app')
<?php
 $current_user_id = auth()->user()->id;
?>
@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">


<style>
    .toggler {
        font-size: 8px;
        color: #fff;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        padding: 0;
    }

    .table > tbody + tbody {
        border-top: 2px solid #5f606b;
        /*font-weight: bold;*/
    }

    .row-details {
        font-weight: 400 !important;
    }

    .row-details > tr {
        background: #2d2e32 !important;
    }

    @media screen and (max-width: 600px) {
  table {
    border: 0;
  }
  table thead {
    display: none;
  }
  table tr {
    border-bottom: 2px solid #ddd;
    display: block;
    margin-bottom: 10px;
  }
  table td {
    border-bottom: 1px dotted #ccc;
    display: block;
    font-size: 13px;
    text-align: right;
  }
  table td:last-child {
    border-bottom: 0;
  }
  table td:before {
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: capitalize;
  }

  .nav-tabs > li > a {
    margin-right: 0;
    border-radius: 0;
    border: 0;
    padding: 10px;
  }

  .nav-tabs {
    border: none;
    display: flex;
    justify-content: space-between;
}
}
</style>
@endpush
@section('content')
<div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">

                            
                            <!-- pull right -->
                            <div class="header-icon">
                                <i class="pe page-header-icon pe-7s-wallet"></i>
                            </div>
                            <div class="header-title">
                                <h3>My Portfolio</h3>
                                <small>
                                Securities in hand
                                <br>
                                {{-- @if(\App::environment('production'))
                                @endif --}}
                            </small>
                            </div>

                        </div>
                        <hr>
                    </div>
                </div>

                <div class="row">

                    <!-- <div class="col-md-4">
                        <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>
                           Securities Overview 
                        </div>
                        <div class="panel-body">
                            <div>
                                <canvas id="polarOptions" height="180"></canvas>
                            </div>
                        </div>
                    </div>
                </div>-->

                    <div class="col-md-12">

                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="false">Overview</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-4" aria-expanded="false">Treasury Bills</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-5" aria-expanded="false">FGN Bonds</a></li>
                                <!--   <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="true">Estimated Income</a></li>
                               <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">Gains and Losses</a></li> -->
                            </ul>
                            <div class="tab-content">
                                <div id="tab-4" class="tab-pane">
                                    <div class="panel-body">

                                        {{-- <div class="row">
                                            <div class="col-md-4">
                                                <select class="select2_demo_1 form-control" style="width: 100%">
                                                    <option value="1">Market Value</option>

                                                    <option value="5">Nominal Value</option>
                                                </select>
                                            </div>
                                        </div> --}}

                                        <div id="tbills-chart"></div>

                                        <!-- Table for tbills portfolio data-->
                                        <div class="table-responsive">

                                            <table style="color: #fff" class="table table-striped table-hover datatable">
                                                <thead>
                                                   <tr>
                                                        <th></th>
                                                        <th>Maturity</th>
                                                        <th>Nominal Amount</th>
                                                        <th>Discount Rate</th>
                                                        
                                                        <th>Yield</th>
                                                        <th>Price</th>
                                                        {{-- <th>Market Rate</th> --}}
                                                        {{-- <th>Amount Invested</th> --}}
                                                        {{-- <th>Market Val.</th> --}}
                                                        {{-- <th>Accrued Interest</th> --}}
                                                        {{-- <th>Gain/Loss</th> --}}
                                                        {{-- <th>Total Income</th> --}}
                                                        {{-- <th>% Change</th> --}}
                                                    </tr>
                                                </thead>
                                                 <tbody>
                                                    @foreach($trading_pl_tbills as $pl_tbills)
                                                        {{-- @if($tl->ProductID == 2) --}}
                                                        <tr class="has-row">
                                                            <td data-label="">
                                                                <button class="btn btn-sm btn-warning btn-rounded toggler" data-security="security-{{ $pl_tbills->SecurityID }}">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </td>
                                                           <td data-label="Maturity" >{{ $pl_tbills->Security }}</td>
                                                                    <td data-label="Nominal Amount">{{ number_format($pl_tbills->Position, 2) }}</td>
                                                                    <td data-label="Discount Rate"> {{ number_format($pl_tbills->DiscountRate, 2) }}% </td>
                                                                    
                                                                    <td data-label="Yield">{{ number_format($pl_tbills->Yield, 2) }}%</td>
                                                                    <td data-label="Price">{{ number_format($pl_tbills->Price, 2) }}</td>
                                                                    {{-- <td> {{ number_format($pl_tbills->ClosingDiscRate, 2) }} </td> --}}

                                                             {{-- <td>number_format($tl->MarketValue, 2)</td> --}}
                                                              {{-- <td>{{ number_format($pl_tbills->Int2Date, 2) }}</td> --}}

                                                            {{-- <td class="{{ ($pl_tbills->CapitalGainLoss) < 0 ? 'sale' : 'buy' }} {{ ($pl_tbills->CapitalGainLoss) == 0 ? 'mute' : 'null' }}"> --}}
                                                                {{-- number_format(abs($pl_tbills->CapitalGainLoss) , 2) --}} 


                                                            
                                                            {{-- <td> 0.01 </td> --}}
                                                        </tr>
                                                         
                                                        {{-- <tr class="row-details hide">
                                                            
                                                        </tr> --}}
                                                       
                                                        
                                                        {{-- @endif --}}
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        {{-- <div class="row">
                                            <div class="col-md-4">
                                                <select class="select2_demo_1 form-control" style="width: 100%">
                                                    <option value="1">Market Value</option>

                                                    <option value="5">Nominal Value</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div id="general-chart">
                                            
                                        </div>
                                        <br>
                                        <div class="table-responsive">

                                        </div>
                                    </div>
                                </div>
                                <div id="tab-5" class="tab-pane">
                                    <div class="panel-body">
                                        {{-- <div class="row">
                                            <div class="col-md-4">
                                                <select class="select2_demo_1 form-control" style="width: 100%">
                                                    <option value="1">Market Value</option>

                                                    <option value="5">Nominal Value</option>
                                                </select>
                                            </div>
                                        </div> --}}

                                        <div id="bonds-chart">
                                            @if(empty($bonds_portfolio))
                                            <p class="text-center">Bonds not acquired yet</p>
                                            @endif
                                        </div>

                                        <!-- Table for bonds portfolio data-->
                                        <div class="table-responsive">

                                            <table style="color: #fff" class="table table-striped table-hover datatable">
                                                <thead>
                                                        <th></th>
                                                        <th>Maturity</th>
                                                        <th>Nominal Amount</th>
                                                        <th>Yield</th>
                                                        {{-- <th>Market Yield</th> --}}
                                                        <th> Price</th>
                                                        <th>Dirty Price</th>
                                                        {{-- <th>Market Price</th> --}}
                                                        {{-- <th>Amount Invested</th> --}}
                                                        {{-- <th>Market Val.</th> --}}
                                                        {{-- <th>Accrued Interest</th> --}}
                                                        {{-- <th>Gain/Loss</th> --}}
                                                        {{-- <th>Total Income</th> --}}
                                                        {{-- <th>% Change</th> --}}

                                                       
                                                </thead>
                                                <tbody>
                                                    @foreach($trading_pl_bonds as $pl_bonds)
                                                        {{-- @if($tl->ProductID == 1) --}}
                                                        <tr class="has-row">
                                                            <td>
                                                                <button class="btn btn-sm btn-warning btn-rounded toggler" data-security="security-{{ $pl_bonds->SecurityID }}">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </td>
                                                            <td  data-label="Maturity">{{ $pl_bonds->Security }}</td>
                                                             <td data-label="Nominal Amount">{{ number_format($pl_bonds->Position, 2) }}</td>
                                                                    
                                                                    <td data-label="Yield">{{ number_format($pl_bonds->Yield, 2) }}%</td>
                                                                    {{-- <td> {{ number_format($pl_bonds->ClosingMktPrice, 2) }} </td> --}}
                                                                    <td data-label="Price"> {{ number_format($pl_bonds->CleanPrice, 2) }} </td>
                                                                    <td data-label="Dirty Price"> {{ number_format($pl_bonds->DirtyPrice, 2) }} </td>
                                                                    {{-- <td>{{ number_format($pl_bonds->ClosingMktPrice, 2) }}</td> --}}

                                                             {{-- <td>number_format($tl->MarketValue, 2)</td> --}}
                                                              {{-- <td>{{ number_format($pl_bonds->Int2Date, 2) }}</td> --}}

                                                            {{-- <td class="{{ ($pl_bonds->CapitalGainLoss) < 0 ? 'sale' : 'buy' }} {{ ($pl_bonds->CapitalGainLoss) == 0 ? 'mute' : 'null' }}"> --}}
                                                                {{-- number_format(abs($pl_bonds->CapitalGainLoss) , 2) --}} 

                                                             </td>

                                                            
                                                            {{-- <td> 0.01 </td> --}}
                                                        </tr>
                                                         
                                                        {{-- <tr class="row-details hide">
                                                            
                                                        </tr> --}}
                                                       
                                                        
                                                        {{-- @endif --}}
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <div id="tab-6" class="tab-pane">
                                    <div class="panel-body">

                                        <div class="row">
                                            <!--   <div class="col-md-4">
                                    <div>
                                <canvas id="polarOptions" height="180"></canvas>
                            </div>
                                </div> -->

                                            <div class="col-md-12">
                                                <div id="container" style="height: 70%"></div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div id="tab-3" class="tab-pane">
                                    <div class="panel-body">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <select class="select2_demo_1 form-control" style="width: 100%">
                                                    <option value="1">Next 1 year</option>

                                                    <option value="5">Custom</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control" id="exampleInputName" placeholder="From">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control" id="exampleInputName" placeholder="To">
                                            </div>

                                        </div>

                                        <br/>
                                        <br/>
                                        <div class="row text-center">

                                            <div class="col-lg-6 col-xs-6">
                                                <div class="">

                                                    <div class="panel-body">
                                                        <h2 class="m-b-none">
                                <span style="color:#fff">   ₦191,293.90 </span><span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i> +20%</span>
                                </h2>
                                                        <div class="stat-label">Total Gain Realized</div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xs-6">
                                                <div class="">
                                                    <div class="panel-body">
                                                        <h2 class="m-b-none">
                                    ₦140,000 <span class="slight"><i class="fa fa-play fa-rotate-90 text-danger"> </i> 5%</span>
                                </h2>
                                                        <div class="stat-label">Short-Term Gain Realized</div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-xs-6">
                                                <div class=" ">

                                                    <div class="panel-body">
                                                        <h2 class="m-b-none">
                                    ₦202,000.98 <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i> +20%</span>
                                </h2>
                                                        <div class="stat-label"><span class="label label-accent">Long-Term Gain Realized</span></div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xs-6">
                                                <div class="">
                                                    <div class="panel-body">
                                                        <h2 class="m-b-none">
                                    ₦10,000 <span class="slight"><i class="fa fa-play fa-rotate-90 text-danger"> </i> 5%</span>
                                </h2>
                                                        <div class="stat-label">Total Commission and Fees</div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="tab-2" class="tab-pane">

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

                                            <div class="col-md-12">
                                                <div>
                                                    <canvas id="barOptions" height="90%"></canvas>
                                                </div>
                                            </div>

                                            <!--  <div class="col-md-4">

                     </div>-->

                                        </div>
                                        <!-- row -->
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- col8 -->
                </div>
                {{--  <div class="row">
                    <div class="col-md-12">
                        <div class="panel-filled">
                            <div class="panel-heading">
                                <div class="panel-tools">
                                    <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                    <a class="panel-close"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                            </div>
                        </div>
                    </div>

                </div>  --}}

            </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script>
	$('.datepicker').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd'
	});

    // $('.datat').DataTable({});

    $('.toggler').click(function(e) {
        e.preventDefault();
        var toggler_id = $(this).data('security');
        $("tbody."+toggler_id).toggleClass('hide','slow');
        // change toggler Icon
        $(this).toggleClass('opened');

        if($(this).hasClass('opened')){
                $(this).html('<i class="fa fa-minus"></i>');
            } else {
                $(this).html('<i class="fa fa-plus"></i>');
            }          
    });

   
</script>

 <script>


        var chart2 = AmCharts.makeChart("bonds-chart", {
            "type": "pie",
            "theme": "dark",
            "dataProvider": {!! json_encode($bonds_portfolio) !!},
            "fontFamily": "Roboto, sans-serif",
            "fontSize": 12,
            "valueField": "Quantity",
            "titleField": "MaturityDate",
            "outlineAlpha": 0.4,
            "depth3D": 15,
            "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
            "angle": 30,
            "export": {
                "enabled": true
            },
            "responsive": {
              "enabled": true,
              "addDefaultRules": true,
              "rules": [
                {
                  "maxWidth": 200,
                  "overrides": {
                    "legend": {
                      "enabled": true
                    }
                  }
                }
              ]
            }
        });

        var chart3 = AmCharts.makeChart("tbills-chart", {
            "type": "pie",
            "theme": "chalk",
            "dataProvider": {!! json_encode($tbills_portfolio) !!},
            "fontFamily": "Roboto, sans-serif",
            "fontSize": 12,
            "valueField": "Quantity",
            "titleField": "MaturityDate",
            "outlineAlpha": 0.4,
            "depth3D": 15,
            "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
            "angle": 30,
            "export": {
                "enabled": true
            },
            "responsive": {
              "enabled": true,
              "addDefaultRules": true,
              "rules": [
                {
                  "maxWidth": 200,
                  "overrides": {
                    "legend": {
                      "enabled": true
                    }
                  }
                }
              ]
            }
        });

        var chart4 = AmCharts.makeChart("general-chart", {
            "type": "pie",
            "theme": "chalk",
            "dataProvider": {!! json_encode($general_portfolio) !!},
            "fontFamily": "Roboto, sans-serif",
            "fontSize": 12,
            "valueField": "Quantity",
            "titleField": "Product",
            "outlineAlpha": 0.4,
            "depth3D": 15,
            "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
            "angle": 30,
            "export": {
                "enabled": true
            },
            "responsive": {
              "enabled": true,
              "addDefaultRules": true,
              "rules": [
                {
                  "maxWidth": 200,
                  "overrides": {
                    "legend": {
                      "enabled": true
                    }
                  }
                }
              ]
            }
        });
    </script>
@endpush
