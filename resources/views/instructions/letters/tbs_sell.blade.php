@extends('instructions.template')

@section('title')
  TBills Sale TradeFi {{ $date }} {{ ($date == date('Y-m-d'))? ' - '.date('H:iA') : '' }}
@endsection

@section('content')

    <div class="text-center bold mt15 mb15">SALE OF TREASURY BILLS</div>

    <p>Please take this as our instruction to settle the following trade(s)</p>
    
    <br>

    <table class="table table-bordered" class="mt15 mb15">
      <thead>
        <tr>
          <th>Counterparty</th>
          <th width="15%">Trade Date</th>
          <th>Settlement Date</th>
          <th>Tenor</th>
          <th>Maturity Date</th>
          <th>Face Value</th>
          <th>Rate</th>
          <th>Consideration</th>
          <th>Background details (where to sell from)</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($trades as $trade)
          <tr>
            <td>UBA</td>
            <td>{{ Carbon::parse($trade->TradeDate)->format('d-M-Y') }}</td>
            <td>{{ Carbon::parse($trade->SettlementDate)->format('d-M-Y') }}</td>
            <td>{{ $trade->Tenor }} days</td>
            <td>{{ Carbon::parse($trade->MaturityDate)->format('d-M-Y') }}</td>
            <td>{{ number_format($trade->FaceValue) }}</td>
            {{-- <td>{{ number_format($trade->Yield * 100, 4) }}</td> --}}
            <td>{{ number_format($trade->DiscountRate, 4) }}</td>
            <td>{{ number_format($trade->DiscountAmount, 2) }}</td>
            <td></td>
          </tr>
        @endforeach
      </tbody>
    </table>

    @endsection