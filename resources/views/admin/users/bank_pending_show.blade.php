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
                                <h3 class="panel-title">Review Bank Information Changes - <span class="text-warning">{{ $bank_detail->profile->fullname }}</span></h3>
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
          
        </tr>
      </thead>

        <tbody>
            <tr>
              <td>Bank</td>
              <td>{{ \TradefiUBA\Bank::find($bank_detail->bank_id)->name ?? '-' }}</td>
              <td>{!! ($bank_details_pending->bank_id ?? null != $bank_detail->bank_id ?? '-' )? '<span class="text-warning">'. \TradefiUBA\Bank::find($bank_details_pending->bank_id)->name.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
              
            </tr>

            <tr>
              <td>Account Number</td>
              <td>{{ $bank_detail->account_number ?? '-' }}</td>
              <td>{!! ($bank_details_pending->account_number != $bank_detail->account_number)? '<span class="text-warning">'.$bank_details_pending->account_number.'</span>' : '<em class="text-muted">Unchanged</em>' !!}</td>
              
            </tr>
        </tbody>
        
      </tbody>
    </table>

    <div class="text-center" style="margin: auto">
     

      <form id="form_approve" class="form-inline" style="display: inline;" action="{{ url('bank_details/approve/'. $bank_detail->profile->user_id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
         <button type="submit" class="btn btn-success btn-cons btn-lg m-r-20">Approve</button>
      </form>
      <form id="form_reject" class="form-inline" style="display: inline;" action="{{ url('bank_details/reject/'.$bank_detail->profile->user_id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <button type="submit" class="btn btn-danger btn-cons btn-lg">Reject</button>
      </form>
    </div>
    </div>
  </div>
@endsection
