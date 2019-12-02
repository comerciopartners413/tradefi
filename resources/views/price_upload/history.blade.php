@extends('layouts.app')

@section('title')
  Approve Price Upload
@endsection

@section('content')
  <div class="view-header">
    <div class="header-icon">
        <i class="pe page-header-icon pe-7s-clock"></i>
    </div>
    <div class="header-title">
      <h3>Price Upload History</h3>
      <small>
        A Log of prices uploaded to the system.
      </small>
    </div>
  </div>

  <div class="panel panel-filled">
    <div class="panel-heading">
      <h3 class="panel-title">Price Upload History</h3>
    </div>
    <div class="panel-body">

      {{-- @if (count($prices) > 0)
        <div class="pull-right">
          <a href="#" class="btn btn-success btn-cons btn-lg m-l-10" onclick="confirm2('Are you sure you want to approve this data?', '', 'approve_upload')">Approve All</a>
          <form class="hidden" id="approve_upload" action="{{ route('price_upload.post_first_approval') }}" method="post" onsubmit="$('#spinner').show()">
            {{ csrf_field() }}
          </form>
        </div>
      @endif --}}
      <div class="clearfix"></div>
      <table class="table table-bordered">
        <thead>
          <th width="5%">Ref</th>
          <th width="15%">Maturity Date</th>
          <th width="15%">Identifier</th>
          <th width="15%">Tenor To Maturity</th>
          <th width="15%">Amount Available</th>
          <th>Buy Rate</th>
          <th>Sell Rate</th>
          <th>Initiator</th>
          <th>Upload Date</th>
          <th>Approver</th>
          <th>Approval Date</th>
        </thead>

        <tbody>
          @foreach ($prices as $price)
            <tr>
              <td>{{ $price->PriceUploadRef }}</td>
              <td>{{ $price->MaturityDate }}</td>
              <td>{{ $price->SecuritiesIdentifier }}</td>
              <td>{{ $price->TenorToMaturity }}</td>
              <td>{{ number_format($price->AmountAvailable, 2) }}</td>
              <td>{{ number_format($price->BuyRate, 2) }}</td>
              <td>{{ number_format($price->SellRate, 2) }}</td>
              <td>{{ $price->initiator->username ?? '--' }}</td>
              <td>{{ $price->created_at->format('jS M Y - g:iA') }}</td>
              <td>{{ $price->approver->username ?? '--' }}</td>
              <td>{{ $price->ApprovedDate->format('jS M Y - g:iA') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>


    </div>
  </div>

@endsection