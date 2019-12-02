@extends('layouts.app')
@section('content')
               <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe page-header-icon pe-7s-users"></i>
                            </div>
                            <div class="header-title">
                                <h3>Approve User Records</h3>
                                <small>
                               Approve users.
                            </small>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="panel panel-filled">
                    <div class="panel-body">
                        <div class="">
                            <h4>#Biodata</h4>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </thead>


                                <tbody>
                                    @foreach($pending_updates as $update)
                                    <tr>
                                        <td>{{ $update->user->username }}</td>
                                        <td>{{ $update->user->profile->fullname }}</td>
                                        <td>{{ $update->created_at->format('jS M, Y  g:i:a') }}</td>
                                        <td><a href="/users/approve/{{ $update->user_id }}" class="btn btn-xs btn-warning">View</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table> <hr>

                            <h4>#Bank Details</h4>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </thead>


                                <tbody>
                                    @foreach($pending_bank_detail_updates as $update)
                                    <tr>
                                        <td>{{ $update->profile->user->username }}</td>
                                        <td>{{ $update->profile->fullname }}</td>
                                        <td>{{ $update->created_at->format('jS M, Y  g:i:a') }}</td>
                                        <td><a href="/bank_details/list/{{ $update->profile->user_id }}" class="btn btn-xs btn-warning">View</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    // $('.datatable').DataTable({});


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.activate-btn').click(function(e) {
        e.preventDefault();
        var userID =  $(this).data('userId');

        var that = $(this);

        $.ajax({
            url: '/admin/users/activate/'+ userID,
          type: 'POST',
          data: {userID: userID},
          beforeSend: function(){
           that.text('Loading...');
          }
        })
        .done(function() {
           that.text('Activate');
           // remove node
           that.closest('tr').remove();
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });


    });
</script>


<script>

</script>
@endpush