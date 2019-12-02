@extends('layouts.app')
@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">
<style>
.actionBtn {
    margin: 20px 0;
}
    .actionBtn button {
    margin-right: 10px
}
</style>
@endpush
@section('content')
<div class="container-fluid">
   <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">
                            <div class="pull-right text-right" style="line-height: 14px">

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Period</label>
                                        <select class="select2_demo_1 form-control" style="width: 100%">
                                            <option value="1">Today</option>
                                            <option value="2">Yesterday</option>
                                            <option value="3">Last 7 days</option>
                                            <option value="4">Last Month</option>
                                            <option value="5">Month to Date</option>
                                            <option value="4">All</option>
                                            <option value="5">Custom</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>From</label>
                                        <input type="date" class="form-control" id="exampleInputName" placeholder="From">
                                    </div>
                                    <div class="col-md-4">
                                        <label>To</label>
                                        <input type="date" class="form-control" id="exampleInputName" placeholder="To">
                                    </div>

                                </div>

                            </div>
                            <!-- pull right -->
                            <div class="header-icon">
                                <i class="pe page-header-icon pe-7s-piggy"></i>
                            </div>
                            <div class="header-title">
                                <h3>Withdrawal Requests</h3>
                                <small>List of all customer withdrawal requests 
                            </small>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4">
                    </div>

                    <div class="col-md-4">
                    </div>
                </div>
                

            </div>
</div>

