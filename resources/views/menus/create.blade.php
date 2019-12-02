@extends('layouts.app')
@section('content')
		<!-- START PANEL -->
		<div class="panel panel-transparent">
		<div class="panel-heading">
		<div class="panel-title">
			Create Menus 
		</div>
	</div>
			<div class="panel-body">
				{{ Form::open(['action' => 'MenuController@store', 'autocomplete' => 'off', 'novalidate' => 'novalidate', 'role' => 'form']) }}
					@include('menus.form', ['buttonText' => 'Create Menu' ])
				{{ Form::close() }}
				<br><br>
				
			</div>
		</div>

<div class="container-fluid container-fixed-lg bg-white">
	<!-- START PANEL -->
	<div class="panel panel-filled">
		<div class="panel-heading">
			<div class="panel-title">
			Menus Listing
			</div>
			<div class="pull-right">
				<div class="col-xs-12">
					{{-- <input type="text" class="form-control pull-right search-table" placeholder="Search"> --}}
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table id="menu-table" class="table">
				<thead>
					<th></th>
						<th>Menu Name</th>
						<th>Route</th>
						<th>Description</th>
				</thead>

				<tfoot>
					<th></th>
						<th>Menu Name</th>
						<th>Route</th>
						<th>Description</th>
				</tfoot>
				<tbody>
					@foreach( $menus as $menu )
					<tr>
						<td>{{ $menu->id}}</td>
						<td>{{$menu->name}}</td>
						<td>{{$menu->route}}</td>
						<td>{{ $menu->description }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			</div>
		</div>
	</div>
	<!-- END PANEL -->
</div>
@endsection


@push('styles')
<style>
	tfoot {
    display: table-header-group;
}

tfoot th:first-child {
	padding-left:  0 !important;
}

tfoot th input {
	height: 25px !important;
    min-height: 25px !important;
}
.btn-g {
	    display: inline-block;
}
.btn-g button {
	margin-right: 5px;
}
</style>
@endpush
@push('scripts')
<script src="{{ asset('js/jquery.tabledit.js') }}"></script>
<script>
	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
	// $('#menu-table').editableTableWidget();
  // $(document).ready(function(){
  	var settings = {
            "sDom": "<'table-responsive't><''<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 5
        };
      
$('#menu-table').Tabledit({
inputClass: 'form-control input-sm',

toolbarClass: 'btn-toolbar',
groupClass: 'btn-g',
dangerClass: '',
warningClass: 'warning',
mutedClass: 'text-muted',
eventType: 'click',
rowIdentifier: 'id',
autoFocus: true,
hideIdentifier: true,
editButton: true,
deleteButton: false,
saveButton: true,
restoreButton: false,
buttons: {
  edit: {
    class: 'btn btn-sm btn-default',
    html: '<span class="">Edit</span>',
    action: 'update'
  },
  delete: {
    class: 'btn btn-sm btn-danger',
    html: '<span class="glyphicon glyphicon-trash"></span>',
    action: 'delete'
  },
  save: {
    class: 'btn btn-sm btn-success',
    html: 'Save'
  },
  restore: {
    class: 'btn btn-sm btn-warning',
    html: 'Restore',
    action: 'restore'
  },
  confirm: {
    class: 'btn btn-sm btn-danger',
    html: 'Confirm'
  }
},

// executed before the ajax request
// onAjax(action, serialize)
onAjax: function(action, serialize) {
        console.log(serialize);
        var id = serialize.split('&')[0].split('=')[1];
        $.ajax({
        	url: '/menus/'+id,
        	type: 'PATCH',
        	data: serialize,
        })
        .done(function() {
        	console.log("success");
        })
        .fail(function() {
        	console.log("error");
        })
        .always(function() {
        	console.log("complete");
        });
        
    },
columns: {
  identifier: [0, 'id'],                    
  editable: [[1, 'name'], [2, 'route'], [3, 'description']]
}

});
var table = $('#menu-table').DataTable(settings);
 $('#menu-table tfoot th').each(function(key, val) {
            var title = $(this).text();
            if (key === $('#menu-table tfoot th')) {
                return false
            }
            $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
        });   
 table.columns().every(function() {
            var that = this;
            $('input', this.footer()).on('keyup change', function() {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });
  // });
</script>
@endpush
{{--  $('table td').on('change', function(evt, newValue) {
 	var row_id = $(this).parent('tr').data('id');
	$.ajax({
		url: '/menus/'+row_id,
		type: 'PUT',
		data: {name: newValue, },
	})
	.done(function() {
		console.log("success");
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
	
}); --}}

