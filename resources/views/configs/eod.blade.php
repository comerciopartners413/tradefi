@extends('layouts.master')
@section('content')

<div class="heading">
	End of Day Report
</div>
<div class="panel">
	{{-- <div class="panel-heading">
		<div class="panel-title">
			End of Period Report
		</div>
	</div> --}}

	<div class="panel-body">
		<table class="table tableWithExportOptions">
			<thead>
			<th>TradeDate</th>
				<th>EOD Gain Loss</th>
				<th>Interest Income</th>
				<th>Income Expense</th>
				<th>PL</th>
			</thead>

			<tbody>
			@foreach($eod as $eod)
				 <tr>
				 <td>{{ \Carbon\Carbon::parse($eod->TradeDate)->toFormattedDateString() }}</td>
                    
                    <td>
                        {{ number_format($eod->EODGainLoss,2) }}
                    </td>
                    <td>
                        {{ number_format($eod->InterestIncome,2) }}
                    </td>
                    <td>
                        {{ number_format($eod->InterestExpense,2) }}
                    </td>
                    <td>
                        {{ number_format($eod->PL,2) }}
                    </td>
                </tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>



@endsection