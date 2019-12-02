@extends('layouts.app')
@section('content')
<div class="panel panel-transparent">
	<div class="panel-heading">
		<div class="panel-title">
			Update Permission 
		</div>
	</div>
	<div class="panel-body">
		{{ Form::model($permission,['action' => ['PermissionController@update', $permission->id ], 'autocomplete' => 'off', 'novalidate' => 'novalidate', 'permission' => 'form', 'method' => 'patch']) }}
		@include('permissions.form', ['buttonText' => 'Update Permission'])
		{{ Form::close() }}
	</div>
</div>
@endsection


