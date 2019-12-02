@extends('layouts.app')
@section('content')

<h2 class="heading">
	Execute EOD
</h2>
<div class="panel panel-filled">
	

	<div class="panel-body">
		{{ Form::open(['action' => 'ConfigController@execeodpost']) }}
		<p class="text-white">Are You sure you want to Execute End of Day?</p>
		{{ Form::submit('Yes, Execute EOD',['class' => 'btn btn-warning', 'id' => 'eodconfirm']) }}
		{{ Form::close() }}
	</div>
</div>
@endsection

@push('scripts')
<script>
	$(function(){
		$("#eodconfirm").click(function(e){
			e.preventDefault();
			var confirmer = confirm("Proceed to run End of Day?");
			if(confirmer){
				$(".panel-body form").submit();
			}
			return false;
		})
	});
</script>
@endpush