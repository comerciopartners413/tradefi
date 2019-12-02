@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img width="100" src="https://arkounting.com.ng/tradefiprocess/webapp/images/TFI Official Logo no background.jpg" alt="">
        @endcomponent
    @endslot

    {{-- Body --}}
    
     A Deposit of <b>{{ number_format($deposit->Amount, 2) }}</b> has been made on TradeFI by <b>{{ $deposit->user->profile->fullname }}</b>

    
    {{-- Subcopy --}}
   
@slot('subcopy')
    @component('mail::button', ['url' => url('/'), 'color' => 'blue'])
        Logon to TradeFI
    @endcomponent
@endslot

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
