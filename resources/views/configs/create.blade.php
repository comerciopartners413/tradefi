@extends('layouts.app')

@section('content')
<div class="panel panel-transparent">
	<div class="panel-heading">
		<div class="panel-title">
			Setup/Edit Trade Configuration 
		</div>
	</div>
</div> 
	<!-- START PANEL -->
	<div class="panel panel-filled">
		<div class="panel-heading">
			<div class="panel-title">
			Trade/System Table
			</div>
		
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<table class="table">
				<thead>
					<th>Trade Date</th>
					<th></th>
				</thead>
				<tbody>
					@foreach ($configs as $config)
						<tr>
						<td>{{ $config->TradeDate }}</td>
						<td class="actions">
							<a href="{{ route('config.edit',[$config->ConfigRef]) }}" class="btn btn-warning">EDIT</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<!-- END PANEL -->
@endsection
