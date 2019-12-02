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
                                <h3>Manage admin users</h3>
                                <small>
                               create and assign roles to users.
                            </small>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="panel panel-filled">
                    <div class="panel-body">
                    <form action="/users/create-admin" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="email">Firstname</label>
                                <input type="text" class="form-control" name="firstname" placeholder="Enter firstname" required>
                            </div>


                            <div class="form-group col-sm-6">
                                <label for="email">Lastname</label>
                                <input type="lastname" class="form-control" name="lastname" placeholder="Enter lastname" required>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="email">Email Address</label>
                                <input class="form-control" name="email" placeholder="email" required>
                            </div>

                            <div class="col-sm-6 form-group">
                                <label for="">Roles</label>
                                <select name="role[]"  class="form-control select2_demo_1" multiple id="role" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if (auth()->user()->company_id == '1')
                          <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="">Company</label>
                                <select name="company_id"  class="form-control">
                                  <option value="">Select company</option>
                                  @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ strtoupper($company->name) }}</option>
                                  @endforeach
                                </select>
                            </div>
                          </div>
                        @endif


                        {{-- <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="****">
                            </div>


                            <div class="form-group col-sm-6">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="****">
                            </div>
                        </div> --}}

                        <button class="btn btn-warning">Send Invite</button>

                    </form>
                </div>
                </div>

                <div class="panel panel-filled">
                    <div class="panel-body">
                        <table class="table datatable">
                        <thead>
                            <th>User/email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            @foreach($admin_users as $user)
                            <tr>
                                <td>{{ $user->email }}</td>
                                <td class="text-warning">{{ !is_null($user->roles) ? $user->roles->pluck('display_name')->implode(', ') : 'N\A' }}</td>
                                <td>
                                    <form action="/users/{{ $user->id}}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
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