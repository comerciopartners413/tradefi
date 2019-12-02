@extends('layouts.app')

@section('content')
            <div class="panel panel-filled">
                <div class="panel-heading">Messages with <a href="{{ route('user.profile.index', $recipient) }}">{{ '@' . $recipient->name }}</a></div>

                <div class="panel-body">
                    <messaging recipient="{{ $recipient }}"></messaging>
                </div>
            </div>
@endsection
