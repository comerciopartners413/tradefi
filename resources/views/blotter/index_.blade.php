@extends('layouts.app')
@section('content')
<div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">
                            <div class="pull-right text-right" style="line-height: 14px">

                                <form action="/blotter" method="post">
                                        {{ csrf_field() }}
                                      <div class="col-md-5">
                                        <label>From</label>
                                        <input type="date" name="fromDate" value="{{ isset($from) ? $from : null }}" class="form-control" id="fromDate" placeholder="From">
                                    </div>
                                    <div class="col-md-5">
                                        <label>To</label>
                                        <input type="date" name="toDate" value="{{ isset($to) ? $to : null }}" class="form-control" id="toDate" placeholder="To">
                                    </div>
                                    <div class="col-md-2">
                                      <button type="submit" style="margin-top: 20px" id="process" class="btn btn-warning">Search</button>
                                    </div>
                                    </form>

                            </div>
                            <!-- pull right -->
                            <div class="header-icon">
                                <i class="pe page-header-icon pe-7s-display2"></i>
                            </div>
                            <div class="header-title">
                                <h3>My  Blotter</h3>
                                <small>
                               Daily Blotter, full details of all your transactions, search by date range
                            </small>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4">
                    </div>

                    <div class="col-md-4">
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
                            </div>
                            <div class="panel-body">
                                <!-- <p>
                            </p>-->
                            <div class="tabs-container">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="false">Treasury Bills <span style="margin-left: 5px" class="badge">{{ count($user_blotter->where('ProductID1', 2)) }}</span></a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">FGN Bonds<span style="margin-left: 5px" class="badge">{{ count($user_blotter->where('ProductID1', 1)) }}</span></a></li>
                                    <!--   <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="true">Estimated Income</a></li>
                                   <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">Gains and Losses</a></li> -->
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-1" class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="table-responsive">

                                                <table style="color: #fff" class="table datatable table-striped table-hover">
                                                    <thead>
                                                        <tr class="ibuy">
                                                            <th>Transaction Type</th>
                                                            <th>Transaction Date</th>
                                                            <th>Value Date</th>
                                                            <th>Maturity</th>
                                                            <th>Nominal Value</th>
                                                            <th>Price</th>
                                                            <th>Discount Rate</th>
                                                             <th>Consideration</th>
                                                            <th>Yield</th>
                                                            <th>Interest Accrued</th>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($user_blotter as $usb)
                                                            @if(TradefiUBA\Security::find($usb->SecurityID)->ProductID == 2)
                                                            <tr class="{{ $usb->TransactionTypeID == 1 ? 'ibuy' : 'isell' }}">
                                                                <td class="{{ $usb->TransactionTypeID == 1 ? 'buy' : 'sale' }}"><b>{{ $usb->transaction_type->TransactionType }}</b></td>
                                                                <td>{{ Carbon\Carbon::parse($usb->TradeDate)->toFormattedDateString() }}</td>
                                                                <td>{{ Carbon\Carbon::parse($usb->SettlementDate)->toFormattedDateString() }}</td>
                                                                <td>{{ TradefiUBA\Security::find($usb->SecurityID)->Description }}</td>
                                                                <td>
                                                                    {{ number_format($usb->Quantity, 2) }}
                                                                </td>

                                                                <td>
                                                                    {{ number_format($usb->DirtyPrice, 2) }}
                                                                 </td>

                                                                 <td>
                                                                    {{ number_format($usb->DiscountRate, 2) }}%
                                                                 </td>
                                                                 <td> ₦{{ number_format($usb->SettlementAmount, 2) }} </td>
                                                                <td>{{ number_format($usb->Yield * 100, 2) }}%</td>
                                                               
                                                                <td>
                                                                    <span class="gr"> 
                                                                    {{-- <i class="fa fa-level-up"></i> --}}
                                                                     ₦{{ number_format($usb->InterestAccrued * $usb->Quantity/100 , 2) }}  </span>
                                                                    </td>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                        
                                                    </tbody>
                                                </table>                                                                   
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tab-2" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="table-responsive">

                                                <table style="color: #fff" class="table datatable table-striped table-hover">
                                                    <thead>
                                                        <tr class="ibuy">
                                                            <th>Transaction Type</th>
                                                            <th>Transaction Date</th>
                                                            <th>Value Date</th>
                                                            <th>Maturity</th>
                                                            <th>Nominal Value</th>
                                                            <th>Clean Price</th>
                                                            <th>Dirty Price</th>
                                                             <th>Consideration</th>
                                                            <th>Yield</th>
                                                            <th>Interest Accrued</th>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($user_blotter as $usb)
                                                            @if(TradefiUBA\Security::find($usb->SecurityID)->ProductID == 1)
                                                            <tr class="{{ $usb->TransactionTypeID == 1 ? 'ibuy' : 'isell' }}">
                                                                <td class="{{ $usb->TransactionTypeID == 1 ? 'buy' : 'sale' }}"><b>{{ $usb->transaction_type->TransactionType }}</b></td>
                                                                <td>{{ Carbon\Carbon::parse($usb->TradeDate)->toFormattedDateString() }}</td>
                                                                <td>{{ Carbon\Carbon::parse($usb->SettlementDate)->toFormattedDateString() }}</td>
                                                                <td>{{ TradefiUBA\Security::find($usb->SecurityID)->Description }}</td>
                                                                <td>
                                                                    {{ number_format($usb->Quantity, 2) }}
                                                                </td>
                                                                <td>
                                                                    {{ number_format($usb->CleanPrice, 2) }}
                                                                 </td>

                                                                 <td>
                                                                    {{ number_format($usb->DirtyPrice, 2) }}
                                                                 </td>
                                                                 <td> ₦{{ number_format($usb->SettlementAmount, 2) }} </td>

                                                                <td>{{ number_format($usb->Yield, 2) }}%</td>
                                                               
                                                                <td>
                                                                    <span class="gr"> 
                                                                    {{-- <i class="fa fa-level-up"></i> --}}
                                                                     ₦{{ number_format($usb->InterestAccrued * $usb->Quantity/100 , 2) }}  </span>
                                                                    </td>
                                                                
                                                            </tr>
                                                            @endif
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

            </div>
@endsection

@push('scripts')
<script>
	$(function(){
	   
	})
</script>
@endpush