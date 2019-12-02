<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
  {{-- <link rel="stylesheet" href="{{ asset('webapp/vendor/bootstrap/css/bootstrap.css') }}" /> --}}
  <link rel="stylesheet" href="webapp/vendor/bootstrap/css/bootstrap.css" />

  <style>
  .bold {
    font-weight: 600;
  }
  .mt15 {
    margin-top: 15px;
  }
  .mb15 {
    margin-bottom: 15px;
  }
  table th {
    vertical-align: top !important;
  }
  table td {
    font-size: 11px !important;
  }
  table th {
    font-size: 10px !important;
  }
  body {
    font-size: 12px;
    /* background-image: url(/images/site/letter-head.jpg);
    background-position: center;
    background-size: contain;
    width: 100%; */
  }
  </style>
</head>
<body>
    <div class="text-right" style="margin-bottom: 10px;">
      {{-- <img src="assets/images/logo-no-bg.jpg" alt="TradeFi Logo" width="150px"> --}}
      <img src="images/site/comercio-logo.jpg" alt="Comercio Logo" width="130px">
    </div>


    <div style="font-size: 12px">
      <div>{{ Carbon::parse($date)->format('d F Y') }}</div>
      <p>
        @php
          echo nl2br("
            The Head
            Global Investor Services
            United Bank for Africa
            UBA House
            57, Marina 
            Lagos
          ");
        @endphp
      </p>
      <p class="mt15">Attention: Taiwo Sonola</p>
    </div>


    @yield('content')

    <br>
    <p>Yours Faithfully</p>
    <br>

    <div class="clearfix">
      <div class="pull-left">
        <span class="bold">Authorized Signatory</span>
        <div class="mt15" style="margin-bottom: 10px;">
          {{-- <img src="{{ asset('images/site/test-sig-1.png') }}" alt="Signature" width="200px"> --}}
          <img src="images/site/test-sig-1.png" alt="Signature" width="190px">
        </div>
      </div>
      <div class="pull-right bold">
        <span class="bold">Authorized Signatory</span>
        <div class="mt15" style="margin-bottom: 10px;">
          {{-- <img src="{{ asset('images/site/test-sig-2.png') }}" alt="Signature" width="200px"> --}}
          <img src="images/site/test-sig-2.png" alt="Signature" width="190px">
        </div>
      </div>
    </div>

    {{-- <br><br> --}}

    <div>
      <img src="images/site/letter-footer.jpg" alt="Letter Footer" width="100%" style="position:fixed; bottom:60px">
    </div>

</body>
</html>