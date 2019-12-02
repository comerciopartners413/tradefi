@extends('layouts.app')
@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">
<style>
.actionBtn {
    margin: 20px 12px;
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

                                <div class="row">
                                    <form action="" method="post">
                                        {{ csrf_field() }}
                                      <div class="col-md-4">
                                        <label>From</label>
                                        <input type="date" name="fromDate" value="{{ isset($from) ? $from : null }}" class="form-control" id="fromDate" placeholder="From">
                                    </div>
                                    <div class="col-md-4">
                                        <label>To</label>
                                        <input type="date" name="toDate" value="{{ isset($to) ? $to : null }}" class="form-control" id="toDate" placeholder="To">
                                    </div>
                                    <div class="col-md-4">
                                      <button type="submit" style="margin-top: 20px" id="process" class="btn btn-warning">Process</button>
                                    </div>
                                    </form>

                                </div>

                            </div>
                            <!-- pull right -->
                            <div class="header-icon">
                                <i class="pe page-header-icon pe-7s-repeat"></i>
                            </div>
                            <div class="header-title">
                                <h3>Trades on TradeFI</h3>
                                <small>List of all deals. (Shows today's list by default)
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

                            <div class="row">
                                <div class="col-md-4 col-xs-6 text-center">
                                    <h2 class="no-margins">
                                        {{ count($trade_data) }}
                                    </h2>
                                    <span class="c-white">Total Trades</span>
                                </div>
                                <div class="col-md-4 col-xs-6 text-center">
                                    <h2 class="no-margins">
                                        {{ count($bonds) }}
                                    </h2>
                                    <span class="c-white">Bonds Traded On</span>
                                </div>
                                <div class="col-md-4 col-xs-6 text-center">
                                    <h2 class="no-margins">
                                        {{ count($tbills) }}
                                    </h2>
                                    <span class="c-white">Treasury Bills Traded</span>
                                </div>
                            </div>

                        </div>
                    </div>
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
                            <div class="">
                                <!-- <p>
                            </p>-->
                            <div class="tabs-container">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-bonds" aria-expanded="false">FGN Bonds</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-tbills" aria-expanded="false">Treasury Blls</a></li>
                                    <!--   <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="true">Estimated Income</a></li>
                                   <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">Gains and Losses</a></li> -->
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-bonds" class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="actionBtn">
                                                <div class="pull-left checkbox check-info" style="margin: 0; margin: 0;padding: 3px 20px;text-align: center;">
                                                  <input type="checkbox" id="select-all">
                                                  <label for="select-all" class="text-white">Select all </label>
                                                </div>
                                                <button class="confirm-trades btn btn-sm btn-success">Confirm selected</button>
                                            </div>

                                            <table class="table datatables">
                                              <thead>
                                                <th class="no-sort"><i class="pe-7s-check" style="font-size:19px"></i></th>
                                                <th>TradeREF</th>
                                                <th>Username</th>
                                                <th>Trade Date</th>
                                                <th>Maturity</th>
                                                <th>Transaction Type</th>
                                                <th>Nominal Amount</th>
                                                <th>Settlement Amount</th>
                                                <th>Price</th>
                                                <th>Yield</th>
                                                <th>Settlement Date</th>
                                              </thead>

                                              <tbody>
                                                @foreach($trade_data as $trade)
                                                  @if($trade->security->ProductID ==  1)
                                                     <tr>
                                                      <td>
                                                        @if ($trade->ApprovedFlag == true)
                                                            
                                                        @else
                                                          <div class="checkbox checkbox-success">
                                                              <input class="select-all-child"  id="checkbox{{ $trade->TradeDataRef }}" type="checkbox" value="{{ $trade->TradeDataRef }}">
                                                              <label class="form-check-label" for="checkbox{{ $trade->TradeDataRef }}">
                                                              </label>
                                                          </div>
                                                        @endif
                                                      </td>
                                                      <td>{{ 'TRADEFIU-'. $trade->TradeDataRef }}</td>
                                                      <td>{{ $trade->user->username ?? '-' }}</td>
                                                      <td>{{ \Carbon\Carbon::parse($trade->TradeDate)->toFormattedDateString() }}</td>
                                                      <td>{{ $trade->security->Description }}</td>
                                                      <td style="font-weight: bold">{!! $trade->TransactionTypeID == 1 ? '<span class="text-success">Purchase</span>': '<span class="text-danger">Sale</span>' !!}</td>
                                                      <td>
                                                        ₦{{ number_format($trade->Quantity, 2) }}
                                                      </td>
                                                      <td>₦{{ number_format($trade->SettlementAmount, 2) }}</td>
                                                      <td>₦{{ number_format($trade->CleanPrice, 2) }}</td>
                                                      <td>{{ (!empty($trade->BankYield))? number_format($trade->BankYield, 2) : $trade->Yield }}%</td>
                                                      <td>{{ \Carbon\Carbon::parse($trade->SettlementDate)->toFormattedDateString() }}</td>
                                                      
                                                    </tr>
                                                  @endif
                                                @endforeach
                                              </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div id="tab-tbills" class="tab-pane">
                                        <div class="panel-body">

                                            <div class="actionBtn">
                                                <div class="pull-left checkbox check-info" style="margin: 0; margin: 0;padding: 3px 20px;text-align: center;">
                                                  <input type="checkbox" id="select-all">
                                                  <label for="select-all" class="text-white">Select all </label>
                                                </div>
                                                <button class="confirm-trades btn btn-sm btn-success">Confirm selected</button>
                                            </div>

                                            <table class="table datatables">
                                              <thead>
                                                <th class="no-sort"><i class="pe-7s-check" style="font-size:19px"></i></th>
                                                <th>TradeREF</th>
                                                <th>Username</th>
                                                <th>Trade Date</th>
                                                <th>Maturity</th>
                                                <th>Transaction Type</th>
                                                <th>Nominal Amount</th>
                                                <th>Settlement Amount</th>
                                                <th>Discount Rate</th>
                                                <th>Yield</th>
                                                <th>Settlement Date</th>
                                              </thead>

                                              <tbody>
                                                @foreach($trade_data as $trade)
                                                  @if($trade->security->ProductID ==  2)
                                                     <tr>
                                                      <td>
                                                          @if ($trade->ApprovedFlag == true)
                                                              
                                                          @else
                                                            <div class="checkbox checkbox-success">
                                                                <input class="select-all-child"  id="checkbox{{ $trade->TradeDataRef }}" type="checkbox" value="{{ $trade->TradeDataRef }}">
                                                                <label class="form-check-label" for="checkbox{{ $trade->TradeDataRef }}">
                                                                </label>
                                                            </div>
                                                          @endif
                                                        </td>
                                                      <td>{{ 'TRADEFIU-'. $trade->TradeDataRef }}</td>
                                                      <td>{{ $trade->user->username ?? '-' }}</td>
                                                      <td>{{ \Carbon\Carbon::parse($trade->TradeDate)->toFormattedDateString() }}</td>
                                                      <td>{{ $trade->security->Description }}</td>
                                                      <td style="font-weight: bold">{!! $trade->TransactionTypeID == 1 ? '<span class="text-success">Purchase</span>': '<span class="text-danger">Sale</span>' !!}</td>
                                                      <td>
                                                        ₦{{ number_format($trade->Quantity, 2) }}
                                                      </td>
                                                      <td>₦{{ number_format($trade->SettlementAmount, 2) }}</td>
                                                      <td>{{ number_format($trade->DiscountRate, 2) }}</td>
                                                      <td>{{ (!empty($trade->BankYield))? number_format($trade->BankYield*100, 2) : $trade->Yield*100 }}%</td>
                                                      <td>{{ \Carbon\Carbon::parse($trade->SettlementDate)->toFormattedDateString() }}</td>
                                                    </tr>
                                                  @endif
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
                order: [],
                columnDefs: [{
                  "targets"  : 'no-sort',
                  "orderable": false
                }],
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
        // $('div.actionBtn').html('<div class="pull-left checkbox check-info" style="margin: 0; margin: 0;padding: 3px 10px;text-align: center;"><input type="checkbox" id="select-all"><label for="select-all" class="text-white">Select all </label></div><button class="confirm-trades btn btn-sm btn-success">Confirm</button>');
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
    $("input#select-all").click(function (e) {
        let scope = $(e.target).closest('.tab-pane');
        scope.find('.select-all-child').prop('checked', this.checked);
    });

    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".select-all-child").click(function(e){
        let scope = $(e.target).closest('.tab-pane');
        if(scope.find(".select-all-child").length == scope.find(".select-all-child:checked").length) {
            scope.find("#select-all").prop("checked", "checked");
        } else {
            scope.find("#select-all").removeAttr("checked");
        }

    });
});


// Approval button script
$('.confirm-trades').click(function(e) {
     e.preventDefault();
     console.log(e.target);
     let scope = $(e.target).closest('.tab-pane');
     var checked_trades = scope.find('.select-all-child:checked');
     var checked_trades_array = [];
     $.each(checked_trades, function(index, val) {
          checked_trades_array.push(parseInt($(val).prop('value')));
     });
     console.log(checked_trades_array);

     if (confirm('Are You sure you want to confirm these trades?')) {

        //  var Comment = prompt("Enter Approval Comment");
        $.ajax({
            url: '/trades/confirm',
            type: 'POST',
            data: {
                refs: checked_trades_array,
                // Comment: Comment
            },
        })
        .done(function(res, status, xhr) {
            // Navigate to the list after succesful posting to the server
            if(xhr.status == 200) {
                // window.location.href  = "{{ route('admin.deposits.index') }}";
                checked_trades.closest('div.checkbox').remove();
                toastr.success(checked_trades.length + ' trades confirmed successfully.');
            } else {
                // alert('approval failed');
                toastr.error('Confirmation Failed');
                return false
            }
        })
        .fail(function() {
            console.log("error");
        });
       
     }
     
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
     if (confirm('Are You sure you want to confirm these trades?')) {
       
     }
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
