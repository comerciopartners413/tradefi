@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="view-header">
                <div class="header-icon">
                    <i class="fa page-header-icon fa-user"></i>
                </div>
                <div class="header-title">
                    <h3>TradeFI Clients (Not Profiled)</h3>
                    <small>
                        TradeFI Clients not profiled
                    </small>
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

                                    <div class="actionBtn" style="margin:10px 0;">
                                      <div class="pull-left checkbox check-info" style="margin: 0; margin: 0;padding: 3px 20px;text-align: center;"><input type="checkbox" id="select-all">
                                        <label for="select-all" class="text-white">Select all </label>
                                      </div>
                                      <button class="approve-btn btn btn-sm btn-success">Send selected</button>
                                    </div>

                                    <table class="table datatable table-striped">
                                        <thead>
                                          <th></th>
                                          <th>S/N</th>
                                          <th>TradeFi ID No</th>
                                          <th>Client Name</th>
                                          <th>Registered Email Address</th>
                                          <th>Securities Account</th>
                                          {{-- <th>Status</th> --}}
                                          {{-- <th>Username</th>
                                          <th>Registered On</th>
                                          <th>Confirmed Registeration?</th>
                                          <th>Date Created</th> --}}
                                          <th>Actions</th>
                                        </thead>

                                        <tbody>
                                          @foreach($users as $key => $user)
                                          <tr>
                                            <td>
                                              <div class="checkbox check-info">
                                                <input type="checkbox" id="select-all-child-{{ $user->id }}" class="select-all-child" value="{{ $user->id }}" {{ ($user->uba_access)? 'checked="checked"' : '' }}>
                                                <label for="select-all-child-{{ $user->id }}" class="text-white"></label>
                                              </div>
                                            </td>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->profile->fullname ?? '--' }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->securities_account ?? '-' }}</td>
                                            {{-- <td>{!! ($user->securities_account)? '<span class="text-success">Profiled</span>' : '<span class="text-warning">Pending</span>' !!}</td> --}}
                                            {{-- <td>{{ $user->username }}</td>
                                            <td>{{ Carbon\Carbon::parse($user->profile->created_at)->DiffForHumans() }}</td>
                                            <td>{{ $user->confirmed ? 'Yes' : 'No' }}</td>
                                            <td>{{ $user->created_at->format('jS M, Y  g:i:a') }}</td> --}}
                                            <td>
                                                <a href="/admin/users/{{ $user->id }}" class="btn btn-warning"><i class="fa fa-eye"></i> View</a> &nbsp;
                                                {{--  <a href="#" class="btn btn-success activate-btn" data-user-id="{{ $user->id }}"><i class="fa fa-ok"></i> Activate</a> --}}
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