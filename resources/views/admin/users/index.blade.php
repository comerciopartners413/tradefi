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
                                <h3>TradeFI Clients</h3>
                                <small>
                               Activate users to start trading
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
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#pending" aria-expanded="true">Pending <label class="badge badge-danger">{{ count($users) }}</label></a></li>
                                <li class=""><a data-toggle="tab" href="#activated" aria-expanded="false">Activated <label class="badge badge-danger">{{ count($activated_users) }}</label></a></li>

                            </ul>
                            <div class="tab-content">
                                <div id="pending" class="tab-pane active">
                                    <div class="panel-body" style="padding-top: 30px">
                                        <div class="row row-sm-height">
                                            <div class="col-sm-12 col-sm-height col-middle">
                                                <table class="table datatable table-striped">
                                                    <thead>
                                                        <th>Fullname</th>
                                                        <th>Username</th>
                                                        <th>Registered On</th>
                                                        <th>Confirmed Registeration?</th>
                                                        <th>Date Created</th>
                                                        <th>
                                                            Actions
                                                        </th>
                                                        <th width="10%"></th>
                                                    </thead>

                                                    <tbody>
                                                        @foreach($users as $user)
                                                        <tr>
                                                            <td>{{ $user->profile->fullname }}</td>
                                                            <td>{{ $user->username }}</td>
                                                            <td>{{ Carbon\Carbon::parse($user->profile->created_at)->DiffForHumans() }}</td>
                                                            <td>{{ $user->confirmed ? 'Yes' : 'No' }}</td>
                                                            <td>{{ $user->created_at->format('jS M, Y  g:i:a') }}</td>
                                                            <td>
                                                                <a href="/admin/users/{{ $user->id }}" class="btn btn-warning"><i class="fa fa-eye"></i> View</a> &nbsp;
                                                               {{--  <a href="#" class="btn btn-success activate-btn" data-user-id="{{ $user->id }}"><i class="fa fa-ok"></i> Activate</a> --}}
                                                            </td>
                                                            <td>
                                                              <select id="" class="form-control text-uppercase select_company" style="{{ ($user->company_id > 1)? 'border:1px solid green' : '' }}" data-init-plugin="select2">
                                                                <option value="">None</option>
                                                                @foreach ($companies as $company)
                                                                  <option value="{{ $company->id }}" class="text-uppercase" {{ ($user->company_id == $company->id)? 'selected' : '' }}>{{ $company->name }}</option>
                                                                @endforeach
                                                              </select>
                                                              <input type="hidden" class="user_id" value="{{ $user->id }}">
                                                              <button class="btn btn-sm btn-success btn-block save_company" style="margin-top:5px; display:none">Save</button>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="activated" class="tab-pane">
                                    <div class="panel-body" style="padding-top: 30px">
                                        <div class="row row-sm-height">
                                            <div class="col-sm-12 col-sm-height col-middle">
                                                 <table class="table datatable table-striped">
                                                    <thead>
                                                      <th>Fullname</th>
                                                      <th>Username</th>
                                                      <th>Registered On</th>
                                                      <th>Confirmed Registeration?</th>
                                                      <th>
                                                        Actions
                                                      </th>
                                                      <th width="10%"></th>
                                                    </thead>

                                                    <tbody>
                                                        @foreach($activated_users as $user)
                                                        <tr>
                                                            
                                                            <td>{{ $user->profile->fullname }}</td>
                                                            <td>{{ $user->username }}</td>
                                                            <td>{{ Carbon\Carbon::parse($user->profile->created_at)->DiffForHumans() }}</td>
                                                            <td>{{ $user->confirmed ? 'Yes' : 'No' }}</td>
                                                            <td>
                                                                <a href="/admin/users/{{ $user->id }}" class="btn btn-warning"><i class="fa fa-eye"></i> View</a> &nbsp;
                                                                {{-- <a href="#" class="btn btn-success activate-btn" data-user-id="{{ $user->id }}"><i class="fa fa-ok"></i> Activate</a> --}}
                                                            </td>
                                                            <td>
                                                              <select id="" class="form-control text-uppercase select_company" style="{{ ($user->company_id > 1)? 'border:1px solid green' : '' }}" data-init-plugin="select2">
                                                                <option value="">None</option>
                                                                @foreach ($companies as $company)
                                                                  <option value="{{ $company->id }}" class="text-uppercase" {{ ($user->company_id == $company->id)? 'selected' : '' }}>{{ $company->name }}</option>
                                                                @endforeach
                                                              </select>
                                                              <input type="hidden" class="user_id" value="{{ $user->id }}">
                                                              <button class="btn btn-sm btn-success btn-block save_company" style="margin-top:5px; display:none">Save</button>
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
  $(document).on('change', 'select.select_company', (e) => {
    // console.log($(e.target).val());
    let scope = $(e.target).closest('td');
    
    let company_id = $(e.target).val();
    let user_id = $(e.target).closest('td').find('input.user_id').val();
    if (company_id != '') {
      scope.find('.save_company').show();
    } else {
      scope.find('.save_company').hide();
    }
  });

  $('body').on('click', '.save_company', (e) => {
    let scope = $(e.target).closest('td');
    let btn = scope.find('.save_company').html('<i class="fa fa-spinner fa-pulse"></i>');
    let company_id = scope.find('select.select_company').val();
    let user_id = scope.find('input.user_id').val();
    if (company_id != '') {
      $.post('/admin/users/save_company', {user_id, company_id, _token: '{{ csrf_token() }}'}, function(data, status){
        console.log(data);
        scope.find('.save_company').text('Save');
        scope.find('.save_company').hide();
        toastr.success('Applied successfully.');
      });
    }
  })
</script>
@endpush