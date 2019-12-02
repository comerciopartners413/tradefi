@extends('layouts.app')
@section('content')
<div class="container-center animated slideInDown" style="margin-top: 10px;">


            <div class="view-header">
                <div class="header-icon">
                    <i class="pe page-header-icon pe-7s-unlock"></i>
                </div>
                <div class="header-title">
                    <h3>Change Password</h3>
                    <small>
                        You must change the default password to continue. Check the invitation mail for your current password. It is the same one you logged in with.

                    </small>
                </div>
            </div>

            <div class="panel panel-filled">
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
                     <button class="btn  btn-cons m-t-10 btn-accent" type="submit">Reset Password</button>
                 {{ Form::close() }}
                
             </div>
            </div>

        </div>
@endsection