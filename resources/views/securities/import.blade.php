@extends('layouts.master')

@section('content')
<div class="panel panel-transparent">
	<div class="panel-heading">
		<div class="panel-title">
			Import Closing Market Prices for securities 
		</div>
	</div>
	<div class="panel-body">
		{{ Form::open(['action' => 'SecurityController@importExcel', 'autocomplete' => 'off','files' => true, 'novalidate' => 'novalidate', 'role' => 'form']) }}
		{{ Form::file('import_file') }} <br>
    <div class="row">
      <div class="form-group col-sm-6">
      <p>select product type</p>
    <select name="Product" id="Product" class="form-control">
      <option value="1">Bonds</option>
      <option value="2">TBills</option>
    </select>
    </div>
    </div>
		<div>
    <button type="submit" class="btn btn-complete">Import CSV or Excel File</button>  
    </div>
		{{ Form::close() }}
	</div>
</div>
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
    "iDisplayLength": 5,
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