@extends('layouts.app')

@section('content')
<div class="panel panel-transparent">
	<div class="panel-heading">
		<div class="panel-title">
			Create Securities 
		</div>
	</div>
	<div class="panel-body">
		{{ Form::open(['action' => 'SecurityController@store', 'autocomplete' => 'off', 'novalidate' => 'novalidate', 'role' => 'form']) }}
		@include('securities.form', ['buttonText' => 'Add Instrument'])
		{{ Form::close() }}
	</div>
</div>
<hr>
<section class="bg-white container-fluid container-fixed">
	<div class="panel panel-filled">
		<div class="panel-heading">
			<div class="panel-title">Available Securities.</div>
		
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table datatable">
					<thead>
						<tr>
							<th>Product</th>
							<th>Security</th>
							{{-- <th>Benchmark</th> --}}
							<th>Closing Market Price</th>
							<th>Last Modified Date</th>
							<th>CouponRate (%)</th>
							<th>MaturityDate</th>
							<th>Created At</th>
							<th>Modified By</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($securities as $security)
						<tr>
							{{-- <td class="v-align-middle">
								<div class="checkbox ">
									<input type="checkbox" value="3" id="checkbox-{{$security->id}}">
									<label for="checkbox-{{$security->id}}"></label>
								</div>
							</td> --}}
							
							<td class="v-align-middle"> {{ $security->Product}} </td>
							<td>{{ $security->Security }}</td>
							
							<td class="v-align-middle">{{ $security->ClosingMktPrice }}</td>
							<td class="v-align-middle">{{ \Carbon\Carbon::parse($security->ModifiedDatetime)->toDayDateTimeString() }}</td>
							<td class="v-align-middle">{{ number_format(($security->CouponRate * 100), 2) }}%</td>
							<td class="v-align-middle">{{ \Carbon\Carbon::parse($security->MaturityDate)->toFormattedDateString()}}</td>
							
							<td>{{ $security->InputDatetime }}</td>
							<td>
								@if($security->ModifierID != '')
								{{ TradefiUBA\User::find($security->ModifierID)->name }}
								@else
								N/A
								@endif
							</td>
							
							<td class="v-align-middle">
								<a style="float: left;" href="{{ action('SecurityController@edit', $security->SecurityRef) }}" class="btn btn-sm btn-default ">Edit</a> 

								 <form method="POST" action="/securities/send/{{ $security->SecurityRef }}">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <button class="btn btn-sm btn-warning">Send</button>
                                        </form>
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
@push('styles')
<style>
	.btn-toolbar {
		margin-left: 0;
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
	$('#securities-table').Tabledit({
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
    class: 'btn btn-sm btn-warning',
    html: '<span class="">Edit Price</span>',
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
	var mod = {{ auth()->user()->id }};
	console.log(mod);
        console.log(serialize.concat("&ModifierID="+mod));
        var id = (serialize.concat("&ModifierID="+mod)).split('&')[0].split('=')[1];
        
        console.log(id);
        $.ajax({
        	url: '/securities/'+id,
        	type: 'PATCH',
        	data: serialize.concat("&ModifierID="+mod)
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
  editable: [[3, 'ClosingMktPrice']]
}

});
	// $('#securities-table').editableTableWidget();
  // $(document).ready(function(){
  	 var settings = {
    "sDom": "<'exportOptions'T><'table-responsive't><'row'<p i>>",
    "sPaginationType": "bootstrap",
    "destroy": true,
    "scrollCollapse": true,
    "oLanguage": {
        "sLengthMenu": "_MENU_ ",
        "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
    },
     // "columnDefs": [
     //        {
     //            "targets": [ 3 ],
     //            "visible": false
     //        }
     //    ],
    "iDisplayLength": 10,
    "oTableTools": {
        "sSwfPath": "../assets/plugins/jquery-datatable/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
        "aButtons": [{
            "sExtends": "csv",
            "sButtonText": "<i class='pg-grid'></i>",
        }, {
            "sExtends": "xls",
            "sButtonText": "<i class='fa fa-file-excel-o'></i>",
        }, {
            "sExtends": "pdf",
            "sButtonText": "<i class='fa fa-file-pdf-o'></i>",
        }, {
            "sExtends": "copy",
            "sButtonText": "<i class='fa fa-copy'></i>",
        }]
    },
    fnDrawCallback: function(oSettings) {
        $('.export-options-container').append($('.exportOptions'));
    }
};
      

var table = $('#securities-table').DataTable(settings);
 $('#securities-table tfoot th').each(function(key, val) {
            var title = $(this).text();
            // console.log($('#securities-table tfoot th').length);
             if (key === $('#securities-table tfoot th').length - 2) {
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" /><button class="toggleMaturity">Matured</button>');
            }
            if (key === $('#securities-table tfoot th').length - 1) {
                return false;
            } else {
            	$(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
            }

           

        });   
 table.columns().every(function() {
            var that = this;
            $('input', this.footer()).on('keyup change', function() {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });

 $('.toggleMaturity').toggle(function() {
 	$(this).parent().find('input').text('Matured');
 }, function() {
 	$(this).parent().find('input').text('Available');
 });
 
  // });
</script>
@endpush