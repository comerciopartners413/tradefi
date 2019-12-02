@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img width="100" src="https://m.tradefi.ng/assets/images/logo-no-bg.jpg" alt="">
        @endcomponent
    @endslot 

    {{-- Body --}}
    
    <h3>{{ $fullname }} Just registered on TradeFI</h3>
    {{ $email }} 

    
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
