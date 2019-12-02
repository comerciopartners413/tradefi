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
                            <i class="pe page-header-icon pe-7s-graph3"></i>
                        </div>
                        <div class="header-title">
                            <h3>Macros</h3>
                            <small>
                                Enter macro(s) data
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
                           		<th>Name</th>
                           		<th>Current</th>
                           		<th>Previous</th>
                           	</thead>

                           	<tbody>
                           		@foreach($macros as $macro)
                           		<tr>
                           			<input type="hidden" class="macro-id" value="{{ $macro->id }}">
                           			<td>{{ $macro->name }}</td>
                           			<td><input type="number" class="form-control" name="current" value="{{ !empty($macro->current) ? number_format($macro->current, 2): null }}"></td>
                           			<td><input type="number" class="form-control" name="previous" value="{{!empty($macro->previous) ? number_format($macro->previous, 2) : null }}"></td>
                                <td><input type="date" class="form-control" name="as_at" value="{{!empty($macro->as_at) ? ($macro->as_at) : null }}"></td>
                           			<td><button class="btn btn-sm btn-success macro-button">Update</button></td>
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
	 $('.macro-button').click(function(e) {
	 	e.preventDefault();
	 	var that = $(this);
	 	var row  = $(this).closest('tr'),
	 	macro_id = row.find('.macro-id'),
	 	current = row.find("[name=current]"),
    previous = row.find("[name=previous]");
	 	as_at = row.find("[name=as_at]");
	 	console.log(macro_id)
	 	$.ajax({
	 		url: '/admin/macros/save',
	 		type: 'post',
	 		data: {
        id:  macro_id.val(),
	 			current: current.val(),
        previous: previous.val(),
	 			as_at: as_at.val(),
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