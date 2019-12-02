@extends('layouts.app')
@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">
@endpush
@section('content')
    <div class="container-fluid">
       <div class="row">
            <h3>Ticket Details - <span style="color: #f6a821">#{{ $ticket->ticket_id }}</span> - <b>{{ $ticket->category->name }}</b></h3>
            <p>Created: {{ $ticket->created_at->diffForHumans() }}</p>


            <div class="ticket-info">
        <div class="panel panel-filled">
            <div class="panel-heading">
                
            </div>

            <div class="panel-body">
                <p>{{ $ticket->details }}</p> <br>

                {{ Form::open(['action' =>'CommentController@store']) }}
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group form-group-default">
                            <label>Comment</label>
                            <textarea  name="comment" placeholder="Enter Here" class="form-control" required="" aria-required="true" aria-required="true"></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                <button type="submit" class="btn btn-success">Post Comment</button>
                {{ Form::close() }} <br>

                <section>
                        @foreach( $ticket_comments as $tc )
                        <div class="comment__details">
                            <div class="panel panel-filled" style="padding: 20px">
                                {{ $tc->comment }}
                            </div>
                        </div>
                        @endforeach
                </section>
            </div>

        </div>
            
        </div>
       </div>
       
    </div>              
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
{{-- <script src="{{ asset('webapp/vendor/select2/dist/js/select2.js') }}"></script> --}}
<script>
	$('.datepicker').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd'
	});
    $('#tab1').DataTable({});
</script>
@endpush
