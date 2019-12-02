@extends('layouts.app')
@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">
<link rel="stylesheet" href="{{ asset('webapp/vendor/summernote/dist/summernote.css') }}"/>
 <style>
 	.note-editor.panel-default .note-editing-area .note-editable {
    background-color: transparent;
    color: #949ba2;
}
 </style>
@endpush
@section('content')

<div class="container-fluid">
	<div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-graph2"></i>
                        </div>
                        <div class="header-title">
                            <h3>FX</h3>
                            <small>
                                Enter Foreign Exchange data
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            
<div class="row">

                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                           <table class="table">
                           	<thead>
                           		<th>Pairs</th>
                           		<th>Today's Price</th>
                           		<th>Previous Price</th>
                           	</thead>

                           	<tbody>
                           		@foreach($fxs as $fx)
                           		<tr>
                           			<input type="hidden" class="fx-id" value="{{ $fx->id }}">
                           			<td>{{ $fx->pairs }}</td>
                           			<td><input type="number" class="form-control" name="current" value="{{ !empty($fx->current) ? $fx->current : null }}"></td>
                           			<td><input type="number" class="form-control" name="previous" value="{{!empty($fx->previous) ? $fx->previous : null }}"></td>
                           			<td><button class="btn btn-sm btn-success fx-button">Update</button></td>
                           		</tr>
                           		@endforeach
                           	</tbody>
                           </table>

                        </div>
                    </div>
                </div>

            </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('webapp/vendor/summernote/dist/summernote.min.js') }}" type="text/javascript"></script>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

<script language="javascript">
$(function(){
	 $('.fx-button').click(function(e) {
	 	e.preventDefault();
    var that = $(this);
	 	var row  = $(this).closest('tr'),
	 	fx_id = row.find('.fx-id'),
	 	current = row.find("[name=current]"),
	 	previous = row.find("[name=previous]");
	 	console.log(fx_id)
	 	$.ajax({
	 		url: '/admin/fx/save',
	 		type: 'post',
	 		data: {
        id: fx_id.val(),
	 			current: current.val(),
	 			previous: previous.val(),
	 		},
      beforeSend: function(){
            that.text('Updating..');
         }
    })
    .done(function(data) {
      console.log(data);
      toastr.success(data);
    })
    .fail(function(error) {
      toastr.error('Something went wrong. Contact Admin');
      console.log(error);
    })
    .always(function() {
      that.text('Update');
      console.log("complete");
    });
	 	
	 });
});
</script>
@endpush