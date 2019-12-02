@extends('layouts.app')
@section('content')
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">

                            <div class="pull-right text-right" style="line-height: 14px">
                                <div class="row">

                                </div>

                            </div>
                            <!-- pull right -->
                            <div class="header-icon">
                                <i class="pe page-header-icon pe-7s-graph3"></i>
                            </div>

                            <div class="header-title">
                                <h3>Stanbic Trades Downloader</h3>
                                <small>
                                Download Historic and Present Trades
                            </small>

                            </div>

                        </div>
                        <hr>
                         <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-client" aria-expanded="false">Client</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-comercio" aria-expanded="false">Comercio</a></li>
                                <!--   <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="true">Estimated Income</a></li>
                               <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">Gains and Losses</a></li> -->
                            </ul>
                            <div class="tab-content">
                                <div id="tab-client" class="tab-pane active">
                                    <div class="panel-body">


                                <div class="row">

                                    <div class="col-sm-6">
                                        <p>Click the button below to download today's Trade</p>
                                        <a href="{{ url('downloadExcel/csv') }}" class="btn btn-warning">Download </a>
                                    </div>

                                </div>
                                <hr>
                                <h4>Historic Trade Downloader</h4>

                                <table class="table datatable">
                                    <thead>
                                        <th>Report</th>
                                        <th>Action</th>
                                    </thead>

                                    <tbody>
                                        @foreach( $tradelist as $tl)
                                        <tr>
                                            <td>Trade For {{ $tl->TradeDate }}</td>
                                            <td><a href="{{ url('downloadExcel2/csv/'. str_replace('/', '-', $tl->TradeDate)) }}" class="btn btn-warning"><i class="pe-7s-cloud-download c-accent"></i> Download</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                                </div>

                                <div id="tab-comercio" class="tab-pane">
                                     <div class="panel-body">
                                <div class="row">

                                    <div class="col-sm-6">
                                        <p>Click the button below to download today's Trade</p>
                                        <a href="{{ url('downloadExcelComercio/csv') }}" class="btn btn-warning">Download </a>
                                    </div>

                                </div>
                                <hr>
                                <h4>Historic Trade Downloader</h4>

                                <table class="table datatable">
                                    <thead>
                                        <th>Report</th>
                                        <th>Action</th>
                                    </thead>

                                    <tbody>
                                        @foreach( $tradelist as $tl)
                                        <tr>
                                            <td>Trade For {{ $tl->TradeDate }}</td>
                                            <td><a href="{{ url('downloadExcelComercio2/csv/'. str_replace('/', '-', $tl->TradeDate)) }}" class="btn btn-warning"><i class="pe-7s-cloud-download c-accent"></i> Download</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                                </div>
                            </div> 
                            </div>


                            <!---->
                        <div class="panel panel-filled"></div>
                    </div>
                </div>


       @endsection

@push('scripts')
   
@endpush