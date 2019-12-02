@extends('layouts.app')
@section('content')
<trade-room-activated-notification :user="{{ auth()->user()->id }}"></trade-room-activated-notification>
<div class="text-center" style="margin-top: 50px">
	<h2>Your Account has not been activated</h2>
	<p>Activation can take up to 48 hrs.</p>
	<a href="/ticket" class="btn btn-warning">Open Ticket</a>
</div>
@endsection