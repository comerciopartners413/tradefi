@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="view-header">
                <div class="header-icon">
                    <i class="fa page-header-icon pe-7s-hourglass"></i>
                </div>
                <div class="header-title">
                    <h3>Audit Trail</h3>
                    <small>Audit trails and logs.</small>
                </div>
            </div>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="tabs-container">
                {{-- <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#pending" aria-expanded="true">Pending <label class="badge badge-danger">{{ count($users) }}</label></a></li>
                    <li class=""><a data-toggle="tab" href="#activated" aria-expanded="false">Activated <label class="badge badge-danger">{{ count($activated_users) }}</label></a></li>

                </ul> --}}
                <div class="tab-content">
                    <div id="pending" class="tab-pane active">
                        <div class="panel-body" style="padding-top: 30px">
                            <div class="row row-sm-height">
                                <div class="col-sm-12 col-sm-height col-middle">

                                    <table class="table datatable table-striped table-bordered">
                                        <thead>
                                          <th>Ref</th>
                                          <th>User</th>
                                          <th>Page / Action</th>
                                          <th>Description</th>
                                          <th>IP</th>
                                          <th width="15%">Browser</th>
                                          <th>Date / Time</th>
                                          <th>Actions</th>
                                        </thead>

                                        <tbody>
                                          @foreach($footprints as $key => $print)
                                          <tr>
                                            <td>{{ $print->EventRef }}</td>
                                            <td>{{ $print->user->username ?? '-' }}</td>
                                            <td>{{ $print->EventPage }}</td>
                                            <td>{{ $print->EventDetails }}</td>
                                            <td>{{ $print->EventIp }}</td>
                                            <td>{{ str_limit($print->EventBrowser, 30) }}</td>
                                            <td>{{ $print->created_at->format('jS M Y g:iA') }}</td>
                                            <td></td>
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
    </div>
@endsection

@push('scripts')
<script>
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
 
 if(checked_trades_array.length > 0) {
   var confirm = window.confirm('Are You sure you want to send these users to UBA?');
   if(confirm){
      // var Comment = prompt("Enter Approval Comment");
      $.ajax({
          url: '/send_onboarded',
          type: 'POST',
          data: {
              _token: '{{ csrf_token() }}',
              selected_ids: checked_trades_array,
              // ModuleID: 36,
              // Comment: Comment
          },
      })
      .done(function(res, status, xhr) {
          // Navigate to the list after succesful posting to the server
          if(xhr.status == 200) {
              toastr.success('The selected users were sent successfully')
              // setTimeout(function(){
              //     window.location.href  = "{{ route('price_upload.history') }}";
              // }, 1000)
          } else {
              toastr.error('approval failed');
              return false
          }
          
      })
      .fail(function() {
          console.log("error");
      });
    }
  }
  else if(checked_trades_array.length == 0){
    toastr.info('Nothing selected');
  }
 
 
});
</script>
@endpush