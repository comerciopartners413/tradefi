@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" media="screen" rel="stylesheet" type="text/css">
    <style>
        textarea {
        max-height: 50px;
        resize: none;
    }
    body {
    zoom: 100%;
}

    </style>
    @endpush
@extends('layouts.master')

@section('content')
<div class="panel panel-transparent">
	<div class="panel-heading">
		<div class="panel-title">
			Search Using Date Range
		</div>
	</div>
	<div class="panel-body">
		{{ Form::open(['action' => 'TransactionController@TransactionListRange', 'autocomplete' => 'off', 'novalidate' => 'novalidate', 'role' => 'form']) }}
		<div class="row">
        <div class="col-sm-6">
                <div class="form-group">
                    <div class="controls">
                    {{ Form::label('StartDate', 'Start Date') }}
                    <div class="input-group date dp">
                     {{ Form::text('StartDate', null, ['class' => 'form-control', 'placeholder' => 'Start Date']) }}
                        <span class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </span>

                </div>
            </div>
                </div>
        </div>
        <div class="col-sm-6">
                <div class="form-group">
                    <div class="controls">
                    {{ Form::label('EndDate', 'End Date') }}
                    <div class="input-group date dp">
                     {{ Form::text('EndDate', null, ['class' => 'form-control', 'placeholder' => 'End Date']) }}
                        <span class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                        </span>

                </div>
            </div>
                </div>
        </div>
    </div>
    <div class="row">
            <div class="pull-right">
                
            {{ Form::submit( 'Search', [ 'class' => 'btn btn-complete ' ]) }}
                {{-- {{ Form::reset('reset fields',[ 'class' => 'btn btn-transparent ' ]) }} --}}
            </div>
        </div>
		{{ Form::close() }}
	</div>
</div>
@endsection

@section('bottom-content')
<div class="container-fluid container-fixed-lg bg-white">
	<!-- START PANEL -->
	<div class="panel panel-transparent">
		<div class="panel-heading">
				<div class="panel-title">
					Transaction List
				</div>
				<div class="pull-right">
					<div class="col-xs-12">
						{{-- <input type="text" class="search-table form-control pull-right" placeholder="Search"> --}}
					</div>
				</div>
				<div class="clearfix"></div>
			<div class="panel-body row">
				<table class="table tableWithSearch">
					<thead>
                        <th>Ref</th>
                        <th>Account Number</th>
                        <th>Customer Details</th>
                        <th>Post Date</th>
                        <th>Value Date</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                        <th>Naration</th>
                        <th>Input</th>
                        <th>Input Date</th>
                        <th>Transaction Code</th>
                    </thead>
                    <tbody>
                        @foreach($trans as $tran)
                        <tr>
                            <td>{{$tran->TransactionRef}}</td>
                            <th>{{$tran->AccountNumber}}</th>
                            <td>{{$tran->Details}}</td>
                            <td>{{$tran->PostDate}}</td>
                            <td>{{$tran->ValueDate}}</td>
                            <td>{{number_format($tran->Debit, 2)}}</td>
                            <td>{{number_format($tran->Credit, 2)}}</td>
                            <td>{{number_format($tran->Balance, 2)}}</td>
                            <td>{{$tran->Narration}}</td>
                            <td>{{$tran->InputterID}}</td>
                            <td>{{$tran->InputDatetime}}</td>
                            <td>{{$tran->TransactionCode}}</td>
                        </tr>
                        @endforeach
                    </tbody>
				</table>
			</div>
		</div>
		<!-- END PANEL -->
	</div>
</div>
	@endsection

	 @push('scripts')
        <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript">
        </script>
        <script>
        $(function(){
            var options = {
                todayHighlight: true,
                autoclose: true,
                format: 'yyyy-mm-dd'
            };
            $('.dp').datepicker(options);
        })
    </script>
        @endpush
