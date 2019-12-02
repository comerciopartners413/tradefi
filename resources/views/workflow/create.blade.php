@extends('layouts.app')

@section('content')
<div class="panel panel-filled">
	<div class="panel-heading">
		<div class="panel-title">
			Set Approval Levels (Role-Based)
		</div>
	</div>
	<div class="panel-body">
		{{ Form::open(['action' => 'WorkflowController@store', 'autocomplete' => 'off', 'novalidate' => 'novalidate', 'role' => 'form']) }}
		@include('workflow.form', ['buttonText' => 'Set Workflow'])
		{{ Form::close() }}
	</div>
</div>
{{-- @endsection --}}

{{-- @section('bottom-content') --}}


<div class="panel panel-filled">
	<div class="panel-body">
		<table class="table datatable">
	<thead>
		<th>Module </th>
		<th>Initiator</th>
		<th>Approver 1</th>
		<th>Approver 2</th>
		<th>Approver 3</th>
		<th>Approver 4</th>
		<th></th>
	</thead>

	<tbody>
		@foreach($workflowdata as $workflow)
		<tr>
			<td>
				@if($workflow->ModuleID == 36)
				Deposits
				@elseif($workflow->ModuleID == 37)
				Withdrawals
				@elseif($workflow->ModuleID == 2)
				Securities
				@elseif($workflow->ModuleID == 3)
				Role Management
				@elseif($workflow->ModuleID == 4)
				Inventory Management
				@elseif($workflow->ModuleID == 5)
				Direct Deposit
				@elseif($workflow->ModuleID == 38)
				Bond Custody Fees
				@endif
			</td>
			{{-- <td>{{ TradefiUBA\Profile::find($workflow->RequesterID)->firstname }}</td> --}}
			<td class="c-accent">{{ $workflow->initiator->display_name ?? 'N/A' }}</td>
			<td>{{ $workflow->role_1->display_name ?? 'N/A' }}</td>
			<td>{{ $workflow->role_2->display_name ?? 'N/A' }}</td>
			<td>{{ $workflow->role_3->display_name ?? 'N/A' }}</td>
			<td>{{ $workflow->role_4->display_name ?? 'N/A' }}</td>

			<td>
				<a href="{{ route('workflow.edit', [$workflow->WorkflowRef]) }}" class="btn btn-sm btn-warning">Edit</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
	</div>
</div>

@endsection

@push('scripts')
<script>
	$('#tableExample3').DataTable({});
</script>
@endpush
