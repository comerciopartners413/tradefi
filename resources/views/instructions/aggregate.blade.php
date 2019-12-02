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
                                <i class="pe page-header-icon pe-7s-note2"></i>
                            </div>

                            <div class="header-title">
                                <h3>Aggregate Trade Instructions</h3>
                                <small>Download Aggregate instructions</small>

                            </div>

                        </div>
                        <hr>
                         <div class="tabs-container">
                            {{-- <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-client" aria-expanded="false">Client</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-comercio" aria-expanded="false">Comercio</a></li>
                            </ul> --}}
                            <div class="tab-content">
                                <div id="tab-client" class="tab-pane active">
                                    <div class="panel-body">


                                <div class="row">

                                    <div class="col-sm-8">
                                        <p>Use the buttons below to download instructions for today's trades</p>
                                        <a href="{{ route('instructions.download_aggregates', ['tbs_buy', date('Y-m-d')]) }}" class="btn btn-sm btn-warning {{ (count_tbs(1) == 0)? 'disabled' : '' }}">TB Purchase </a>
                                        <a href="{{ route('instructions.download_aggregates', ['tbs_sell', date('Y-m-d')]) }}" class="btn btn-sm btn-warning {{ (count_tbs(2) == 0)? 'disabled' : '' }}">TB Sale </a>
                                        <a href="{{ route('instructions.download_aggregates', ['bonds_buy', date('Y-m-d')]) }}" class="btn btn-sm btn-warning {{ (count_bonds(1) == 0)? 'disabled' : '' }}">FGN Bonds Purchase </a>
                                        <a href="{{ route('instructions.download_aggregates', ['bonds_sell', date('Y-m-d')]) }}" class="btn btn-sm btn-warning {{ (count_bonds(2) == 0)? 'disabled' : '' }}">FGN Bonds Sale </a>
                                        <a href="{{ route('instructions.download_aggregates', ['fop', date('Y-m-d')]) }}" class="btn btn-sm btn-warning {{ (count_trades() == 0)? 'disabled' : '' }}">FOP Instruction </a>
                                    </div>

                                </div>
                                <hr>
                                <h4>Download Instruction Letters</h4>

                                <table class="table datatable">
                                    <thead>
                                        <th>Report</th>
                                        <th>Action</th>
                                    </thead>

                                    <tbody>
                                        @foreach( $trade_dates as $td)
                                        <tr>
                                            <td>Download Instruction For {{ $td->TradeDate }}</td>
                                            <td>
                                              <a href="{{ route('instructions.download_aggregates', ['tbs_buy', $td->TradeDate]) }}" class="btn btn-xs btn-warning p-xxs {{ (count_tbs(1, $td->TradeDate) == 0)? 'disabled' : '' }}"><i class="pe-7s-cloud-download c-accent"></i> TB Purchase</a>
                                              <a href="{{ route('instructions.download_aggregates', ['tbs_sell', $td->TradeDate]) }}" class="btn btn-xs btn-warning p-xxs {{ (count_tbs(2, $td->TradeDate) == 0)? 'disabled' : '' }}"><i class="pe-7s-cloud-download c-accent"></i> TB Sale</a>
                                              <a href="{{ route('instructions.download_aggregates', ['bonds_buy', $td->TradeDate]) }}" class="btn btn-xs btn-warning p-xxs {{ (count_bonds(1, $td->TradeDate) == 0)? 'disabled' : '' }}"><i class="pe-7s-cloud-download c-accent"></i> FGN Bonds Purchase</a>
                                              <a href="{{ route('instructions.download_aggregates', ['bonds_sell', $td->TradeDate]) }}" class="btn btn-xs btn-warning p-xxs {{ (count_bonds(2, $td->TradeDate) == 0)? 'disabled' : '' }}"><i class="pe-7s-cloud-download c-accent"></i> FGN Bonds Sale</a>
                                              <a href="{{ route('instructions.download_aggregates', ['fop', $td->TradeDate]) }}" class="btn btn-xs btn-warning p-xxs {{ (count_trades($td->TradeDate) == 0)? 'disabled' : '' }}"><i class="pe-7s-cloud-download c-accent"></i> FOP Instruction</a>
                                              <a href="{{ route('instructions.download_aggregates', ['fop_excel', $td->TradeDate]) }}" class="btn btn-xs btn-warning p-xxs {{ (count_trades($td->TradeDate) == 0)? 'disabled' : '' }}"><i class="pe-7s-cloud-download c-accent"></i> FOP (Excel)</a>
                                            </td>
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