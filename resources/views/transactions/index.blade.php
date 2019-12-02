@extends('layouts.app')
@section('content')

<div class="container-fluid" id="normalmodediv">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">
                            <div class="pull-right text-right" style="line-height: 14px">

                              {{ Form::open(['action' => 'TransactionController@index']) }}

								  <div class="row">
                                    <div class="col-md-4">
                                        <label>Period</label>
                                        <select class="select2_demo_1 form-control" style="width: 100%">
                                            <option value="1">Today</option>
                                            <option value="2">Yesterday</option>
                                            <option value="3">Last 7 days</option>
                                            <option value="4">Last Month</option>
                                            <option value="5">Month to Date</option>
                                            <option value="4">All</option>
                                            <option value="5">Custom</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>From</label>
                                        <input type="date" class="form-control" id="exampleInputName" name="From" placeholder="From">
                                    </div>
                                    <div class="col-md-4">
                                        <label>To</label>
                                        <input type="date" class="form-control" id="exampleInputName" name="To" placeholder="To">
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-sm btn-success" style="margin-top: 10px">Process</button>

                              {{ Form::close() }}

                            </div>
                            <!-- pull right -->
                            <div class="header-icon">
                                <i class="pe page-header-icon fa fa-calendar"></i>
                            </div>
                            <div class="header-title">
                                <h5>Transaction Listings</h5>

                            </div>
                        </div>

                        <small>
                               Spool buy or sell side transactions for your preferred date period
                            </small>

                        <hr>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4">
                        <!--       <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>

                        </div>
                        <div class="panel-body">
                            <div>
                                <canvas id="polarOptions" height="180"></canvas>
                            </div>
                        </div>
                    </div>
              --></div>

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
                                <!-- Securities, their yields, price and more details -->
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">

                                    <table style="color: #fff" class="table datatable table-striped table-hover">
                                        <thead>
                                            <tr class="ibuy">
                                                <th>Transaction Date</th>
                                                <th>Value Date</th>
                                                <th>Security</th>
                                                 <th>Nominal Value</th>
                                                <th>Price</th>
                                                <th>Yield</th>
                                               
                                                <th>Interest Accrued</th>
                                                <th>Consideration</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user_transactions as $ust)
                                            <tr class="{{ $ust->TransactionTypeID == 1 ? 'ibuy' : 'isell' }}">
                                                <td>{{ Carbon\Carbon::parse($ust->TradeDate)->toFormattedDateString() }}</td>
                                                <td>{{ Carbon\Carbon::parse($ust->SettlementDate)->toFormattedDateString() }}</td>
                                                <td>{{ TradefiUBA\Security::find($ust->SecurityID)->Description }}</td>
                                                <td>
                                                    {{ number_format($ust->Quantity, 2) }}
                                                </td>
                                                <td>{{ number_format($ust->CleanPrice, 2) }} </td>
                                                <td>{{ number_format($ust->Yield, 2) }}</td>
                                                
                                                <td><span class="gr"> 
                                                    {{-- <i class="fa fa-level-up"></i> --}}
                                                     {{ number_format($ust->InterestAccrued, 2) }}%  </span></td>

                                                <td> 
                                                    @if(TradefiUBA\Security::find($ust->SecurityID)->ProductID == 1)
                                                    {{ number_format((($ust->CleanPrice * $ust->Quantity)/100), 2) }}
                                                    @else
                                                    {{ number_format((($ust->DirtyPrice * $ust->Quantity)/100), 2) }}
                                                    @endif
                                                 </td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>                                                                   
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- end side bar -->

                </div>

            </div>

@endsection

@push('scripts')
<script>
	

    
</script>
@endpush