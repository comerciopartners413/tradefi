@extends('layouts.app')
@push('styles')
<style>
    
    hr {
        border-top: 1px solid rgba(239, 222, 205, 0.25);
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>
@endpush
@section('content')

<div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-user"></i>
                        </div>
                        <div class="header-title">
                            <h3>User Profile</h3>
                            <small>
                                {{ $user->profile->fullname }}'s Profile
                            </small>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>


            <div class="panel panel-filled">
                <div class="panel-heading">
                <span class="pull-left" style="color: rgb(238, 238, 238); font-size: 20px;">
                    {{ '@' . $user->username }}'s Profile
                </span>

                <span class="pull-right">
                   <a class="btn btn-warning" href="/forum">Back to topics</a>
                </span>
                <div class="clearfix"></div> <hr>
            </div>

                <div class="panel-body">
                   {{--  <img src="{{ Config::get('s3.buckets.images') . '/avatars/' . ($user->hasCustomAvatar() ?  $user->avatar : 'avatar-blank.png') }}" class="img-thumbnail pull-left" width="100" height="100" alt="{{ $user->name }}-avatar"> --}}
                    @if (Auth::check() && Auth::user()->id === $user->id)
                        <a href="{{ route('user.profile.settings.index', Auth::user()->profile->fullname) }}" class="pull-right"><span class="glyphicon glyphicon-pencil"></span></a>
                    @endif
                    <strong>Username:</strong> {{ $user->username }}
                    <br /> <hr>
                    <strong>Account:</strong> {{ ucfirst($user->role) }}
                    @if (Auth::check() && Auth::user()->isElevated() || Auth::check() && Auth::user()->id === $user->id)
                        <br />
                        <strong>Email:</strong> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        @if (Auth::check() && Auth::user()->id === $user->id)
                            <span class="text-muted"><span class="glyphicon glyphicon-exclamation-sign" title="Your email address is only visible to you and elevated account users."></span></span>
                        @endif
                    @endif
                    <br /> <hr>
                    <strong>Registered:</strong> {{ Carbon\Carbon::createFromTimeStamp(strtotime($user->created_at))->diffForHumans() }}
                    <br /> <hr>
                    <strong>Last Activity:</strong> {{ Carbon\Carbon::createFromTimeStamp(strtotime($user->last_activity))->diffForHumans() }}
                    <br /> <hr>
                    <strong>Contribution</strong>
                    <br /> <hr>
                    Created <span class="badge">{{ count($user->topics) }}</span> topic{{ (count($user->topics) > 1) ? 's' : '' }}.
                    <br /> <hr>
                    Created <span class="badge">{{ count($user->posts) }}</span> post{{ (count($user->posts) > 1) ? 's' : '' }}.
                </div>
    </div>
@endsection
