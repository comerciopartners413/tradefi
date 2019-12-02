@extends('layouts.app')
@push('styles')
<style>
    .content{
        padding:0;
    }

    #bonds-chart, #tbills-chart {
        width: 100% !important;
        height: 300px;
    }

    #rss-feeds ul {
        margin: 0;
        padding: 0; 
        list-style: none;
    }

    #rss-feeds ul  li{
        margin-bottom: 20px
    }

    #rss-feeds ul li a {
        font-size: 18px;
        text-decoration: none;
    }

    #rss-feeds ul li p {
            margin-top: 10px;
    color: #eee;
    }
</style>
@endpush
@section('content')
<div class="row " style="margin-left: 0px;margin-right: 0px;margin-bottom: 30px;padding-bottom:30px">

                <div class="tickercontainer">
                    <div class="mask">
                        <ul id="ticker01" class="newsticker" style="width: 100%;">
                            <li><span>FGN BONDS : 34.25</span>
                                <a href="#"> <i class="fa fa-2x fa-sort-desc"></i> - 0.2% </a>
                            </li>
                            <li><span>USD/NGN  : 1.25</span>
                                <a href="#" style="color:#00b300"> <i class="fa fa-2x fa-sort-asc"></i> 0.72% </a>
                            </li>
                            <li><span>NIBOR  : 17.25</span>
                                <a href="#"> <i class="fa fa-2x fa-sort-desc"></i> -0.62% </a>
                            </li>
                            <li><span>FGN BONDS : 0.25</span>
                                <a href="#"> <i class="fa fa-2x fa-sort-desc"></i> -0.02%</a>
                            </li>
                            <li><span>USD/NGN  : 1.25</span>
                                <a href="#" style="color:#00b300"> <i class="fa fa-2x fa-sort-asc"></i>1.62% </a>
                            </li>
                            <li><span>NIBOR  : 17.25</span>
                                <a href="#"> <i class="fa fa-2x fa-sort-desc"></i> -0.72% </a>
                            </li>
                            <li><span>FOREIGN RESERVES  : 2.25</span>
                                <a href="#" style="color:#00b300"> <i class="fa fa-2x fa-sort-asc"></i> 0.82%</a>
                            </li>
                            <li><span>FGN BONDS : 34.25</span>
                                <a href="#"> <i class="fa fa-2x fa-sort-desc"></i>-1.62% </a>
                            </li>
                            <li><span>USD/NGN  : 1.25</span>
                                <a href="#" style="color:#00b300"> <i class="fa fa-2x fa-sort-asc"></i>0.22% </a>
                            </li>
                            <li><span>NIBOR  : 17.25</span>
                                <a href="#"> <i class="fa fa-2x fa-sort-desc"></i> -0.42% </a>
                            </li>
                            <li><span>FGN BONDS : 0.25</span>
                                <a href="#"> <i class="fa fa-2x fa-sort-desc"></i> -0.62% </a>
                            </li>
                            <li><span>USD/NGN  : 1.25</span>
                                <a href="#" style="color:#00b300"> <i class="fa fa-2x fa-sort-asc"></i>0.42% </a>
                            </li>
                            <li><span>NIBOR  : 17.25</span>
                                <a href="#"> <i class="fa fa-2x fa-sort-desc"></i> -0.09% </a>
                            </li>
                            <li><span>FOREIGN RESERVES  : 2.25</span>
                                <a href="#" style="color:#00b300"> <i class="fa fa-2x fa-sort-asc"></i> 0.32% </a>
                            </li>
                            <!-- eccetera -->
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Main Container-->
            <div class="container-fluid">
                <div class="row">
                    <!-- left side column -->
                    <div class="col-md-6">

                        <!-- Instruments and securities -->
                        <div class="panel panel-filled divSec1 scrollbar" id="style-9">
                            <div class="panel-body">
                                <div class="tabs-container">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#fi" data-toggle="tab" aria-expanded="false">Fixed Income</a></li>
                                        
                                        <li ><a href="#eq" data-toggle="tab" aria-expanded="false">Equities</a></li>
                                        <li ><a href="#fx"  data-toggle="tab" aria-expanded="false">Foreign Exchange</a></li>
                                        <li ><a href="#macros"  data-toggle="tab" aria-expanded="false">Macros</a></li>

                                    </ul>
                                    <div class="tab-content">
                                        <div id="fi" class="tab-pane  active">
                                            <div class="panel-body">

                                                <table class="table table-hover table-striped datatable_home" style="color: #949ba2">
                                                    <thead>
                                                        <tr>
                                                            <th>Type</th>
                                                            <th>Security</th>

                                                            <th>Maturity</th>
                                                            <th>Closing Price/Rate</th>
                                                            <th>Closing Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($pricelist as $pl)
                                                        <tr>
                                                            <td class="isell">
                                                                 @if($pl->ProductID == 1)
                                                                     Bonds
                                                                @else
                                                                    TBills
                                                                @endif
                                                            </td>
                                                            <td class="security">
                                                                {{ str_limit($pl->Description, 20 ) }}
                                                            </td>
                                                            <td class="gr">{{ Carbon\Carbon::parse($pl->Maturity)->toFormattedDateString() }}</td>
                                                            <td class="gr">
                                                                @if($pl->ProductID == 1)
                                                                {{ number_format($pl->ClosingPrice, 2) }}
                                                                @else
                                                                {{ number_format($pl->ClosingPrice, 2) }}%
                                                                @endif
                                                            </td>

                                                            <td>
                                                                {{ Carbon\Carbon::parse($pl->ClosingDate)->toFormattedDateString() }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                        <div id="eq" class="tab-pane">
                                            <div class="panel-body">
                                                <table class="table table-hover table-striped datatable_home" style="color: #949ba2">
                                                    <thead>
                                                            <th>Security</th>
                                                            <th>Open Price</th>
                                                            <th>Closing Price</th>
                                                            <th>Date</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($equities as $eq)
                                                        <tr>
                                                            <td class="security">
                                                                {{ $eq->security }}
                                                            </td>
                                                            <td>
                                                                {{ number_format($eq->previous_close, 2) }}
                                                            </td>
                                                            <td>
                                                                {{ number_format($eq->close_price, 2) }}
                                                            </td>

                                                            <td>
                                                                {{ Carbon\Carbon::parse($eq->date->date)->toFormattedDateString() }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div id="fx" class="tab-pane">
                                            <div class="panel-body">
                                               <table class="table table-hover datatable_home">
                                                    <thead>
                                                        <th></th>
                                                        <th>Current</th>
                                                        <th>Previous</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($fxs as $fx)
                                                        <tr>
                                                            <td>{{ $fx->pairs }}</td>
                                                            <td>{{ number_format($fx->current , 2)}}</td>
                                                            <td>{{ number_format($fx->previous, 2) }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div id="macros" class="tab-pane">
                                            <div class="panel-body">
                                                <table class="table table-hover datatable_home">
                                                    <thead>
                                                        <th></th>
                                                        <th>Current</th>
                                                        <th>Previous</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($macros as $macro)
                                                        <tr>
                                                            <td>{{ $macro->name }}</td>
                                                            <td>{{ number_format($macro->current , 2)}}</td>
                                                            <td>{{ number_format($macro->previous, 2) }}</td>
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

                        <!-- WatchList -->
                        <div class="panel panel-filled divSec1 scrollbar" id="style-9">
                            <div class="panel-body">
                                <div class="tabs-container">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="false">Watchlist</a></li>
                                        <div class="pull-right">
                                        <button class="btn btn-warning btn-sm" style="color: #fff" id="create-watchlist" title="Add new security to your watchlist">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    </ul> 
                                    
                                    <div class="tab-content">
                                        <div id="tab-1" class="tab-pane  active">
                                            <div class="panel-body">

                                                <table class="table table-hover table-striped datatable_home" style="color: #949ba2">
                                                    <thead>
                                                        <tr>

                                                            <th>Action</th>
                                                            <th>Security</th>
                                                            <th>Last Trade</th>
                                                            <th>Total Deals</th>
                                                            {{-- <th>Change</th> --}}
                                                            {{-- <th>Change%</th> --}}
                                                            <th>Total Volume</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($watchlist as $wl)
                                                        <tr>
                                                            <td>
                                                                <button class="btn btn-danger btn-sm remove-watchlist" title="Remove from watchlist" data-security-id="{{ $wl->SecurityID }}">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </td>
                                                            <td class="security">
                                                                {{ $wl->Security }}
                                                            </td>
                                                            <td> {{ number_format($wl->LastPrice, 2) }}</td>
                                                            <td class="gr">{{ $wl->Deals . ' ' .str_plural('deal', $wl->Deals) }}</td>
                                                            {{-- <td class="gr">0.20%</td> --}}
                                                            <td class="text-right"> {{ number_format($wl->Volume) }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                        <div id="tab-2" class="tab-pane">
                                            <div class="panel-body" align="center">
                                                <div id="container" style="height: 400px; width:400px"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- end of left side column -->

                    <!-- right side column -->
                    <div class="col-md-6">
                        <!-- Charts -->
                        <div class="panel panel-filled divSec1 scrollbar" id="style-9">

                            <div class="panel-body ">

                                <div class="tabs-container">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#tab-10" aria-expanded="false">Overview</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">Treasury Bills</a></li>
                                        <li><a data-toggle="tab" href="#tab-4" aria-expanded="false">FGN Bonds</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="tab-10" class="tab-pane active">
                                            <div class="panel-body">
                                                <div id="general-chart"></div>
                                            </div>
                                        </div>
                                        <div id="tab-3" class="tab-pane ">
                                            <div class="panel-body">
                                                <div id="tbills-chart"></div>
                                            </div>
                                        </div>

                                        <div id="tab-4" class="tab-pane">
                                            <div class="panel-body" align="center">
                                                <div id="bonds-chart"></div>
                                            </div>
                                        </div>


                                    </div>

                                </div>

                            </div>

                        </div>

                         <!-- News -->
                        <div class="panel panel-filled divSec1 scrollbar" id="style-9">
                            <div class="panel-body">
                                <div class="">
                                    <h5>  <span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;Top News</h5>
                                    {{-- <hr/> --}}
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div id="rss-feeds"></div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- end of right side column -->
                </div>

            </div>
            <!-- End Main Container-->

            <!-- Modal as an Iframe for news content -->
            <div class="modal fade" id="news-modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header text-center" style="padding: 10px">
                            <h4 class="modal-title">News Content</h4>
                            <p>Source: <em>Bloomberg</em></p>
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

    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.10/sweetalert2.min.css" /> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.10/sweetalert2.min.js"></script>
    
    <script>
    jQuery(function($) {
      $("#rss-feeds").rss("https://www.bloomberg.com/professional/feed/",
      {
         layoutTemplate: "<ul id=\"demo3\" class='ulcust feed-container'>{entries}</ul>",
         limit: 10,
         ssl: true,
        entryTemplate:'<li class="news-item"><a href="{url}" ><b>{title}</b></a><p>{teaserImage}{shortBodyPlain}</p></li>'
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
});
  </script>
    <script>
    // $(function(){
       // $('.datatable_home').DataTable({});
    // })
</script>
<script>
    var chart2 = AmCharts.makeChart("bonds-chart", {
            "type": "pie",
            "theme": "dark",
            "dataProvider": {!! json_encode($bonds_portfolio) !!},
            "fontFamily": "Roboto, sans-serif",
            "fontSize": 9,
            "valueField": "Quantity",
            "titleField": "Description",
            "outlineAlpha": 0.4,
            "depth3D": 15,
            "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
            "angle": 30,
            "export": {
                "enabled": true
            }
        });

        var chart3 = AmCharts.makeChart("tbills-chart", {
            "type": "pie",
            "theme": "chalk",
            "dataProvider": {!! json_encode($tbills_portfolio) !!},
            "fontFamily": "Roboto, sans-serif",
            "fontSize": 12,
            "valueField": "Quantity",
            "titleField": "Description",
            "outlineAlpha": 0.4,
            "depth3D": 15,
            "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
            "angle": 30,
            "export": {
                "enabled": true
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
            }
        });

         $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        // 
        $("#create-watchlist").click(function(e) {
            e.preventDefault();
            var securities = {!! json_encode($securities) !!}
            var securitiesObject = {};
            for(var key of securities) {
                securitiesObject[key.SecurityRef] = key.Security
            }
            // console.log(securitiesObject);
             swal({
              title: 'Watch List',
              text:'Select a security to watch',
              input: 'select',
              inputOptions: securitiesObject,
              animation: false,
              width: '350px',
              color: '#44B366',
              customClass: 'animated tada',
              showCancelButton: true,
              confirmButtonText: 'Add',
              confirmButtonColor:   '#44B366',
              inputPlaceholder : 'Choose Security',
              showLoaderOnConfirm: true,
              allowOutsideClick: false,
              preConfirm:  function(select) {
                return new Promise(function(resolve){
                    return $.ajax({
                        url: '/watch-security',
                        type: 'POST',
                        data: {SecurityRef: select},
                    })
                    .done(function(data) {
                        console.log(data);
                        swal(
                          'Success',
                          data.message,
                          'success'
                        )
                        // append to DOM
                        $("#table1 tbody").append(`
                            <tr>
                                <td>
                                    <button class="btn btn-danger btn-sm remove-watchlist" title="Remove from watchlist" data-security-id="${data.watchlist.SecurityID}">
                                        &times;
                                    </button>
                                </td>
                                <td class="security">
                                    ${data.watchlist.Security}
                                </td>
                                <td> ${data.watchlist.LastPrice }</td>
                                <td class="gr">${data.watchlist.Deals}</td>
                                {{-- <td class="gr">0.20%</td> --}}
                                <td class="text-right"> ${data.watchlist.Volume}</td>
                            </tr>
                            `);
                    })
                    .fail(function(error) {
                        console.log(error);
                        swal.showValidationError(error.responseText)
                        swal.hideLoading()
                        // resolve()
                    })
                    .always(function() {
                        console.log("complete");
                    });
                    
                    resolve();
                    
                });
              }
            })
             // $('select').select2({
             //   dropdownParent: $('.swal2-modal')
             // });
        });

        $(".remove-watchlist").click(function(e) {
            e.preventDefault();
            var that = $(this);
            var security = $(this).data('security-id');
            $.ajax({
                url: 'remove-watchlist',
                type: 'POST',
                data: {SecurityRef: security},
            })
            .done(function(data) {
                console.log("success");
                swal(
                    'Success',
                    data,
                    'success'
                );
                // remove node
                that.closest('tr').remove();


            })
            .fail(function(error) {
                swal(
                    'Oops',
                    error.responseText,
                    'error'
                );
            })
            .always(function() {
                console.log("complete");
            });
            
        });
    </script>

    <!-- news item trigger -->


    
@endpush
