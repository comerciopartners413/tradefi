@extends('layouts.app')

@section('title')
  Confirm Data
@endsection

@section('content')

<div class="view-header">
  <div class="header-icon">
      <i class="pe page-header-icon pe-7s-note2"></i>
  </div>
  <div class="header-title">
    <h3>Confirm Uploaded Data</h3>
    <small>
      Check and verify data.
    </small>
  </div>
</div>

  <div class="panel panel-filled">
    <div class="panel-heading">
      <h3 class="panel-title">Confirm Price Upload</h3>
    </div>
    <div class="panel-body">
      @if (count($staging) > 0)
        <div class="pull-right">
          {{-- <a href="{{ url()->current() }}" class="btn btn-danger btn-lg">Cancel</a> --}}
          <a href="#" class="btn btn-success btn-cons btn-lg m-l-10" onclick="confirm2('Are you sure you want to confirm this data?', '', 'store_upload')">Confirm</a>
          <form class="hidden" id="store_upload" action="{{ route('post_confirm_upload') }}" method="post" onsubmit="$('#spinner').show()">
            {{ csrf_field() }}
          </form>
        </div>
      @endif
      <div class="clearfix"></div>
      <table class="table table-bordered">
        <thead>
          <th width="5%">Ref</th>
          {{-- <th width="15%">Maturity Date</th> --}}
          <th width="15%">Identifier</th>
          <th width="15%">Tenor To Maturity</th>
          <th width="15%">Amount Available</th>
          {{-- <th>Buy Rate</th>
          <th>Sell Rate</th> --}}
          <th>Buy Yield</th>
          <th>Sell Yield</th>
          <th>Initiator</th>
          <th>Upload Date</th>
        </thead>

        <tbody>
          @foreach ($staging as $stage)
            <tr>
              <td>{{ $stage->PriceUploadRef }}</td>
              {{-- <td>{{ $stage->MaturityDate }}</td> --}}
              <td>{{ $stage->SecurityIdentifier }}</td>
              <td>{{ $stage->TenorToMaturity }}</td>
              <td>{{ number_format($stage->AmountAvailable, 2) }}</td>
              <td>{{ number_format($stage->BuyRate, 2) }}</td>
              <td>{{ number_format($stage->SellRate, 2) }}</td>
              <td>{{ $stage->initiator->username ?? '--' }}</td>
              <td>{{ $stage->created_at->format('jS M Y - g:iA') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>


    </div>
  </div>

@endsection