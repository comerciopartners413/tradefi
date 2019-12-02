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
                            <i class="pe page-header-icon pe-7s-pen"></i>
                        </div>
                        <div class="header-title">
                            <h3>News Room</h3>
                            <small>
                                Enter news content below
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
                            <form action="{{ route('admin.news.store') }}" method="post">
                            	{{ csrf_field() }}
                            	<div class="row">
                            		<div class="form-group col-sm-6">
                            		<label for="title">Title</label>
                            		<input type="text" name="title" class="form-control" placeholder="Enter News Title">
                            	</div>
                            	</div>
                            	<textarea name="body" id="body" class="summernote"></textarea>

                            	<div class="form-actions">
                            		<button type="submit" class="btn btn-success">Post News</button>
                            	</div>
                            </form>

                        </div>
                    </div>
                </div>

            </div> <br><br>

            <div class="panel panel-filled">

                <div class="panel-body">
                    <h3>News</h3> <hr>
                    <table class="table datatable">
                    <thead>
                        <th>Title</th>
                        <th>Date Create</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        @foreach($news as $new)
                        <tr>
                            <td>{{ $new->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($new->created_at)->toFormattedDateString() }}</td>
                            <td>
                                <form action="/admin/news/{{ $new->id }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" value="{{ $new->id }}">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
	 $('.summernote').summernote();
});
</script>
@endpush
