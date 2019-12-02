@extends('layouts.app')

@section('content')
<div class="panel panel-filled">
	<div class="panel-heading">
		<div class="panel-title">
			Edit Securities 
		</div>
	</div>
	<div class="panel-body">
		{{ Form::model($security, ['action' => ['SecurityController@update', $security->SecurityRef ], 'autocomplete' => 'off', 'novalidate' => 'novalidate', 'role' => 'form']) }}
		{{ method_field('PATCH') }}
		@include('securities.form', ['buttonText' => 'Update security'])
		{{ Form::close() }}
	</div>
</div>
@endsection

