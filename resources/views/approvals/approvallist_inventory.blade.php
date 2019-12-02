@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/trade_data.css') }}">

<style>
    .actionBtn button {
    margin-right: 10px
}
</style>
@endpush
@section('content')
<section class="bg-white container-fluid container-fixed">


        <div class="panel panel-filled">
            <div class="panel-heading">
                <div class="panel-title">
                    Approval List for Inventory
                </div>
                <div class="pull-right">
                    <div class="col-xs-12">
                        {{-- <input class="form-control pull-right search-table" placeholder="Search" type="text"> --}}
                    </div>
                </div>
                <div class="clearfix">
                </div>
            </div>

            <div class="panel-body">
                <table class="table" id="tableExample4">
                        <thead>
                            <th>
                                
                            </th>
                            <th>Security</th>
                            <th>Quantity</th>
                            <th>Created By</th>
                        </thead>
                        <tbody>
                           @foreach($inventory as $td)
                            <tr>
                                  <td>
                                                    <div class="checkbox check-info">
                      <input type="checkbox" id="select-all-child-{{ $td->InventoryRef }}" class="select-all-child" value="{{ $td->InventoryRef }}">
                      <label for="select-all-child-{{ $td->InventoryRef }}" class="text-white"></label>
                    </div>
                                                </td>
                                <td>{{ $td->security->Description }}</td>
                                <td>{{ number_format($td->Quantity, 2) }}</td>
                                <td>{{ $td->user->profile->fullname }}</td>
                               
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>



</section> 


@endsection



@push('scripts')
        <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript">
        </script>

        <SCRIPT language="javascript">
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
</SCRIPT>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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
        $('div.actionBtn').html('<div class="pull-left checkbox check-info" style="margin: 0; margin: 0;padding: 3px 10px;text-align: center;"><input type="checkbox" id="select-all"><label for="select-all" class="text-white">Select all </label></div><button class="approve-btn btn btn-sm btn-success">Approve</button><button class="reject-btn btn btn-sm btn-danger">Reject</button><br><br>');
    }
            });

 

 // Approval button script
 $('.approve-btn').click(function(e) {
     e.preventDefault();
     var that = $(this);
     var checked_trades = $('.select-all-child:checked');
     var checked_trades_array = [];
     $.each(checked_trades, function(index, val) {
          checked_trades_array.push(parseInt($(val).prop('value')));
     });
     console.log(checked_trades_array)
   var ApprovedDate = "{{ \Carbon\Carbon::now() }}";
   var ApproverID = {{ auth()->user()->id }};
     alert('Are You sure you want to approve?');
     var Comment = prompt("Enter Approval Comment");
     
     $.ajax({
         url: '/approvallist/approve',
         type: 'POST',
         data: {
            ApproverID: {{ auth()->user()->id }},
            SelectedID: checked_trades_array,
            ApprovedDate: ApprovedDate,
            ApprovedFlag: 1,
            ModuleID: 4,
            Comment: Comment
        },
        beforeSend: function(){
            // show button animation
            that.text('Approving ...');
        }
     })
     .done(function(res, status, xhr) {
         // Navigate to the list after succesful posting to the server
         if(xhr.status == 200) {
            
            window.location.href  = "{{ route('approvallist_inventory') }}";
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
     var checked_trades = $('.select-all-child:checked');
     var checked_trades_array = [];
     $.each(checked_trades, function(index, val) {
          checked_trades_array.push(parseInt($(val).prop('value')));
     });
     console.log(checked_trades_array)
   var RejectedDate = "{{ \Carbon\Carbon::now() }}";
   var RejecterID = {{ auth()->user()->id }};
     alert('Are You sure you want to reject this trade?');
     var Comment = prompt("Enter Rejection Comment");
     
     $.ajax({
         url: '/approvallist/reject',
         type: 'POST',
         data: {
            RejecterID: {{ auth()->user()->id }},
            SelectedID: checked_trades_array,
            RejectedDate: RejectedDate,
            RejectedFlag: 1,
            ModuleID: 4,
            Comment: Comment
        },
     })
     .done(function(res, status, xhr) {
         // Navigate to the list after succesful posting to the server
         if(xhr.status == 200) {
            window.location.href  = "{{ route('approvallist_inventory') }}";
         } else {
            alert('Rejection failed');
            return false
         }
         
     })
     .fail(function() {
         console.log("error");
     });
     
 });
        </script>
        
        @endpush

