@extends('layouts.app')


@section('content')
<section class="bg-white container-fluid container-fixed">
	<div class="panel panel-filled">
		<div class="panel-heading">
			<div class="pull-left">
				<div class="panel-title">Securities</div>
			</div>
		<div class="pull-right">
			<a href="{{ route('securities.create') }}" class="btn btn-sm btn-warning">New Security</a>
		</div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			
			<div class="table-responsive">
				<table id="securities-table" class="table ">
					<thead>
						<tr>
							<th></th>
							<th>Product</th>
							<th>Security</th>
							<th>Benchmark</th>
							<th>Closing Market Price</th>
							<th>Last Modified Date</th>
							<th>CouponRate (%)</th>
							<th>MaturityDate</th>
							<th>TTM</th>
							<th>Frequency</th>
							<th>Basis</th>
							<th>Maturity Status</th>
							<th>Created By</th>
							<th>Created At</th>
							<th>Modified By</th>
							<th></th>
						</tr>
					</thead>

					<tfoot class="thead">
						<th></th>
						<th>Product</th>
							<th>Security</th>
							<th>Benchmark</th>
							<th>Closing Market Price</th>
							<th>Last Modified Date</th>
							<th>CouponRate</th>
							<th>MaturityDate</th>
							<th>TTM</th>
							<th>Frequency</th>
							<th>Basis</th>
							<th>Maturity Status</th>
							<th>Created By</th>
							<th>Created At</th>
							<th>Modified By</th>
							<th></th>
					</tfoot>
					<tbody>
						@foreach($securities as $security)
						<tr>
							{{-- <td class="v-align-middle">
								<div class="checkbox ">
									<input type="checkbox" value="3" id="checkbox-{{$security->id}}">
									<label for="checkbox-{{$security->id}}"></label>
								</div>
							</td> --}}
							<td>{{ $security->SecurityRef}}</td>
							<td class="v-align-middle"> {{ $security->Product}} </td>
							<td>{{ $security->Security }}</td>
							<td style="text-align: center"><input type="checkbox" name="sec-{{ $security->SecurityRef }}" id="sec-{{ $security->SecurityRef }}" class="benchmark-flag-toggler" value="{{ $security->SecurityRef }}" {{ $security->BenchmarkFlag ? 'checked' : null}}>	</td>
							<td class="v-align-middle">{{ $security->ClosingMktPrice }}</td>
							<td class="v-align-middle">{{ \Carbon\Carbon::parse($security->ModifiedDatetime)->toDayDateTimeString() }}</td>
							<td class="v-align-middle">{{ number_format(($security->CouponRate * 100), 2) }}%</td>
							<td class="v-align-middle">{{ \Carbon\Carbon::parse($security->MaturityDate)->toFormattedDateString()}}</td>
							<td class="v-align-middle">{{ $security->TTM}}</td>
							<td class="v-align-middle">{{ $security->Frequency }}</td>
							<td class="v-align-middle">{{ $security->Basis }}</td>
							<td class="v-align-middle">
								@if($security->MaturityFlag == 0)
								<span>Available</span>
								@endif

								@if($security->MaturityFlag == 1)
								<span>Matured</span>
								@endif
							</td>
							<td>
								@if($security->InputterID != '')
								{{ TradefiUBA\User::find($security->InputterID)->name }}
								@else
								N/A
								@endif
							</td>
							<td>{{ $security->InputDatetime }}</td>
							<td>
								@if($security->ModifierID != '')
								{{ TradefiUBA\User::find($security->ModifierID)->name }}
								@else
								N/A
								@endif
							</td>
							
							<td class="v-align-middle">
								<a href="{{ action('SecurityController@edit', $security->SecurityRef) }}" class="btn btn-info">Edit</a> 
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
  editable: [[4, 'ClosingMktPrice']]
}

});
	// $('#securities-table').editableTableWidget();
  // $(document).ready(function(){
  	 var settings = {
            // "sDom": "<'exportOptions'>l f<'table-responsive 't> B <''<p i >>",
             dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>> <'table-responsive 't> p",
            // "dom": 'Bfrtip',
            "destroy": true,
            "scrollCollapse": true,
            "oLanguage": {
                "sSearch": "",
                "sSearchPlaceholder": "Search",
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 10,
             buttons: [
                'print', 'excel', 'pdf'
            ],
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

 $('.benchmark-flag-toggler').click(function(e) {
 	e.preventDefault();
 	var that = $(this);
 	if(that.prop('checked')) {
 	$.ajax({
 		url: '/securities/benchmark',
 		type: 'POST',
 		data: {SecurityRef: that.prop('value')},
 	})
 	.done(function() {
 		console.log("success");
 		that.prop('checked', 'checked');

 	})
 	.fail(function() {
 		console.log("error");
 		alert('The security was not benchmarked');
 		return false
 	})
 	.always(function() {
 		console.log("complete");
 	});
 	} else {
 		 	$.ajax({
 		url: '/securities/remove-benchmark',
 		type: 'POST',
 		data: {SecurityRef: that.prop('value')},
 	})
 	.done(function() {
 		// console.log(that.attr('checked'));
 		that.removeProp('checked');

 	})
 	.fail(function() {
 		console.log("error");
 		alert('The security was benchmarked');
 		return false
 	})
 	.always(function() {
 		console.log("complete");
 	});
 	}
 	

 	
 });
 
  // });
</script>
@endpush