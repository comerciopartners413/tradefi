@extends('instructions.template')

@section('title')
  FOP Instruction TradeFi {{ $date }} {{ ($date == date('Y-m-d'))? ' - '.date('H:iA') : '' }}
@endsection

@section('content')

  <div class="text-center bold mt15 mb15">SECURITIES TRANSFER</div>

  @if (count($trades_buy) > 0)        
    <p>Kindly transfer instrument purchased on {{ Carbon::parse($date)->format('jS F Y') }} free of payment to the beneficiaries below from CPAM TradeFi Client account (xxxxxxxxxxx).</p>
    
    <br>

    <table class="table table-bordered table-condensed" class="mt15 mb15">
      <thead>
        <tr>
          <th>S/N</th>
          <th width="15%">Beneficiary Securities Account Number</th>
          <th width="20%">Beneficiary Name</th>
          {{-- <th width="15%">Trade Date</th> --}}
          <th>Settlement Date</th>
          <th>Tenor</th>
          <th>Maturity Date</th>
          <th>Face Value</th>
          {{-- <th>Rate</th>
          <th>Consideration</th> --}}
        </tr>
      </thead>
      <tbody>
        @foreach ($trades_buy as $key => $trade)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $trade->securities_account }}</td>
            <td>{{ $trade->Beneficiary }}</td>
            {{-- <td>{{ Carbon::parse($trade->TradeDate)->format('d-M-Y') }}</td> --}}
            <td>{{ Carbon::parse($trade->SettlementDate)->format('d-M-Y') }}</td>
            <td>{{ $trade->Tenor }}</td>
            <td>{{ Carbon::parse($trade->MaturityDate)->format('d-M-Y') }}</td>
            <td>{{ number_format($trade->FaceValue) }}</td>
            {{-- <td>{{ $trade->ProductID }}</td> --}}
            {{-- <td>{{ ($trade->ProductID == '1')? number_format($trade->Yield, 2) : ( ($trade->ProductID == '2')? number_format($trade->Yield * 100, 2) : '-' ) }}</td>
            <td>{{ number_format($trade->DiscountAmount, 2) }}</td> --}}
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif

  <hr>

  {{-- Sales --}}

  @if (count($trades_sell) > 0)    
    <p>Kindly transfer instrument sold {{ Carbon::parse($date)->format('jS F Y') }} free of payment to CPAM TradeFi Client account (xxxxxxxxxxx).</p>
    
    <br>

    <table class="table table-bordered" class="mt15 mb15">
      <thead>
        <tr>
          <th>S/N</th>
          <th width="15%">Sender Securities Account Number</th>
          <th width="20%">Sender Name</th>
          {{-- <th width="15%">Trade Date</th> --}}
          <th>Settlement Date</th>
          <th>Tenor</th>
          <th>Maturity Date</th>
          <th>Face Value</th>
          {{-- <th>Rate</th> --}}
          {{-- <th>Consideration</th> --}}
        </tr>
      </thead>
      <tbody>
        @foreach ($trades_sell as $key => $trade)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $trade->securities_account }}</td>
            <td>{{ $trade->Beneficiary }}</td>
            {{-- <td>{{ Carbon::parse($trade->TradeDate)->format('d-M-Y') }}</td> --}}
            <td>{{ Carbon::parse($trade->SettlementDate)->format('d-M-Y') }}</td>
            <td>{{ $trade->Tenor }}</td>
            <td>{{ Carbon::parse($trade->MaturityDate)->format('d-M-Y') }}</td>
            <td>{{ number_format($trade->FaceValue) }}</td>
            {{-- <td>{{ ($trade->ProductID == '1')? number_format($trade->Yield, 4) : ( ($trade->ProductID == '2')? number_format($trade->Yield * 100, 4) : '-' ) }}</td>
            <td>{{ number_format($trade->DiscountAmount, 2) }}</td> --}}
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
  
@endsection