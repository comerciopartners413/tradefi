@extends('layouts.app')

@section('content')
<div class="panel panel-filled">
	<div class="panel-heading">
		<div class="panel-title">
			Change Trade Date
		</div>
	</div>
	<div class="panel-body">
		{{ Form::model($config, ['action' => ['ConfigController@update', $config->ConfigRef ], 'autocomplete' => 'off', 'novalidate' => 'novalidate', 'role' => 'form']) }}
		{{ method_field('PATCH') }}
		@include('configs.form', ['buttonText' => 'Update Configuration'])
		{{ Form::close() }}
	</div>
</div>
@endsection

