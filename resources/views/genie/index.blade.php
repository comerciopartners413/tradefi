@extends('layouts.app')
@section('content')
<genie-component bot_image="{{ asset('webapp/images/genie1.png') }}" user-id="{{ auth()->user()->id }}"></genie-component>
@endsection