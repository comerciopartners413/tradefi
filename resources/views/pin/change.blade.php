@extends('layouts.app')
@section('content')
<div class="container-center animated slideInDown" style="margin-top: 10px;">


            <div class="view-header">
                <div class="header-icon">
                    <i class="pe page-header-icon pe-7s-unlock"></i>
                </div>
                <div class="header-title">
                    <h3>Change Trading Pin</h3>
                    <small>
                        A default pin was created for you when you registered. Kindly enter a new pin to make it more private. You need to save this pin somewhere safe to execute transactions.

                    </small>
                </div>
            </div>

            <div class="panel panel-filled">
                <div class="panel-body">
                	@include('errors.list')
                    <form action="{{ route('change-pin.store') }}" method="POST" id="loginForm" novalidate="" >
                    	{{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label" for="username">Enter new 4-digit pin</label>
                            <input type="password" placeholder="****" title="Please enter you username" required="" value="" name="trading_pin" id="trading_pin" class="form-control" oldautocomplete="remove" autocomplete="off" required>
                            {{-- <span class="help-block small">You will use this to execute trades</span> --}}
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password">Confirm Pin</label>
                            <input type="password" title="Please enter your password" placeholder="****" required="" value="" name="trading_pin_confirmation" id="trading_pin_confirmation" class="form-control" required>
                            {{-- <span class="help-block small">Your strong password</span> --}}
                        </div>
                        <div>
                            <button type="submit" class="btn btn-accent">Submit</button>
                            <button type="reset" class="btn btn-default">Clear</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
@endsection