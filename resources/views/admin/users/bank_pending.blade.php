@extends('layouts.app')
@section('content')
               <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="fa page-header-icon fa-user"></i>
                            </div>
                            <div class="header-title">
                                <h3>Approve User Records</h3>
                                <small>
                               Approve users.
                            </small>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>



                <h4>Banking Details</h4>
                <div class="row">
                    <table class="table datatable">
                        <thead>
                            <th>Username</th>
                            <th>Action</th>
                        </thead>


                        <tbody>
                            {{-- @foreach($banking_details as $update) --}}
                            <tr>
                                <td>{{ $banking_details->profile->user->username }}</td>
                                <td><a href="/bank_details/approve/{{ $banking_details->profile->user->id }}" class="btn btn-warning">View</a></td>
                            </tr>
                            {{-- @endforeach --}}
                        </tbody>
                    </table>
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