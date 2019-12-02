@extends('layouts.app')
@section('content')
<div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe page-header-icon pe-7s-users"></i>
                            </div>
                            <div class="header-title">
                                <h3>Manage roles for {{ ucfirst(auth()->user()->company->name) ?? 'admin' }}</h3>
                                <small>
                               create roles for {{ auth()->user()->company->name ?? 'admin' }}.
                            </small>
                            </div>
                        </div>
                    </div>
                </div>
<div class="panel panel-filled">
	
	<div class="panel-body">
		{{ Form::open(['action' => 'RoleController@store', 'autocomplete' => 'off', 'novalidate' => 'novalidate', 'role' => 'form']) }}
		@include('roles.form', ['buttonText' => 'Create Roles'])
		{{ Form::close() }}
	</div>
</div>

<section class="bg-white ">
	<div class="panel panel-filled">
		<div class="panel-heading">
			<div class="panel-title">Available roles</div>
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
				<table class="table table-condensed table-bordered datatable ">
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
							<th style="width:20%">Menus</th>
							<th style="width:5%"></th>
						</tr>
					</thead>
					<tbody>
						@foreach( $roles as $role)
						<tr>
							{{-- <td class="v-align-middle">
								<div class="checkbox ">
									<input type="checkbox" value="3" id="checkbox-{{$role->id}}">
									<label for="checkbox-{{$role->id}}"></label>
								</div>
							</td> --}}
							<td class="v-align-middle"> {{ $role->name}} </td>
							<td class="v-align-middle">{{ $role->display_name}}</td>
              <td class="v-align-middle">{{ $role->description}}</td>
              <td class="v-align-middle">
                 <small>{{ implode($role->menus->pluck('name')->toArray(), ', ') }}</small>
              </td>
							<td class="v-align-middle">
								<a href="{{ action('RoleController@edit', $role->id) }}" class="btn btn-sm btn-warning">Edit</a>
								{{-- <a href="{{ action('RoleController@list_menus', $role->id) }}" class="btn btn-sm btn-success">View Menus</a> --}}
								 {{-- &nbsp;
								{{ Form::open(['action' => ['RoleController@destroy', $role->id], 'method' => 'delete', 'class' => 'inline-block']) }}
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
