@extends('layouts.app')
@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">
@endpush
@section('content')
               <div class="container-fluid">

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

                <div class="row">
                    <div class="col-md-12">

                        <!--  <div class="panel panel-filled">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group m-b-xs m-t-xs">
                                        <input class="form-control" type="text" placeholder="Search by Company.." style="width: 100%">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <select class="form-control m-b-xs m-t-xs" name="account" style="width: 100%">
                                        <option selected="">Select status</option>
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <select class="form-control m-t-xs" name="account" style="width: 100%">
                                        <option selected="">Sort by:</option>
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
-->

                        

                        <div class="panel">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-vertical-align-middle" id="tab1">
                                        <thead>
                                            <tr>

                                                <th>
                                                    #TicketNo
                                                </th>
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
                                                <td>
                                                    <a href="#">{{ $ticket->details }}</a>
                                                    <div class="small"><i class="fa fa-clock-o"></i> {{ $ticket->created_at }}</div>
                                                </td>
                                                <td>
                                                    {{ $ticket->category->name }}
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
                                                        <a href="{{ url("ticket/$ticket->ticket_id") }}" class="btn btn-default btn-xs"><i class="fa fa-folder"></i> View </a>
                                                        {{-- <a class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Edit </a> --}}

                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="pull-right">
                <ul class="pagination pagination-sm">
                <li class="disabled"><a href="#">Previous</a></li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">Next</a></li>
                </ul>
            </div>-->

            </div>   
             <div class="modal right fade in" id="ticketmodal" tabindex="-1" role="dialog" aria-hidden="true" style="max-height: 100%; overflow-y: auto;">
        <div class="modal-dialog">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-body ">

                        <div class="tabs-container">
                            <ul class="nav nav-tabs pull-left">

                                <li class="active"><a data-toggle="tab" href="#tab-10" aria-expanded="false">General</a></li>
                                {{-- <li class=""><a data-toggle="tab" href="#tab-11" aria-expanded="true">Payment Reconciliation</a></li> --}}

                            </ul>
                            <div class="pull-right"><a href="#" data-dismiss="modal" aria-hidden="true">Close &nbsp;<i class="fa fa-times"></i></a></div>
                            <div class="clearfix"></div>
                            <div class="tab-content">
                                <div id="tab-10" class="tab-pane  active">
                                    <div class="panel-body">
                                        <div class="row row-sm-height">
                                            <div class="col-sm-12 col-sm-height col-middle">

                                                <br/>
                                                    {{ Form::open(['action' => 'TicketController@store', 'class' => 'p-t-15', 'novalidate'=> 'novalidate']) }}

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group form-group-default">
                                                                <label>What Issue Do you have</label>
                                                                {{ Form::select('ticket_category_id', $categories->pluck('name','id'), null,['class' => 'select2_demo_1  form_control', 'style'=>"width: 100%"]) }}
                                                            </div>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group form-group-default">
                                                                <label>Give us a detailed Explanation of your issue</label>
                                                                {{ Form::textarea('details', null, ['class' => 'form-control', 'placeholder' => 'Enter Here']) }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button class="btn  btn-cons m-t-10" style="background-color:#134e5e;border-color:#134e5e;color:#f2f6f7" type="submit">Submit Ticket</button>
                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- tb10 -->

                                <div id="tab-11" class="tab-pane hide">
                                    <div class="panel-body">
                                        <br/>

                                        <form id="form-register" class="p-t-15" role="form" action="dashboard.html" novalidate="novalidate">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Bank Name</label>
                                                        <input type="text" name="fname" placeholder="Enter Here" class="form-control" required="" aria-required="true" aria-required="true">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Transaction Type</label>
                                                        <select class="select2_demo_1 form-control" id="ttype" style="width: 100%">
                                                            <option value="1">Cash</option>
                                                            <option value="2">Transfer</option>
                                                            <option value="3">Other</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Account Number Paid to</label>
                                                        <input type="text" name="uname" placeholder="Enter Here" class="form-control" required="" aria-required="true">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Amount Deposited</label>
                                                        <input type="text" name="phone" placeholder="Enter Here" class="form-control" required="" aria-required="true">
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="btn  btn-cons m-t-10" style="background-color:#134e5e;border-color:#134e5e;color:#f2f6f7" type="submit">Update Bank Details</button>
                                        </form>

                                    </div>
                                </div>
                                <!-- t11 -->

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer hide">
                        <a href="#" data-dismiss="modal" class="btn btn-w-md btn-accent btn-rounded">Close<span class="custom-close">&times;</span></a>
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
