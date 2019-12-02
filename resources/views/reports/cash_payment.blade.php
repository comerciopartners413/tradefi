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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">
                            <div class="pull-right" style="line-height: 14px">


                            </div>
                            <!-- pull right -->
                            <div class="header-icon">
                                <i class="pe page-header-icon pe-7s-cash"></i>
                            </div>
                            <div class="header-title">
                                <h3>Cash Release</h3>
                                <small>...
                            </small>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-filled">
                            <div class="panel-heading">
                                <div class="panel-tools">
                                    <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                    <a class="panel-close"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <!-- <p>
                            </p>-->
                            <div class="tabs-container">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-bonds" aria-expanded="false">Securities</a></li>
                                    <li class="hide"><a data-toggle="tab" href="#tab-tbills" aria-expanded="false">Treasury Blls</a></li>
                                    <!--   <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="true">Estimated Income</a></li>
                                   <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">Gains and Losses</a></li> -->
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-bonds" class="tab-pane active">
                                        <div class="panel-body">
                                            <table class="table datatables">
                                              <thead>
                                                <th>Username</th>
                                                {{-- <th>GLIDCredit</th> --}}
                                                <th>Maturity</th>
                                                
                                                <th>Value Date</th>
                                                <th>Amount Payable</th>
                                                <th>Action</th>
                                              </thead>

                                              <tbody>

                                                @foreach($cash_payment as $cp)
                                                <tr>
                                                    <td>{{ $cp->user->username ?? '-' }}</td>
                                                    {{-- <td>{{ $cp->GLIDCredit }}</td> --}}
                                                    <td>{{ $cp->security->Description }}</td>
                                                    {{-- <td>{{ number_format($cp->Position, 2) }}</td> --}}
                                                    <td>{{ \Carbon\Carbon::parse($cp->ValueDate)->toFormattedDateString() }}</td>
                                                    <td>{{ number_format($cp->AmountPayable) }}</td>
                                                    <td>
                                                        <form action="{{ route('post-cr') }}" method="post">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="CashReleaseRef" value="{{ $cp->CashReleaseRef }}">
                                                            <button type="submit" class="btn btn-warning" data->Pay</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                
                                              </tbody>
                                            </table>
                                        </div>
                                    </div> 
                                </div>

                                <div class="tab-content hide">
                                    <div id="tab-tbills" class="tab-pane ">
                                        <div class="panel-body">
                                            <table class="table datatables">
                                              <thead>
                                                <th>Username</th>
                                                <th>Maturity</th>
                                                
                                                <th>Value Date</th>
                                                <th>Amount Payable</th>
                                                <th>Action</th>
                                              </thead>

                                              <tbody>

                                                @foreach($cash_payment as $cp)
                                                <tr>
                                                    <td>{{ $cp->user->username ?? '-' }}</td>
                                                    {{-- <td>{{ $cp->GLIDCredit }}</td> --}}
                                                    <td>{{ $cp->security->Description }}</td>
                                                    {{-- <td>{{ number_format($cp->Position, 2) }}</td> --}}
                                                    <td>{{ \Carbon\Carbon::parse($cp->ValueDate)->toFormattedDateString() }}</td>
                                                    <td>{{ number_format($cp->AmountPayable) }}</td>
                                                    <td>
                                                        <form action="{{ route('post-cr') }}" method="post">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="CashReleaseRef" value="{{ $cp->CashReleaseRef }}">
                                                            <button type="submit" class="btn btn-warning" data->Pay</button>
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
                    </div>

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

    $('.datatables').DataTable({
                dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
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
                }],
                fnDrawCallback: function(oSettings) {
        $('.export-options-container').append($('.exportOptions').css('float', 'right'));
        $('div.actionBtn').html('<div class="pull-left checkbox check-info" style="margin: 0; margin: 0;padding: 3px 10px;text-align: center;"><input type="checkbox" id="select-all"><label for="select-all" class="text-white">Select all </label></div><button class="approve-btn btn btn-sm btn-success">Approve</button><button class="reject-btn btn btn-sm btn-danger">Reject</button>');
    }
            });

    $('#tableExample3').DataTable({
                dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
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
     alert('Are You sure you want to approve this deposit?');
     var Comment = prompt("Enter Approval Comment");
     $.ajax({
         url: '/approvallist/approve',
         type: 'POST',
         data: {
            ApproverID: {{ auth()->user()->id }},
            SelectedID: checked_trades_array,
            ApprovedDate: ApprovedDate,
            ApprovedFlag: 1,
            ModuleID: 36,
            Comment: Comment
        },
     })
     .done(function(res, status, xhr) {
         // Navigate to the list after succesful posting to the server
         if(xhr.status == 200) {
            window.location.href  = "{{ route('admin.deposits.index') }}";
         } else {
            alert('approval failed');
            return false
         }
         
     })
     .fail(function() {
         console.log("error");
     });
     
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
     alert('Are You sure you want to reject this deposit?');
     var Comment = prompt("Enter Rejection Comment");
     
     $.ajax({
         url: '/approvallist/reject',
         type: 'POST',
         data: {
            RejecterID: {{ auth()->user()->id }},
            SelectedID: checked_trades_array,
            RejectedDate: RejectedDate,
            RejectedFlag: 1,
            ModuleID: 36,
            Comment: Comment
        },
     })
     .done(function(res, status, xhr) {
         // Navigate to the list after succesful posting to the server
         if(xhr.status == 200) {
            window.location.href  = "{{ route('approvallist') }}";
         } else {
            alert('Rejection failed');
            return false
         }
         
     })
     .fail(function() {
         console.log("error");
     });
     
 });
</SCRIPT>
@endpush
