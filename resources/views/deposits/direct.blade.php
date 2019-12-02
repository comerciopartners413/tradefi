@extends('layouts.app')

@section('content')

<div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="fa page-header-icon fa-money"></i> 
                            </div>
                            <div class="header-title">
                                <h3>Direct Deposits</h3>
                                <small>
                               View Direct Bank Deposits
                            </small>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                </div>
          
<section class="bg-white container-fluid container-fixed">

      <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#pending" aria-expanded="true">Pending <label class="badge badge-danger">{{ count($deposits) }}</label></a></li>

                                 <li class=""><a data-toggle="tab" href="#approved" aria-expanded="true">Approved <label class="badge badge-danger">{{ count($approved_deposits) }}</label></a></li>

                                 <li class=""><a data-toggle="tab" href="#posted" aria-expanded="true">Posted <label class="badge badge-danger">{{ count($posted_deposits) }}</label></a></li>
                                

                            </ul>
                            <div class="tab-content">
                                <div id="pending" class="tab-pane active">
                                    <div class="panel-body" style="padding-top: 30px"> 
                                      <table class="table" id="tableExample4">
                        <thead>
                            <th>
                                
                            </th>
                           <th>Username</th>
                           <th>Proof of Payment</th>
                        </thead>
                        <tbody>
                           @foreach($deposits as $td)
                            <tr>
                                  <td>
                                                    <div class="checkbox check-info">
                      <input type="checkbox" id="select-all-child-{{ $td->id }}" class="select-all-child" value="{{ $td->id }}">
                      <label for="select-all-child-{{ $td->id }}" class="text-white"></label>
                    </div>
                                                </td>
                                <td>{{ $td->user->username }}</td>
                                                           <td>
                                                               @if($td->pop != '' && pathinfo(asset('storage/'.$td->pop))['extension'] == 'pdf') 
                                        <a href="{{ asset('storage/'.$td->pop.'/'.pathinfo(asset('storage/'.$td->pop))['basename']) }}">Click to View</a>
                                        @elseif($td->pop != '' && pathinfo(asset('storage/'.$td->pop))['extension'] != 'pdf') 
                                        <a href="{{ asset('storage/'.$td->pop.'/'.pathinfo(asset('storage/'.$td->pop))['basename']) }}">Click to View</a>
                                      @else
                                       <img src="{{ asset('storage/'.$td->pop) }}" class="image img-rounded" width="200" data-high-res-src="{{ asset('storage/'.$td->pop) }}" alt="ID">
                                     @endif
                                                           </td>
                               
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                                     </div>
                                </div>

                                <div id="approved" class="tab-pane ">
                                  <div class="panel-body" style="padding-top: 30px">
                                    <table class="table datatable" id="">
                        <thead>
                           <th>Username</th>
                           <th>Proof of Payment</th>
                        </thead>
                        <tbody>
                           @foreach($approved_deposits as $td)
                            <tr>
                                <td>{{ $td->user->username }}</td>
                                                           <td>
                                                               @if($td->pop != '' && pathinfo(asset('storage/'.$td->pop))['extension'] == 'pdf') 
                                        <a href="{{ asset('storage/'.$td->pop.'/'.pathinfo(asset('storage/'.$td->pop))['basename']) }}">Click to View</a>
                                        @elseif($td->pop != '' && pathinfo(asset('storage/'.$td->pop))['extension'] != 'pdf') 
                                        <a href="{{ asset('storage/'.$td->pop.'/'.pathinfo(asset('storage/'.$td->pop))['basename']) }}">Click to View</a>
                                      @else
                                       <img src="{{ asset('storage/'.$td->pop) }}" class="image img-rounded" width="200" data-high-res-src="{{ asset('storage/'.$td->pop) }}" alt="ID">
                                     @endif
                                                           </td>
                               
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                                  </div>
                                </div>

                                <div id="posted" class="tab-pane ">
                                  <div class="panel-body" style="padding-top: 30px">
                                    
                                  </div>
                                </div>

                            </div>   
                          </div>
                        </div>
                      </div>
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
            ModuleID: 5,
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
            
            window.location.href  = "{{ url('/deposit/bank-deps') }}";
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
            ModuleID: 5,
            Comment: Comment
        },
     })
     .done(function(res, status, xhr) {
         // Navigate to the list after succesful posting to the server
         if(xhr.status == 200) {
            window.location.href  = "{{ url('/deposit/bank-deps') }}";
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

