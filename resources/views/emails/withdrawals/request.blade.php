@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img width="100" src="https://arkounting.com.ng/tradefiprocess/webapp/images/TFI Official Logo no background.jpg" alt="">
        @endcomponent
    @endslot

    {{-- Body --}}
    
    <h3>{{ $withdrawals->user->profile->fullname  }} Just request a withdrawal amount of {{ number_format($withdrawals->Amount, 2) }}</h3>
    Username: {{ $withdrawals->user->username }} 

    
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
