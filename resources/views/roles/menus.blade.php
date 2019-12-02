@extends('layouts.app')


@section('content')
<section class="bg-white container-fluid container-fixed">
	<div class="panel panel-transparent">
		<div class="panel-heading">
			<div class="panel-title">Menus for  <b>{{ $role->name }}</b> </div>
			<div class="btn-group pull-right m-b-10">
				<button type="button" class="btn btn-default">Bulk Actions</button>
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" menu="menu">
					<li><a href="#">Edit</a></li>
					<li><a href="#">Send to trash</a></li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table dataTable tableWithSearch">
					<thead>
						<tr>
							<th style="width:5%">
								<div class="checkbox ">
									<input type="checkbox" value="3" id="checkbox-all">
									<label for="checkbox-all"></label>
								</div>
							</th>
							<th style="width:10%">Name</th>
							<th style="width:10%">Description</th>
							<th style="width:20%">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach( $role_menus as $menu)
						<tr>
							<td class="v-align-middle">
								<div class="checkbox ">
									<input type="checkbox" value="3" id="checkbox-{{$menu->id}}">
									<label for="checkbox-{{$menu->id}}"></label>
								</div>
							</td>
							<td class="v-align-middle"> {{ $menu->name}} </td>
							<td class="v-align-middle">{{ $menu->description}}</td>
							<td class="v-align-middle"> &nbsp;
								{{ Form::open(['action' => ['RoleController@remove_menu', $menu->id, $role->id], 'method' => 'delete', 'class' => 'inline-block']) }}
								<button class="btn btn-danger" type="submit">
									&times; Delete
								</button>
								{{ Form::close() }}
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

@push('scripts')
<script>

</script>
@endpush
