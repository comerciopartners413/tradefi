@extends('layouts.app')

@section('content')
<div class="panel panel-filled">
	<div class="panel-heading">
		<div class="panel-title">
			Bonds Custody Posting
		</div>
	</div>
	<div class="panel-body">
		{{ Form::open(['action' => 'DepositController@bonds_custody_transfer_store', 'autocomplete' => 'off', 'novalidate' => 'novalidate', 'role' => 'form']) }}
		@include('cash_entries.form_bonds_custody_transfer', ['buttonText' => 'Post Entry'])
		{{ Form::close() }}
	</div>
</div>
@endsection

@section('bottom-content')
<div class="container-fluid container-fixed-lg">
	<!-- START PANEL -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">
				Postings between Accounts
			</div>
			<div class="pull-right">
				<div class="col-xs-12">
					<input type="text" class="search-table form-control pull-right" placeholder="Search">
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<table class="table tableWithSearch">
				<thead>
					<th>Acount Name</th>
					<th>Post Date</th>
					<th>Value Date</th>
					<th>Amount</th>
					<th>From</th>
					<th>To</th>
					<th></th>
				</thead>
				<tbody>
					@foreach ($cashentries as $cashentry)
						<tr>
						<td>{{ $cashentry->username }}</td>
						<td>{{ $cashentry->PostDate }}</td>
						<td>{{ $cashentry->ValueDate }}</td>
						<td>{{ $cashentry->Amount }}</td>
						<td>{{ $cashentry->GLIDDebit}}</td>
						<td>{{ $cashentry->GLIDCredit}}</td>
						<td class="actions">
							{{-- <a href="{{ route('customer_transfer.edit',[$cashentry->CashEntryRef]) }}" class="btn btn-info">View / Post</a> --}}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<!-- END PANEL -->
</div>
@endsection
