@extends('instructions.template')

@section('title')
  FGNBonds Purchase TradeFi {{ $date }} {{ ($date == date('Y-m-d'))? ' - '.date('H:iA') : '' }}
@endsection

@section('content')
  <div class="text-center bold mt15 mb15">PURCHASE OF FGN BONDS</div>

  <p>Please take this as our instruction to settle the following trade(s)</p>

  <br>

  <table class="table table-bordered" class="mt15 mb15">
    <thead>
      <tr>
        <th>S/N</th>
        <th>Counterparty</th>
        <th width="15%">Trade Date</th>
        <th>Settlement Date</th>
        <th>Tenor</th>
        <th>Maturity Date</th>
        {{-- <th>Face Value</th> --}}
        <th>Yield</th>
        <th>Clean Price</th>
        <th>Dirty Price</th>
        <th>Consideration</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($trades as $key => $trade)
        <tr>
          <td>{{ $key + 1 }}</td>
          <td>UBA</td>
          <td>{{ Carbon::parse($trade->TradeDate)->format('d-M-Y') }}</td>
          <td>{{ Carbon::parse($trade->SettlementDate)->format('d-M-Y') }}</td>
          <td>{{ $trade->Tenor }} days</td>
          <td>{{ Carbon::parse($trade->MaturityDate)->format('d-M-Y') }}</td>
          {{-- <td>{{ number_format($trade->FaceValue) }}</td> --}}
          <td>{{ number_format($trade->Yield, 4) }}</td>
          {{-- <td>{{ number_format($trade->DiscountRate, 4) }}</td> --}}
          <th>{{ number_format($trade->CleanPrice, 4) }}</th>
          <th>{{ number_format($trade->DirtyPrice, 4) }}</th>
          <td>{{ number_format($trade->DiscountAmount, 2) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection