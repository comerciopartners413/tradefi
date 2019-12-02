@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="view-header">
                <div class="header-icon">
                    <i class="fa page-header-icon fa-user"></i>
                </div>
                <div class="header-title">
                    <h3>Pending Client Accounts</h3>
                    <small>Client accounts awaiting profiling</small>
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

                                    <div style="margin-bottom: 20px">
                                        <a href="{{ route('dl_pending_accounts') }}" class="btn btn-success"><i class="fa fa-download m-r-xs"></i> Download Pending Accounts</a>
                                        <a data-toggle="modal" data-target="#upload_accounts" class="btn btn-success" style="margin-left: 10px"><i class="fa fa-upload m-r-xs"></i> Upload Profiled Accounts</a>
                                    </div>

                                    <table class="table datatable table-striped">
                                        <thead>
                                          <th>S/N</th>
                                          <th>TradeFi ID No</th>
                                          <th>Client Name</th>
                                          <th>Registered Email Address</th>
                                          <th>Securities Account</th>
                                          {{-- <th>Username</th>
                                          <th>Registered On</th>
                                          <th>Confirmed Registeration?</th>
                                          <th>Date Created</th> --}}
                                          <th>Actions</th>
                                        </thead>

                                        <tbody>
                                          @foreach($users as $key => $user)
                                          <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $user->id }}</td>
                                            <td>
                                              <a href="/admin/users/{{ $user->id }}">
                                              {{ $user->profile->fullname ?? '--' }}
                                              </a>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->securities_account ?? '-' }}</td>
                                            {{-- <td>{{ $user->username }}</td>
                                            <td>{{ Carbon\Carbon::parse($user->profile->created_at)->DiffForHumans() }}</td>
                                            <td>{{ $user->confirmed ? 'Yes' : 'No' }}</td>
                                            <td>{{ $user->created_at->format('jS M, Y  g:i:a') }}</td> --}}
                                            <td>
                                                <a href="/admin/users/{{ $user->id }}" class="btn btn-warning"><i class="fa fa-eye"></i> View</a>
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


    
    
    <div class="modal fade" id="upload_accounts">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Upload Profiled Accounts</h4>
          </div>
          <div class="modal-body">

            <form action="{{ route('ul_profiled_accounts') }}" method="POST" role="form" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="">Upload Excel File</label>
                <input type="file" name="users_file" class="form-control" placeholder="Upload File" required>
              </div>
              <button type="submit" class="btn btn-primary">Upload</button>
            </form>

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