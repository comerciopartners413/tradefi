@extends('layouts.app')
@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">
<style type="text/css">
    .clearfix {
    clear: both;
}
</style>
@endpush
@section('content')
    <div class="container-fluid">
       <div class="row">
            <div class="pull-left">
                <h3>Ticket Details - <span style="color: #f6a821">#{{ $ticket->ticket_id }}</span> - <b>{{ $ticket->category->name }}</b></h3>
                 @if($ticket->status == 2)
                <span class="label label-danger">closed</span> <br><br>
                @elseif($ticket->status == 1)
                 <span class="label label-success">open</span> <br><br>
                 @elseif($ticket->status == 0)
                 <span class="label label-warning">pending</span> <br><br>
                @endif
            </div>

            <div class="pull-right">
              
            </div>
            <div class="clearfix"></div>
            <p>Created: {{ $ticket->created_at->diffForHumans() }}</p>


            <div class="ticket-info">
        <div class="panel panel-filled">
            <div class="panel-heading">
                
            </div>

            <div class="panel-body">

               @if($ticket->status == 2)
                <p class="text-danger"><b>This Ticket has been closed. You can re-open it by replying to the thread below</b></p>
                @endif
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
                <button type="submit" class="btn btn-success">Reply</button>
                {{ Form::close() }} <br>

                <section>
                        @foreach( $ticket_comments as $tc )
                        <div class="comment__details">
                            <div class="panel panel-filled" style="padding: 20px; {{ $tc->user_id == auth()->user()->id ? "float: left; background: #cccccc66;" : "float: right; background: #cccccc11;" }} width: 70%;  margin-bottom: 15px">
                                    {{ $tc->comment }} 
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        @endforeach
                </section>
            </div>

        </div>
        <div>

               @if($ticket->status != 2 && auth()->user()->admin)
            <a href="{{ url("/admin/tickets/close/$ticket->ticket_id") }}" class="btn btn-danger">Close Ticket</a>
            @endif
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
