@extends('layouts.app')

@section('title')

@endsection

@section('content')
<div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe page-header-icon pe-7s-user"></i>
                            </div>
                            <div class="header-title">
                                <h3 class="panel-title">Review Bio-Data Changes - <span class="text-warning">{{ $pending->user->profile->fullname }}</span></h3>
                                <small>
                               Approve/Reject user.
                            </small>
                            </div>
                        </div>
                    </div>
                </div>
  <div class="panel panel-filled">
    <div class="panel-body">


    {{-- <img src="{{ asset('images/avatars/'.($pending->user->avatar ?? 'default.png') ) }}" alt="" class="avatar inline-block" style="height:100px; width:100px;"> --}}

    <table class="table  table-striped">
      <thead>
        <tr>
          <th>Field</th>
          <th>Old Value</th>
          <th>New Value</th>
          <th>Action</th>

        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Photograph</td>
          <td>{!! '<a href="'. asset('storage/avatar/'.$user->avatar, null) .'">Click to View</a>' ?? '-' !!}

          </td>
          <td>{!! ($pending->avatar != $user->avatar)? '<a href="'. asset('storage/avatar/'.$pending->avatar, null) .'">Click to View</a>' : '<em class="text-muted">Unchanged</em>' !!}</td>
          <td></td>

        </tr>

        <tr>
          <td>Identification</td>
          <td>{!! '<a href="'. asset('storage/identification/'.$user->identification, null) .'">Click to View</a>' ?? '-' !!}

          </td>
          <td>{!! ($pending->identification != $user->identification)? '<a href="'. asset('storage/identification/'.$pending->identification, null) .'">Click to View</a>' : '<em class="text-muted">Unchanged</em>' !!}</td>
          <td></td>

        </tr>

        <tr>
          <td>Utility</td>
          <td>{!! '<a href="'. asset('storage/utility_bill/'.$user->utility_bill, null) .'">Click to View</a>' ?? '-' !!}

          </td>
          <td>{!! ($pending->utility_bill != $user->utility_bill)? '<a href="'. asset('storage/utility_bill/'.$pending->utility_bill, null) .'">Click to View</a>' : '<em class="text-muted">Unchanged</em>' !!}</td>
          
        </tr>
        <tr>
          <td>Username</td>
          <td>{{ $user->username ?? '-' }}</td>
          <td>{!! ($pending->username != $user->username)? '<span class="text-warning">'.$pending->username.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
          
        </tr>

        <tr>
          <td>Email Address</td>
          <td>{{ $user->email ?? '-' }}</td>
          <td>{!! ($pending->email != $user->email)? '<span class="text-warning">'.$pending->email.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
          
        </tr>
        
      </tbody>

      <tbody>

        <tr>
          <td>Firstname</td>
          <td>{{ $user->profile->firstname ?? '-' }}</td>
          <td>{!! ($profile_pending->firstname != $user->profile->firstname)? '<span class="text-warning">'.$profile_pending->firstname.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
          <td></td>

        </tr>

        <tr>
          <td>Lastname</td>
          <td>{{ $user->profile->lastname ?? '-' }}</td>
          <td>{!! ($profile_pending->lastname != $user->profile->lastname)? '<span class="text-warning">'.$profile_pending->lastname.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
          <td></td>

        </tr>

        <tr>
          <td>Phone</td>
          <td>{{ $user->profile->phone ?? '-' }}</td>
          <td>{!! ($profile_pending->phone != $user->profile->phone)? '<span class="text-warning">'.$profile_pending->phone.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
          <td></td>

        </tr>

        <tr>
          <td>D.O.B</td>
          <td>{{ $user->profile->dob ?? '-' }}</td>
          <td>{!! ($profile_pending->dob != $user->profile->dob)? '<span class="text-warning">'.$profile_pending->dob.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
          <td></td>

        </tr>

        <tr>
          <td>Gender</td>
          <td>{{ $user->profile->gender ?? '-' }}</td>
          <td>{!! ($profile_pending->gender != $user->profile->gender)? '<span class="text-warning">'.$profile_pending->gender.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
          <td></td>

        </tr>

        <tr>
          <td>Address</td>
          <td>{{ $user->profile->address ?? '-' }}</td>
          <td>{!! ($profile_pending->address != $user->profile->address)? '<span class="text-warning">'.$profile_pending->address.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
          <td></td>

        </tr>

        <tbody>
            <tr>
              <td>Kin Fullname</td>
              <td>{{ $user->profile->kin_fullname ?? '-' }}</td>
              <td>{!! ($profile_pending->kin_fullname != $user->profile->kin_fullname)? '<span class="text-warning">'.$profile_pending->kin_fullname.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
                <td></td>
            </tr>

            <tr>
              <td>Kin Address</td>
              <td>{{ $user->profile->kin_address ?? '-' }}</td>
              <td>{!! ($profile_pending->kin_address != $user->profile->kin_address)? '<span class="text-warning">'.$profile_pending->kin_address.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
              <td></td>
            </tr>

            <tr>
              <td>Kin Phone</td>
              <td>{{ $user->profile->kin_phone ?? '-' }}</td>
              <td>{!! ($profile_pending->kin_phone != $user->profile->kin_phone)? '<span class="text-warning">'.$profile_pending->kin_phone.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
              <td></td>

            </tr>

            <tr>
              <td>Relationship</td>
              <td>{{ $user->profile->kin_relationship ?? '-' }}</td>
              <td>{!! ($profile_pending->kin_relationship != $user->profile->kin_relationship)? '<span class="text-warning">'.$profile_pending->kin_relationship.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
              <td></td>
            </tr>
        </tbody>

        <tbody>
            <tr>
              <td>Income Bracket</td>
              <td>{{ $user->profile->income_bracket ?? '-' }}</td>
              <td>{!! ($profile_pending->income_bracket != $user->profile->income_bracket)? '<span class="text-warning">'.$profile_pending->income_bracket.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
              <td></td>
            </tr>

            <tr>
              <td>Trading Experience</td>
              <td>{{ $user->profile->trading_experience ?? '-' }}</td>
              <td>{!! ($profile_pending->trading_experience != $user->profile->trading_experience)? '<span class="text-warning">'.$profile_pending->trading_experience.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
              <td></td>
            </tr>
        </tbody>

      </tbody>
    </table>

    <div class="text-center" style="margin: auto">


      <form id="form_approve" class="form-inline" style="display: inline;" action="{{ url('users/approve/'. $pending->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
         <button type="submit" class="btn btn-success btn-cons btn-lg m-r-20">Approve</button>
      </form>
      <form id="form_reject" class="form-inline" style="display: inline;" action="{{ url('users/reject/'.$pending->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <button type="submit" class="btn btn-danger btn-cons btn-lg">Reject</button>
      </form>
    </div>
    </div>
  </div>
@endsection


@push('scripts')
<script src="{{ asset('js/imageviewer.min.js') }}"></script>
<script>
    // $(function(){
         $('.image').click(function () {
        var imgSrc = this.src,
            highResolutionImage = $(this).data('high-res-img');

        viewer.show(imgSrc, highResolutionImage);
    });

    // script to approve or reject username
    $('#approve-username').click(function(e) {
      e.preventDefault();

      var username = $(this).data('username');
        $.post('/api/approval_username/{{ $pending->id }}', {username: username}, function(data, textStatus, xhr) {
        if(data.status === true) {
          toastr.success(data.message);
        }
      });
    });

    $('#approve-firstname').click(function(e) {
      e.preventDefault();

      var firstname = $(this).data('firstname');
        $.post('/api/approval_firstname/{{ $pending->id }}', {firstname: firstname}, function(data, textStatus, xhr) {
        if(data.status === true) {
          toastr.success(data.message);
        }
      });
    });
     
    
    // })
</script>
@endpush