<div class="tabs-container">
                            <ul class="nav nav-tabs pull-left">

                                <li class="active"><a data-toggle="tab" href="#tab-10" aria-expanded="false">Unapproved Request &nbsp; <span class="badge badge-warning">{{ count($unapproved_withdrawals) }}</span></a></li>
                                <li class=""><a data-toggle="tab" href="#tab-11" aria-expanded="true">Approved &nbsp; <span class="badge">{{ count($approved_withdrawals) }}</span></a></li>
                                <li class=""><a data-toggle="tab" href="#tab-12" aria-expanded="true">Unsent/Rejected &nbsp; <span class="badge">{{ count($unsent_withdrawals) }}</span></a></li>

                            </ul>
                            <div class="clearfix"></div>
                            <div class="tab-content">
                                <div id="tab-10" class="tab-pane  active">
                                    <div class="panel-body">
                                        <div class="row row-sm-height">
                                            <div class="">
                    <div class="col-md-12">
                        <div class="table-responsive">

                                    <table id="tableExample4" style="color: #fff" class="table table-striped table-hover">
                                        <thead>
                                            <tr class="ibuy">
                                                <th>
                                                    
                                                </th>
                                                <th>Customer</th>
                                                <th>Request Date</th>
                                                <th>Amount Requested</th>
                                                <th>Bank</th>
                                                <th>Account Number Paid to</th>
                                                {{-- <th></th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($unapproved_withdrawals as $withdrawal)
                                            <tr>
                                                <td>
                                                    <div class="checkbox check-info">
                      <input type="checkbox" id="select-all-child-{{ $withdrawal->CashEntryRef }}" class="select-all-child" value="{{ $withdrawal->CashEntryRef }}">
                      <label for="select-all-child-{{ $withdrawal->CashEntryRef }}" class="text-white"></label>
                    </div>
                                                </td>
                                                 <td>{{ $withdrawal->user->profile->fullname}}</td>
                                                <td>{{ \Carbon\Carbon::parse($withdrawal->TransactionDate)->toFormattedDateString()}}</td>
                                                <td>{{ number_format(($withdrawal->Amount), 2) }}</td>
                                                <td>{{ $withdrawal->user->profile->bank_detail->bank->sort_codes ?? 'N/A' }}</td>
                                                <td>{{ $withdrawal->NubanPaidTo }}</td>
                                            </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                    </div>

                </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- tb10 -->

                                <div id="tab-11" class="tab-pane ">
                                    <div class="panel-body">
                                        <div class="row row-sm-height">
                                            <div class="">
                    <div class="col-md-12">
                        <div class="table-responsive">

                                    <table id="tableExample3" style="color: #fff" class="table table-striped table-hover">
                                        <thead>
                                            <tr class="ibuy">
                                                <th>
                                                    
                                                </th>
                                                <th>Customer</th>
                                                <th>Request Date</th>
                                                <th>Amount Requested</th>
                                                <th>Bank</th>
                                                <th>Account Number</th>
                                                {{-- <th></th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($approved_withdrawals as $withdrawal)
                                            <tr>
                                                <td>
                                                   
                                                </td>
                                                <td>{{ $withdrawal->user->profile->fullname}}</td>
                                                <td>{{ \Carbon\Carbon::parse($withdrawal->TransactionDate)->toFormattedDateString()}}</td>
                                                <td>{{ number_format(($withdrawal->Amount ), 2) }}</td>
                                                <td>{{ $withdrawal->user->profile->bank_detail->bank->sort_codes ?? 'N/A'}}</td>
                                                <td>{{ $withdrawal->NubanPaidTo }}</td>
                                            </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                    </div>

                </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- t11 -->


                                <div id="tab-12" class="tab-pane ">
                                    <div class="panel-body">
                                        <div class="row row-sm-height">
                                            <div class="">
                    <div class="col-md-12">
                        <div class="table-responsive">

                                    <table id="tableExample3" style="color: #fff" class="table table-striped table-hover">
                                        <thead>
                                            <tr class="ibuy">
                                                <th>
                                                    
                                                </th>
                                                <th>Customer</th>
                                                <th>Request Date</th>
                                                <th>Amount Requested</th>
                                                <th>Bank</th>
                                                <th>Action</th>
                                                {{-- <th></th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($unsent_withdrawals as $withdrawal)
                                            <tr>
                                                <td>
                                                   
                                                </td>
                                                <td>{{ $withdrawal->user->profile->fullname}}</td>
                                                <td>{{ \Carbon\Carbon::parse($withdrawal->TransactionDate)->toFormattedDateString()}}</td>
                                                <td>{{ number_format(($withdrawal->Amount), 2) }}</td>
                                                <td>{{ $withdrawal->user->profile->bank_detail->bank->sort_codes ?? 'N/A'}}</td>
                                                <td> 
                                                  <form action="/withdrawals/send/{{ $withdrawal->CashEntryRef }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PATCH') }}
                                                    <button type="submit" class="btn btn-sm btn-warning">Send</button>
                                                  </form>
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
                                </div>
                                <!-- 12 -->

                            </div>
                        </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
<script>
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    $('#tableExample4').DataTable({
                dom: "<'actionBtn'><'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                buttons: [{
                    extend: 'copy',
                    className: 'btn-sm'
                }, {
                    extend: 'excel',
                    title: 'TradeFi Excel Export',
                    className: 'btn-sm'
                },
                {
                    extend: 'csv',
                    header: false,
                    title: 'TradeFI Withdrawals Export',
                    className: 'btn-sm'
                }, {
                    extend: 'pdf',
                    title: 'TradeFi Pdf Export',
                    className: 'btn-sm'
                }, {
                    extend: 'print',
                    className: 'btn-sm'
                }],
                fnDrawCallback: function(oSettings) {
        $('.export-options-container').append($('.exportOptions').css('float', 'right'));
        $('div.actionBtn').html('<div class="pull-left checkbox check-info" style="margin: 0; margin: 0;padding: 3px 10px;text-align: center;"><input type="checkbox" id="select-all"><label for="select-all" class="text-white">Select all </label></div><button class="approve-btn btn btn-sm btn-success">Approve</button><button class="reject-btn btn btn-sm btn-danger">Reject</button>');
    }
            });

    $('#tableExample3').DataTable({
                dom: "<'actionBtn'><'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                buttons: [{
                    extend: 'copy',
                    className: 'btn-sm'
                }, {
                    extend: 'excel',
                    title: 'TradeFi Excel Export',
                    className: 'btn-sm'
                }, {
                    extend: 'pdf',
                    title: 'TradeFi Pdf Export',
                    className: 'btn-sm'
                }, {
                    extend: 'print',
                    className: 'btn-sm'
                }]
            });
</script>

<script language="javascript">
$(function(){

    // add multiple select / deselect functionality
    $("#select-all").click(function () {
          $('.select-all-child').prop('checked', this.checked);
    });

    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".select-all-child").click(function(){

        if($(".select-all-child").length == $(".select-all-child:checked").length) {
            $("#select-all").prop("checked", "checked");
        } else {
            $("#select-all").removeAttr("checked");
        }

    });
});

// Approval button script
 $('.approve-btn').click(function(e) {
     e.preventDefault();
     var checked_trades = $('.select-all-child:checked');
     var checked_trades_array = [];
     $.each(checked_trades, function(index, val) {
          checked_trades_array.push(parseInt($(val).prop('value')));
     });
     console.log(checked_trades_array)
   var ApprovedDate = "{{ \Carbon\Carbon::now() }}";
   var ApproverID = {{ auth()->user()->id }};

   var confirm = window.confirm('Are You sure you want to approve this withdrawal?');
     // alert('');
    if(confirm){
         var Comment = prompt("Enter Approval Comment");
     $.ajax({
         url: '/approvallist/approve',
         type: 'POST',
         data: {
            ApproverID: {{ auth()->user()->id }},
            SelectedID: checked_trades_array,
            ApprovedDate: ApprovedDate,
            ApprovedFlag: 1,
            ModuleID: 37,
            Comment: Comment
        },
     })
     .done(function(res, status, xhr) {
         // Navigate to the list after succesful posting to the server
         if(xhr.status == 200) {
            toastr.success('Action was successful')
            setTimeout(function(){
                window.location.href  = "{{ route('withdrawals.index') }}";
            }, 1000)
            
         } else {
            toastr.error('approval failed');
            return false
         }
         
     })
     .fail(function() {
         console.log("error");
         toastr.error('approval failed');
     });
    }
     
 });


  $('.reject-btn').click(function(e) {
     e.preventDefault();
     // alert('jah - rule');
     var checked_trades = $('.select-all-child:checked');
     var checked_trades_array = [];
     $.each(checked_trades, function(index, val) {
          checked_trades_array.push(parseInt($(val).prop('value')));
     });
     console.log(checked_trades_array)
   var RejectedDate = "{{ \Carbon\Carbon::now() }}";
   var RejecterID = {{ auth()->user()->id }};
     // alert('');
     var confirm = window.confirm('Are You sure you want to reject this withdrawal?');
     if(confirm){
        var Comment = prompt("Enter Rejection Comment");
     
     $.ajax({
         url: '/approvallist/reject',
         type: 'POST',
         data: {
            RejecterID: {{ auth()->user()->id }},
            SelectedID: checked_trades_array,
            RejectedDate: RejectedDate,
            RejectedFlag: 1,
            ModuleID: 37,
            Comment: Comment
        },
     })
     .done(function(res, status, xhr) {
         // Navigate to the list after succesful posting to the server
         console.log(res)
         if(xhr.status == 200) {
           toastr.success('Action was Successful')
            setTimeout(function(){
                window.location.href  = "{{ route('withdrawals.index') }}";
            }, 1000)
            
         } else {
            toastr.error('Rejection failed');
            return false
         }
         
     })
     .fail(function() {
         console.log("error");
     });
     }
     
 });
</SCRIPT>
@endpush
