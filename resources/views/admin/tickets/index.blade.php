@extends('layouts.app')
@section('content')
<div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">
                            <div class="pull-right text-right" style="line-height: 14px">
                                <a href="#" data-toggle="modal" data-target="#ticketmodal" class="btn btn-default btn-sm"><i class="fa fa-edit"></i>&nbsp; New Ticket</a>

                            </div>
                            <div class="header-icon">
                                <i class="pe page-header-icon pe-7s-help2"></i>
                            </div>
                            <div class="header-title">
                                <h3>Support</h3>
                                <small>
                                Get in touch with us
                            </small>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            <div class="panel">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-vertical-align-middle" id="tab1">
                                        <thead>
                                            <tr>

                                                <th>
                                                    #TicketNo
                                                </th>
                                                <th>Sender</th>
                                                <th>
                                                    Ticket Details
                                                </th>
                                                <th>
                                                    Type
                                                </th>
                                                <th>
                                                    Status
                                                </th>

                                                <th class="text-right">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tickets as $ticket)
                                            <tr>

                                                <td>
                                                    TK-{{ $ticket->ticket_id }}
                                                </td>
                                                <td> {{ $ticket->profile->user->username?? '-' }} </td>
                                                <td>
                                                    <a href="#">{{ $ticket->details }}</a>
                                                    <div class="small"><i class="fa fa-clock-o"></i> {{ $ticket->created_at }}</div>
                                                </td>
                                                <td>
                                                    {{ $ticket->category->name ?? '-' }}
                                                </td>
                                                <td>
                                                     @if($ticket->status == 0)
                                                    <span class="label label-warning">Pending</span>
                                                    @elseif($ticket->status == 1)
                                                    <span class="label label-success">Open</span>
                                                    @elseif($ticket->status == 2)
                                                    <span class="label label-danger">Closed</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="btn-group pull-right">
                                                        <a href="{{ url("admin/tickets/$ticket->ticket_id") }}" class="btn btn-default btn-xs"><i class="fa fa-folder"></i> View </a>

                                                    </div>
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