@extends('layouts.app')

@push('styles')
	
@endpush

@section('content')
<section class="bg-white container-fluid container-fixed">

  <div class="view-header">
        <div class="header-icon">
            <i class="pe page-header-icon pe-7s-display2"></i>
        </div>
        <div class="header-title">
            <h3>Make Spread</h3>
            <small>
            Make spread for bonds and Treasury Bills
        </small>
        </div>
    </div>
    <div class="tabs-container">
      <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#tab-tbills-spread" aria-expanded="false">Treasury Bills</a></li>
          <li class=""><a data-toggle="tab" href="#tab-bonds-spread" aria-expanded="false">FGN Bonds</a></li>
      </ul>
      <div class="tab-content active"> <br><br>
          <div id="tab-tbills-spread" class="tab-pane active">
            {{ Form::model($spread, ['action' => ['SecurityController@spread_update_tbills', $spread->SpreadRef ], 'autocomplete' => 'off', 'novalidate' => 'novalidate', 'role' => 'form']) }}
              {{ method_field('PATCH') }}
              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="">Tbills Spread (Buy)</label>
                {{ Form::text('TBillsSpreadBuy', null, ['class' => 'form-control']) }}
              </div>

              <div class="form-group col-sm-6">
                <label for="">Tbills Spread (Sell)</label>
                {{ Form::text('TBillsSpreadSell', null, ['class' => 'form-control']) }}
              </div>

              </div>
              <button class="btn btn-warning">Update TBills Spread</button>
            {{ Form::close() }}
          </div>

          <div id="tab-bonds-spread" class="tab-pane">
            {{ Form::model($spread, ['action' => ['SecurityController@spread_update_bonds', $spread->SpreadRef ], 'autocomplete' => 'off', 'novalidate' => 'novalidate', 'role' => 'form']) }}
              {{ method_field('PATCH') }}
              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="">Bonds Spread (Buy)</label>
                {{ Form::text('BondsSpreadBuy', null, ['class' => 'form-control']) }}
              </div>
               <div class="form-group col-sm-6">
                  <label for="">Bonds Spread (Sell)</label>
                {{ Form::text('BondsSpreadSell', null, ['class' => 'form-control']) }}
              </div>
              </div>
              <button class="btn btn-warning">Update Bonds Spread</button>
            {{ Form::close() }}
          </div>
      </div>    
    </div>


          {{-- not using this one below --}}
    <div class="tabs-container hide">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab-tbills" aria-expanded="false">Treasury Bills</a></li>
        <li class=""><a data-toggle="tab" href="#tab-bonds" aria-expanded="false">FGN Bonds</a></li>
    </ul>
    <div class="tab-content active">
        <div id="tab-tbills" class="tab-pane active">
            <div class="panel-body">
              <div class="table-responsive">
        <table  class="table securities-table">
          <thead>
            <th></th>
            <th width="20%">Security</th>
            <th width="20%">Spread</th>
          </thead>

          <tfoot class="thead">
            <th></th>
            <th>Security</th>
            <th>Spread</th>
          </tfoot>
          <tbody>
            @foreach($securities_tbills as $security)
            <tr>
              <td>{{ $security->SecurityRef}}</td>
              <td>{{ $security->Security }}</td>
              <td class="v-align-middle">{{ $security->Spread }}</td>
              
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
            </div>
        </div>

        <div id="tab-bonds" class="tab-pane">
            <div class="panel-body">
              <div class="table-responsive">
        <table  class="table securities-table">
          <thead>
            <th></th>
            <th width="20%">Security</th>
            <th width="20%">Spread</th>
          </thead>

          <tfoot class="thead">
            <th></th>
            <th>Security</th>
            <th>Spread</th>
          </tfoot>
          <tbody>
            @foreach($securities_bonds as $security)
            <tr>
              <td>{{ $security->SecurityRef}}</td>
              <td>{{ $security->Security }}</td>
              <td class="v-align-middle">{{ $security->Spread }}</td>
              
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
            </div>
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
	$('.securities-table').Tabledit({
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
restoreButton: true,
buttons: {
  edit: {
    class: 'btn btn-sm btn-warning',
    html: '<span class="">Edit Spread</span>',
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
	console.log(action);
	console.log(serialize);
        console.log(serialize.concat("&ModifierID="+mod));
        var id = (serialize.concat("&ModifierID="+mod)).split('&')[0].split('=')[1];        
    },
	columns: {
	  identifier: [0, 'id'],                    
	  editable: [[2, 'Spread']],
	}

});
	// $('.securities-table').editableTableWidget();
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
      

var table = $('.securities-table').DataTable(settings);
 $('.securities-table tfoot th').each(function(key, val) {
            var title = $(this).text();
            // console.log($('.securities-table tfoot th').length);
             if (key === $('.securities-table tfoot th').length - 2) {
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" /><button class="toggleMaturity">Matured</button>');
            }
            if (key === $('.securities-table tfoot th').length - 0) {
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


 
  // });
</script>
@endpush