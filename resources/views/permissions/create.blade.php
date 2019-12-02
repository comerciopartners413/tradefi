@extends('layouts.app')
@section('content')

<div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe page-header-icon pe-7s-lock"></i>
                            </div>
                            <div class="header-title">
                                <h3>Manage Permissions/Abilities</h3>
                                <small>
                               Create Permissions.
                            </small>
                            </div>
                        </div>
                    </div>
                </div>
<div class="panel panel-filled">
	<div class="panel-heading">
		<div class="panel-title">
			Create Permission 
		</div>
	</div>
	<div class="panel-body">
		{{ Form::open(['action' => 'PermissionController@store', 'autocomplete' => 'off', 'novalidate' => 'novalidate', 'role' => 'form']) }}
		@include('permissions.form', ['buttonText' => 'Create Permissions'])
		{{ Form::close() }}
	</div>
</div>

<section class="bg-white ">
	<div class="panel panel-filled">
		<div class="panel-heading">
			<div class="panel-title">Available permissions</div>
			<div class="btn-group pull-right m-b-10 hide">
				<button type="button" class="btn btn-default">Bulk Actions</button>
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#">Edit</a></li>
					<li><a href="#">Send to trash</a></li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-condensed datatable ">
					<thead>
						<tr>
							{{-- <th style="width:5%">
								<div class="checkbox ">
									<input type="checkbox" value="3" id="checkbox-all">
									<label for="checkbox-all"></label>
								</div>
							</th> --}}
							<th style="width:10%">Name</th>
							<th style="width:10%">Display Name</th>
							<th style="width:10%">Description</th>
							<th style="width:20%"></th>
						</tr>
					</thead>
					<tbody>
						@foreach( $permissions as $permission)
						<tr>
							{{-- <td class="v-align-middle">
								<div class="checkbox ">
									<input type="checkbox" value="3" id="checkbox-{{$permission->id}}">
									<label for="checkbox-{{$permission->id}}"></label>
								</div>
							</td> --}}
							<td class="v-align-middle"> {{ $permission->name}} </td>
							<td class="v-align-middle">{{ $permission->display_name}}</td>
							<td class="v-align-middle">{{ $permission->description}}</td>
							<td class="v-align-middle">
								<a href="{{ action('PermissionController@edit', $permission->id) }}" class="btn btn-sm btn-warning">Edit</a>
								 {{-- &nbsp;
								{{ Form::open(['action' => ['PermissionController@destroy', $permission->id], 'method' => 'delete', 'class' => 'inline-block']) }}
								{{ Form::submit('Delete',['class' => 'btn btn-danger ']) }}
								{{ Form::close() }} --}}
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
@endsection
