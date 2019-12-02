@extends('layouts.app')
@section('content')
{{-- @section('bottom-content') --}}
<div class="container-fluid">
	<h3 class="heading" style="    margin-bottom: 30px;
    border-bottom: 1px solid #494b54;
    padding-bottom: 20px;">
		Account Statement <br>
	</h3> 
	<div class="">
				<div class="pull-left" style="color: #fff; width: 50%; margin-bottom: 30px">
				@if(isset($statements))
					@foreach($trans as $tran)
					<div class="row">
						<div class="col-md-4"><p style ="font-size :14px">Name :</p></div>
					<div class="col-md-8"><p style ="font-size :14px;" class="c-accent">{{ $tran->firstname}}</p></div>
					</div>
					@if($tran->address)
					<div class="row">
						<div class="col-md-4"><p style ="font-size :14px">Address :</p></div>
					<div class="col-md-8">
					</div>
					<p style ="font-size :14px;" class="c-accent">{{$tran->address}}</p>
					</div>
					@endif
					@if($tran->phone)
					<div class="row">
						<div class="col-md-4"><p style ="font-size :14px">Phone Number :</p></div>
					<div class="col-md-8"><p style ="font-size :14px;" class="c-accent">{{$tran->phone}}</p></div><br>
					</div>
					@endif
					@if($tran->BVN)
					<div class="row">
						<div class="col-md-4"><p style ="font-size :14px">BVN Number :</p></div>
					<div class="col-md-8"><p style ="font-size :14px;" class="c-accent">{{$tran->BVN}}</p></div>
					</div>
					@endif
				</div>

				<div class="pull-right" style="color: #fff; width: 30%; margin-bottom: 30px">
					<div class="row">
						<div class="col-md-5"><p style ="font-size :14px">Account No :</p></div>
					<div class="col-md-7"><p style ="font-size :14px;" class="c-accent">{{$tran->AccountNumber}}</p></div>
					<div class="col-md-5"><p style ="font-size :14px">Account Type :</p></div>
					<div class="col-md-7"><p style ="font-size :14px;" class="c-accent">{{$tran->AccountType}}</p></div>
					<div class="col-md-5"><p style ="font-size :14px">Currency :</p></div>
					<div class="col-md-7"><p style ="font-size :14px;" class="c-accent">{{$tran->Currency}}</p></div><br>
					<div class="col-md-5"><p style ="font-size :14px">Book Balance :</p></div>
					<div class="col-md-7"><p style ="font-size :14px;" class="c-accent">{{ number_format( $tran->BookBalance,2)}}</p></div><br>
					<div class="col-md-5"><p style ="font-size :14px">Cleared Balance :</p></div>
					<div class="col-md-7"><p style ="font-size :14px;" class="c-accent">{{ number_format( $tran->ClearedBalance,2)}}</p></div>
					</div>
					@endforeach
					@endif
				</div> <div class="clearfix"></div>
			</div>
	<table class="table datatable">
				<thead>
					<th>Transaction Date</th>
					<th>Value Date</th>
					<th>Naration</th>
					<th>Debits</th>
					<th>Credits</th>
					<th>Balance</th>
					
				</thead>
				<tbody>
				@if(isset($statements))
					@foreach($statements as $statement)
					<tr>
						<td>{{\Carbon\Carbon::parse($statement->PostDate)->toFormattedDateString()}}</td>
						<td>{{\Carbon\Carbon::parse($statement->ValueDate)->toFormattedDateString()}}</td>
						<td>{{$statement->Narration}}</td>
						<td>{{number_format($statement->Debit,2) }}</td>
						<td>{{number_format($statement->Credit,2) }}</td>
						<td>{{number_format($statement->Balance,2) }}</td>
						
					</tr>
					@endforeach
				@endif
				</tbody>
			</table>
</div>

	@endsection


@push('scripts')
{{-- <script src="{{ asset('js/jquery.tabledit.js') }}"></script> --}}
<script>
	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  
</script>
@endpush

{{-- <hr> --}}