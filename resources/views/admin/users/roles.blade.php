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
                                <h3>Manage admin roles</h3>
                                <small>
                               create roles.
                            </small>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="panel panel-filled">
                    <div class="panel-body">
                    <form action="/roles" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="email">Role</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter role">
                            </div>
                        </div>


                        <button class="btn btn-warning">Create Role Type</button>

                    </form>
                </div>
                </div>

                <div class="panel panel-filled">
                    <div class="panel-body">
                        <table class="table datatable">
                        <thead>
                            {{-- <th>User/email</th> --}}
                            <th>Role</th>
                        </thead>

                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                {{-- <td>{{ !is_null($user->site_role) ? $user->site_role->name : 'N\A' }}</td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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