@extends('layouts.app')
@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">

<style>
    .modal-dialog {
        overflow-y: scroll;
    }
    input.cropit-image-input {
      visibility: hidden;
    }

    #image-cropper {
            display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #image-cropper [type=range] {
        -webkit-appearance: none;
        background: #494b54;
        height: 10px;
        border-radius: 5px;
        outline: 0;
    }

    .cropit-preview {
        width: 150px;
        height: 150px;
        margin: 20px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 1px solid rgba(239, 222, 205, 0.4);
        flex-grow: 0;
    }

    .cropit-preview i {
            font-size: 50px;
        color: #d8c8b9;
    }

    .cropit-preview-image-container {
        border-radius: 50%;
    }

    .image-controls {
        margin-left: 25px;
        flex-grow: 1
    }

    .range-container {
            display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0;
        width: 70%;
    }

    span.before {
        font-size: 20px;
        color:rgba(239, 222, 205, 0.6);
        margin-right: 20px;
    }
    span.after {
        font-size: 30px;
        color:rgba(239, 222, 205, 0.6);
        margin-left: 20px;
    }
</style>
@endpush
@section('content')
<div class="container-fluid">
                <div class="row m-t-sm">

                    <div class="col-md-12">
                        <div class="panel panel-filled">

                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="media">
                                            @if(auth()->user()->hasCustomAvatar())
                                            <img src="{{ asset('storage/avatar/'.auth()->user()->avatar, null) }}" class="img-circle" width="80" alt="avatar">
                                            @else
                                            <i class="pe pe-7s-user c-accent fa-3x"></i>
                                            @endif
                                            <h2 class="m-t-xs m-b-none">
                                           {{ $profile->fullname }} 
                                        </h2>
                                            <small>
                                            	{{-- address --}}
                                           {{ $profile->address }}
                                        </small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-5">
                                        <table class="table small m-t-sm">
                                            <tbody>
                                                <tr>
                                                    <td><a href="#" data-toggle="modal" data-target="#signupmodal" class="btn btn-warning btn-sm security"><i class="fa fa-edit"></i>&nbsp; Manage Account</a></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    	<!-- address -->
                                                        <strong class="c-accent"><i class="pe-7s-clock"></i></strong> 
                                                        {{ \Carbon\Carbon::parse($profile->dob)->toFormattedDateString() }}
                                                    </td>
                                                    <td>
                                                        <strong class="c-accent"><i class="pe-7s-user"></i></strong> {{ auth()->user()->profile->gender ?? 'not set' }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong class="c-accent">  <i class="pe-7s-call"></i></strong> {{ $profile->phone }}
                                                    </td>
                                                    <td>
                                                        <strong class="c-accent"> <i class="pe-7s-mail"></i></strong> {{ $profile->user->email }}
                                                    </td>
                                                </tr>
                                                <tr>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                                    <!--  <td>
                                                <strong class="c-white">244</strong> Tags
                                            </td>
                                            <td>
                                                <strong class="c-white">42</strong> Friends
                                            </td>-->
                                                    

                                                    <div class="modal right fade in" id="signupmodal" tabindex="-1" role="dialog" aria-hidden="true" style="max-height: 100%; overflow-y: auto;">
        <div class="modal-dialog">
            <div class="modal-content-wrapper">
                <div class="modal-content">

                    

                    <!--<div class="modal-header clearfix text-left">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
X</button>
</div>-->
                    <div class="modal-body ">
@include('errors.list')
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">

                                <li class="active"><a data-toggle="tab" href="#tab-10" aria-expanded="false">Personal Details</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-11" aria-expanded="true">Banking Details</a></li>
                                {{-- <li class=""><a data-toggle="tab" href="#tab-documents" aria-expanded="true">Documents</a></li> --}}
                                <li class=""><a data-toggle="tab" href="#tab-12" aria-expanded="true">Password Reset</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-13" aria-expanded="true">Transaction Pin Reset</a></li>

                            </ul>
                            <div class="tab-content">
                                <div id="tab-10" class="tab-pane  active">
                                    <div class="panel-body">
                                        <div class="row row-sm-height">
                                            <div class="col-sm-12 col-sm-height col-middle">
                                                <!--<img src="assets/img/logo.png" alt="logo" data-src="assets/img/logo.png" data-src-retina="assets/img/logo_2x.png" width="78" height="22">-->
                                                <h3>Your Details</h3>
                                                {{ Form::model($profile, ['action' => ['ProfileController@update', $profile->id], 'autocomplete' => 'off', 'novalidate' => 'novalidate', 'role' => 'form', 'files' => true, 'class' => 'p-t-15']) }}
                                                    {{ method_field('PATCH') }}
                                                    <div class="">
                                                        <div class="" style="">
                                                            <!-- This wraps the whole cropper -->
                                                            <label for="avatar">Upload Passport Photograph</label>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                            <label class="btn btn-default" for="file-selectora">
                                                                <input id="file-selectora" type="file" name="avatar" style="display:none;"
                                                                       onchange="$('#upload-file-infoa').html($(this).val());">
                                                                Upload file
                                                            </label>
                                                            <span class='label label-default' id="upload-file-infoa"></span>
                                                        </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-default">
                                                                <label>First Name</label>
                                                                {{ Form::text('firstname', null, ['class' => 'form-control', 'aria-required'=>'true', 'required']) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-default">
                                                                <label>Last Names</label>
                                                                {{ Form::text('lastname', null, ['class' => 'form-control', 'aria-required'=>'true', 'required']) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group form-group-default">
                                                                <label>TradeFi User name</label>
                                                                {{ Form::text('username', $profile->user->username, ['class' => 'form-control', 'aria-required'=>'true', 'required']) }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-default">
                                                                <label>Email</label>
                                                                 {{ Form::email('email', $profile->user->email, ['class' => 'form-control', 'aria-required'=>'true', 'required']) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-default">
                                                                <label>Phone</label>
                                                                 {{ Form::text('phone', null, ['class' => 'form-control', 'aria-required'=>'true', 'required']) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-default">
                                                                <label>DOB</label>
                                                                {{ Form::text('dob', null, ['class' => ' datepicker form-control', 'aria-required'=>'true', 'required']) }}
                                                            </div>

                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-default">
                                                                <label>Gender</label>
                                                                {{ Form::select('gender', ['' => 'Select Gender'] + $genders->pluck('Gender','Gender')->toArray(), null, ['class' => 'form-control']) }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group form-group-default">
                                                                <label>Address</label>
                                                                {{ Form::text('address', null, ['class' => ' form-control', 'aria-required'=>'true', 'required']) }}
                                                            </div>
                                                        </div>
                                                    </div><hr>

                                                    <h4>Next of kin details</h4>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-default">
                                                                <label>Fullname</label>
                                                                {{ Form::text('kin_fullname', null, ['class' => ' form-control', 'aria-required'=>'true', 'required']) }}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-default">
                                                                <label>Relationship</label>
                                                                <select name="kin_relationship" id="kin_relationship" class="form-control">
                                                                            <option value="">Select Relationship</option>
                                                                            <option @if(isset($profile->kin_relationship) && $profile->kin_relationship == 'Brother') selected @endif value="Brother">Brother</option>
                                                                            <option @if(isset($profile->kin_relationship) && $profile->kin_relationship == 'Sister') selected @endif value="Sister">Sister</option>
                                                                            <option @if(isset($profile->kin_relationship) && $profile->kin_relationship == 'Mother') selected @endif value="Mother">Mother</option>
                                                                            <option @if(isset($profile->kin_relationship) && $profile->kin_relationship == 'Father') selected @endif value="Father">Father</option>
                                                                            <option @if(isset($profile->kin_relationship) && $profile->kin_relationship == 'Spouse') selected @endif value="Spouse">Spouse</option>
                                                                            <option @if(isset($profile->kin_relationship) && $profile->kin_relationship == 'Friend') selected @endif value="Friend">Friend</option>
                                                                            <option @if(isset($profile->kin_relationship) && $profile->kin_relationship == 'Child') selected @endif value="Child">Child</option>
                                                                        </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-default">
                                                                <label>Address</label>
                                                                {{ Form::text('kin_address', null, ['class' => ' form-control', 'aria-required'=>'true', 'placeholder'=>"Address", 'required']) }}
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-default">
                                                                <label>Phone</label>
                                                                {{ Form::text('kin_phone', null, ['class' => ' form-control', 'aria-required'=>'true', 'placeholder'=>"Phone Number", 'required']) }}

                                                            </div>
                                                        </div>
                                                    </div> <hr>

                                                    <h4>Personal Trading Information</h4>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-default">
                                                                <label>Income Bracket</label>
                                                                <select class="form-control" name="income_bracket" id="income_bracket">
                                                                    <option  value="">Select Income Bracket</option>
                                                                    <option @if(isset($profile->income_bracket) && $profile->income_bracket == 'Below 500,000') selected @endif value="Below 500,000">Below 500,000</option>
                                                                    <option @if(isset($profile->income_bracket) && $profile->income_bracket == '500,000-1,000,0000') selected @endif value="500,000-1,000,0000">500,000-1,000,0000</option>
                                                                    <option @if(isset($profile->income_bracket) && $profile->income_bracket == '1,000,000-5,000,000') selected @endif value="1,000,000-5,000,000">1,000,000-5,000,000</option>
                                                                    <option @if(isset($profile->income_bracket) && $profile->income_bracket == '5,000,000 and above') selected @endif value="5,000,000 and above">5,000,000 and above</option>
                                                                </select>  

                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group form-group-default">
                                                                <label>Trading Experience</label>
                                                                <select class="form-control" name="trading_experience" id="trading_experience">
                                                                    <option  value="">Select Trading Experience</option>
                                                                    <option @if(isset($profile->trading_experience) && $profile->trading_experience == 'Beginner') selected @endif value="Beginner">Beginner</option>
                                                                    <option @if(isset($profile->trading_experience) && $profile->trading_experience == 'Intermediate') selected @endif value="Intermediate">Intermediate</option>
                                                                    <option @if(isset($profile->trading_experience) && $profile->trading_experience == 'Advanced') selected @endif value="Advanced">Advanced</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div> 

                                                         <label for="">Mode of Identification</label> <br>
                                                        <div class="row">
                                                           
                                                            <div class="form-group col-md-6">
                                                            <select name="moi" id="moi" class="form-control">
                                                                <option  value="">Select Mode of Identification</option>
                                                            <option value="International Passport">International Passport</option>
                                                            <option value="National ID">National ID</option>
                                                            <option value="Voter's Card">Voter's Card</option>
                                                            <option value="Drivers's Licence">Drivers's Licence</option>
                                                        </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="btn btn-default" for="file-selector1">
                                                                <input id="file-selector1" type="file" name="identification" style="display:none;"
                                                                       onchange="$('#upload-file-info').html($(this).val());">
                                                                Upload file
                                                            </label>
                                                            <span class='label label-default' id="upload-file-info"></span>
                                                        </div>
                                                        </div>
    
                                                        <label for="">Upload Utility Bill <small>(within the last 3 months)</small></label>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                            <label class="btn btn-default" for="file-selector2">
                                                                <input id="file-selector2" type="file" name="utility_bill" style="display:none;"
                                                                       onchange="$('#upload-file-info2').html($(this).val());">
                                                                Upload file
                                                            </label>
                                                            <span class='label label-default' id="upload-file-info2"></span>
                                                        </div>
                                                        </div>

                                                    <button class="btn  btn-cons m-t-10" style="background-color:#134e5e;border-color:#134e5e;color:#f2f6f7" type="submit">Update My Details</button>
                                                {{ Form::close() }}


                                                	
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- tb10 -->

                                <div id="tab-11" class="tab-pane">
                                    <div class="panel-body">

                                        @if($profile->bank_detail != null )
                                            {{ Form::model($bank_detail, ['action' => ['BankDetailController@update', $profile->id], 'autocomplete' => 'off', 'role' => 'form', 'class' => 'p-t-15']) }}
                                                {{ method_field('PATCH') }}
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Bank Name</label>
                                                        {{ Form::select('bank_id', ['' => 'Select Bank'] + $banks->pluck('name','id')->toArray(), null, ['class' => 'form-control', 'required']) }}
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Bank Account Number</label>
                                                        {{ Form::text('account_number', null, ['class' => 'form-control', 'required']) }}
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="btn  btn-cons m-t-10" style="background-color:#134e5e;border-color:#134e5e;color:#f2f6f7" type="submit">Update Bank Details</button>

                                        {{ Form::close() }}
@else
{{ Form::open(['action' => ['BankDetailController@store'], 'autocomplete' => 'off', 'role' => 'form', 'class' => 'p-t-15']) }}
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Bank Name</label>
                                                        {{ Form::select('bank_id', $banks->pluck('name','id'), null, ['class' => 'form-control']) }}
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Bank Branch</label>
                                                        {{ Form::text('branch', null, ['class' => 'form-control', 'required']) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Bank Account Number</label>
                                                        {{ Form::text('account_number', null, ['class' => 'form-control', 'min' => 10, 'max' => 10, 'required']) }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>BVN</label>
                                                        {{ Form::text('bvn', null, ['class' => 'form-control', 'required']) }}
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Custodian</label>
                                                        {{ Form::select('custodian_id', $custodians->pluck('name','id'), null, ['class' => 'form-control']) }}
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="btn  btn-cons m-t-10" style="background-color:#134e5e;border-color:#134e5e;color:#f2f6f7" type="submit">Update Bank Details</button>

                                        {{ Form::close() }}

                                        @endif

                                    </div>
                                </div>
                                <!-- t11 -->

                                <!-- documents-->
    

                                <!-- documents-->

                                <div id="tab-12" class="tab-pane">
                                    <div class="panel-body">
                                         {{ Form::open(['action' => ['SettingController@reset_password']]) }}
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 ">
                                                    <div class="form-group form-group-default">
                                                        <label>Current Password</label>
                                                        <input type="password" name="old_password" placeholder="Minimum of 8 Characters" class="form-control"  aria-required="true">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>New Password</label>
                                                        <input type="password" name="password" placeholder="Minimum of 8 Characters" class="form-control"  aria-required="true">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Re-enter new Password</label>
                                                        <input type="password" name="password_confirmation" placeholder="*****" class="form-control"  aria-required="true">
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn  btn-cons m-t-10" style="background-color:#134e5e;border-color:#134e5e;color:#f2f6f7" type="submit">Reset Password</button>
                                        {{ Form::close() }}
                                       
                                    </div>
                                </div>
                                <!-- t12 -->

                                <div id="tab-13" class="tab-pane">
                                    <div class="panel-body">
                                            {{ Form::open(['action' => 'SettingController@reset_trading_pin']) }}
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Enter trading pin</label>
                                                        <input type="password" name="trading_pin" placeholder="4 digits" class="form-control" required="" aria-required="true">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Re-enter pin</label>
                                                        <input type="password" name="trading_pin_confirmation" placeholder="*****" class="form-control" required="" aria-required="true">
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn  btn-cons m-t-10" style="background-color:#134e5e;border-color:#134e5e;color:#f2f6f7" type="submit">Set Pin</button>
                                        {{ Form::close() }} 
                                    </div>
                                </div>
                                <!-- t13 -->

                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <a href="#" data-dismiss="modal" class="btn btn-w-md btn-accent btn-rounded">Dismiss Window</a>
                    </div>

                </div>
            </div>

        </div>
    </div>

                                    {{-- </div> --}}
                                    <div class="col-md-3 m-t-sm hide">
                                        <span class="c-white">
                                    Banking
                                </span>
                                        <br>
                                        <small>
                                       BVN: <strong class="security">{{-- !is_null($profile->bank_detail) ? $profile->bank_detail->bvn : 'N/A' --}}</strong>
                                    </small>
                                    <br> <br>
                                    <span class="c-white">
                                    Trading <small>(Shown Temporarily for testing purpose)</small>
                                </span>
                                        <br>
                                        <small>
                                       PIN: <strong class="security">{{ !is_null($profile->user->trading_pin) ? str_limit($profile->user->trading_pin, 4, '**') : 'N/A' }}</strong>
                                    </small>
                                        <br/>
                                        <div class="btn-group m-t-sm">
                                            <!--  <a href="#" class="btn btn-default btn-sm"><i class="fa fa-envelope"></i>&nbsp;Update Banking details</a> -->

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">

                    <div class="col-md-12">

                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-6" href="#">TradeFi Alert Box</a></li>
                                <li><a data-toggle="tab" href="#tab-5" href="#">My Activities</a></li>
                            </ul>
                            
                            <div class="tab-content">
                                <div id="tab-5" class="tab-pane">

                                    <div class="panel panel-filled divSec2 scrollbar" id="style-9">
                                        <div class="panel-body">
                                            <h4> Recent Activity</h4>

                                            <div class="v-timeline vertical-container">
                                                <div class="vertical-timeline-block">
                                                    <!--<div class="vertical-timeline-icon">
                                        <i class="fa fa-user"></i>
                                    </div>-->
                                                    
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div id="tab-6" class="tab-pane active">

                                    <div class="panel panel-filled divSec2 scrollbar" id="style-9">
                                        <div class="panel-body">
                                            <h4><span class="security">Messages From Team TradeFi </span> </h4>

                                            <div class="v-timeline vertical-container">
                                                <div class="vertical-timeline-block">


                                                    @foreach($ticket_activity as $activity)
                                                   
                                                               
                                                    <div class="vertical-timeline-content">
                                                        <div class="p-sm">
                                                            <span class="vertical-date pull-right"> <small>{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</small> </span>

                                                            <h2>Ticket Response</h2>

                                                            <p> {!! $activity->description !!} </p>
                                                        </div>
                                                    </div>
                                                 @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                   
                </div>

                

            </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropit/0.5.1/jquery.cropit.min.js"></script>
<script src="https://github.com/scottcheng/cropit/blob/master/dist/jquery.cropit.js"></script>
<script>

    
	$('.datepicker').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd'
	});


    // croppit
    $(function(){

         $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        

        // When user clicks select image button,
        // open select file dialog programmatically
        $('.choose-image').click(function(e) {
            e.preventDefault()
          $('.cropit-image-input').click();
        });

        // Handle rotation
        $('.rotate-cw-btn').click(function() {
          $('#image-cropper').cropit('rotateCW');
        });
        $('.rotate-ccw-btn').click(function() {
          $('#image-cropper').cropit('rotateCCW');
        });
    })
</script>
@endpush
