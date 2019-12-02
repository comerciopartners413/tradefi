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
                            <h3>Create FAQ</h3>
                            <small>
                                Create more FAQs [:)]
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
                            <form action="{{ route('admin.faqs.store') }}" id="faq-form" method="post">
                            	{{ csrf_field() }}
                            	<div class="row">
                            		<div class="form-group col-sm-6">
                            		<label for="title">Subject</label>
                            		<input type="text" name="subject" class="form-control" placeholder="Enter FAQ subject">
                            	</div>
                            	</div>
                            	<textarea name="body" id="body" class="summernote" rows="5" placeholder="Enter Body for FAQ"></textarea>

                            	<div class="form-actions">
                            		<button type="submit" class="btn btn-success save-faq">Post FAQ</button>
                            	</div>
                            </form>

                        </div>
                    </div>
                </div>

            </div> <br><br>

            <div class="panel panel-filled">

                <div class="panel-body">
                    <h3>FAQs</h3> <hr>
                    <table class="table datatable">
                    <thead>
                        <th width="70%">FAQ</th>
                        {{-- <th></th> --}}
                        <th width="30%" valign="middle" class="text-right">Action</th>
                    </thead>

                    <tbody>
                        @foreach($faqs as $faq)
                        <tr>
                            <td width="70%">
                                <p><b>{{ $faq->subject }}</b></p>
                                <div>
                                    {!! $faq->body !!}
                                </div>
                            </td>
                            {{-- <td>{{ \Carbon\Carbon::parse($faq->created_at)->toFormattedDateString() }}</td> --}}
                            <td valign="middle" class="text-right" width="30%">
                                
                                <form action="/admin/faqs/{{ $faq->id }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" value="{{ $faq->id }}">
                                    <button type="button" class="btn btn-info ">Edit</button>
                                    <button type="submit" class="btn btn-danger ">Delete</button>
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

    $('.save-faq').click(function(e) {
        e.preventDefault();
        var params = $('#faq-form').serializeArray();
        $.post('/admin/faqs', params, function(data, textStatus, xhr) {
            alert('saved');
        });
    });
</script>

<script language="javascript">
$(function(){
	 $('.summernote').summernote();
});
</script>
@endpush
