<!doctype html>
<html>
<style>
    .error {
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }
    .intl-tel-input {width: 100%;}

    
</style>

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
        background: #d6d6d6;
        height: 5px;
        border-radius: 5px;
        outline: 0;
    }

    .cropit-preview {
        width: 150px;
        height: 150px;
        margin: 20px 0;
        display: flex;
        padding: 0 20px;
        text-align: center;
        align-items: center;
        justify-content: center;
        border-radius: 3px;
        border: 1px solid rgba(239, 141, 43,.4);
        flex-grow: 0;
    }

    .cropit-preview > label {
            font-weight: 400;
            color: #a56627;
    }

    .cropit-preview i {
            font-size: 50px;
        color: rgba(239, 141, 43,.4);
    }

    .cropit-preview-image-container {
        border-radius: 3px;
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
        color: rgb(239, 141, 43);
        margin-right: 20px;
    }
    span.after {
        font-size: 30px;
        color: rgb(239, 141, 43);
        margin-left: 20px;
    }

    .practice-wrapper {
        display: flex;
        justify-content: space-around;
        position: absolute;
        width: 100%;
        bottom: 0;
    }

    .practice-wrapper > a {
        position: relative;
        z-index: 10;
    }

    .form-group-default .form-control {
        border: none;
        height: 25px !important;
        min-height: auto !important;
        padding: 0;
        margin-top: -4px;
        background: none;
    }
    #captchaText{
        margin-left: 67%;
    }

    #captchaInput{
        width: 35px;
        color: #000;
    }
    .static-video {
        background: url({{ asset('assets/video/frame-c.jpg') }}) !important;
            background-size: cover !important;
    position: absolute;
    top: 0;
    height: 100vh;
    width: 100vw;
    }
</style>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TradeFi | Fixed Income Trading</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="icon" href="{{ asset('assets/favicon.ico') }}" type="image/x-icon" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content name="description" />
    <meta content name="author" />

    <link href="{{ asset('assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">
    {{-- <link rel="stylesheet" href="{{ asset('webapp/vendor/steps/jquery.steps.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('webapp/styles/pe-icons/pe-icon-7-stroke.css') }}" />
    <link rel="stylesheet" href="{{ asset('webapp/styles/pe-icons/helper.css') }}" />
    <link class="main-stylesheet" href="{{ asset('pages/css/pages.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('pages/css/pages-icons.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('webapp/vendor/steps/jquery.steps_custom.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/telinput/css/intlTelInput.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  
  
</head>

<body class="pace-white">
    <div class="modal fade slide-up disable-scroll" id="loginmodal"  role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content-wrapper">
                <div class="modal-content" style="background-color: #30323B;color:#f2f6f7">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                    </div>
                    <div class="modal-body ">
                        <div style="margin-top: 5px" class="alert alert-success inactivity-msg">You were logged out due to <b>inactivity</b></div>
                        <b class="p-t-35">Sign into your <span class="semi-bold">TradeFi</span> account</b>

                        <form id="form-login" class="p-t-15" role="form" action="{{ route('login') }}" method="POST">
                            <div class="error username-error m-b-5"></div>
                            <div class="form-group form-group-default">
                                <label style="color:#333">Login</label>
                                <div class="controls">
                                    <input type="text" name="username" placeholder="User Name" class="form-control" required>
                                </div>

                            </div>

                               
                            <div class="form-group form-group-default">
                                <label style="color:#333">Password </label>
                                <div class="controls">
                                    <input type="password" class="form-control" name="password" placeholder="At least 1 caps and 1 number" required>
                                </div>

                            </div>
                            <p style="margin-top: 5px; font-weight: 400; font-size: 12px; float: left"><a href="{{ url('/password/reset') }}">Forgot Password</a></p>
                            <p style="margin-top: 5px; font-weight: 400; font-size: 12px; float: right" class="text-warning"><a href="{{ url('/username/reset') }}" class="text-warning">Forgot Username</a></p>
                            
                            {{-- <div class="error captcha-error m-b-5"></div>
                            <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITEKEY') }}"></div> --}}

                            <div class="row">
                                <div class="col-md-6 no-padding">
                                    <div class="checkbox ">
                                        <input type="checkbox" value="1" id="checkbox1">
                                        <label for="checkbox1">Keep Me Signed in</label>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <!--<a href="#" class="text-info small" style="color:white">Help? Contact Support</a> -->
                                </div>
                            </div>

                            <input type="submit" id="login-submit" class="btn btn-block btn-cons m-t-10" style="color: white;
    border-color: #DC9A3A;
    background-color:#DC9A3A;" value="Log in">
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade slide-up disable-scroll" id="signupmodal"  role="dialog" aria-hidden="false" style="max-height: 100%;
overflow-y: auto;">
        <div class="modal-dialog">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                    </div>
                    <div class="modal-body ">

                        <div class="row row-sm-height">
                            <div class="col-sm-12 col-sm-height col-middle">
                                <!--<img src="assets/img/logo.png" alt="logo" data-src="assets/img/logo.png" data-src-retina="assets/img/logo_2x.png" width="78" height="22">-->
                                <img src="{{ asset('assets/images/logo-no-bg.jpg') }}" width="100px">
                                <!--<h3>TradeFi Account Creation</h3>-->
                                <div>
                                    <div style="font-weight: 400">
                                    Create a TradeFI account to get direct access and equal opportunity to the market and price discovery.
                                    <div class="hide alert alert-info" style="margin: 15px 0">
                                       You will need a <b>passport photograph</b>, <b>valid identification</b> and <b>proof of address</b> (within the last 3 months)</b> to complete your registration.
                                    </div> <br><br>
                                     <p class="alert alert-info">Identification is required for deposits of 5M and above</p>
                                    </div>
                                </div>
                                <form id="form-register" class="p-t-15" role="form" action="{{ route('users.store') }}" enctype="multipart/form-data"  method="POST" autocomplete="off" data-parsley-trigger="focusin focusout"  >



                                     {{ csrf_field() }}
                                     <div class="alert alert-danger error-markup"></div>
                                     <div class="alert alert-success success-markup">Registration was successful. A link has been sent to your email for confirmation.</div>
                                    

                                    <div id="wizard">
                                        <h3>Biodata</h3>
                                        <section>
                                            <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">

                                                <label>First Name</label>
                                                <input type="text" name="firstname" placeholder="As in your ID" class="form-control" required="" data-parsley-trigger="change blur" aria-required="true" aria-required="true">
                                                 @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Last Names</label>
                                                <input type="text" name="lastname" data-parsley-trigger="focusout" placeholder="As in your ID" class="form-control" required="" aria-required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>TradeFi User name</label>
                                                <input type="text" name="username" placeholder="johndoe (this can be changed later)" class="form-control" required="" aria-required="true">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <input id="dob" type="text" class="form-control date" name="dob" required autocomplete="off" tabindex="1">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="email" placeholder="Enter a valid email address" class="form-control" data-parsley-required="true" data-parsley-type="email" data-parsley-trigger="change focusout blur" aria-required="true">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>phone</label>
                                                <input type="tel" name="phone" id="phone"  class="form-control" placeholder="">
                                                {{-- <input type="hidden"  required="required"> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" name="password" id="password" placeholder="Minimum of 6 characters" class="form-control" data-parsley-minlength="6" required="" aria-required="true" pattern="/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X]).*$/"
                                                data-parsley-pattern-message="Password must contain an uppercase, a lowercase and a numeric value">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" name="password_confirmation" placeholder="*****" class="form-control" required="" aria-required="true" data-parsley-equalto="#password" data-parsley-error-message="This value should be the same with password">
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="row">
                                        <div class="form-group">
                                            <label>BVN</label>
                                            <input type="text" name="bvn" placeholder="e.g 01234567890" class="form-control" required="" aria-required="true">
                                        </div>
                                        <div class="col-sm-12 hide">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" name="address" placeholder="Address Line 1" class="form-control" aria-required="true">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="hide">
                                        <h4>Next of kin details</h4>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Fullname</label>
                                                <input type="text" name="kin_fullname" placeholder="Smith" class="form-control" required="" aria-required="true">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Relationship</label>
                                                <select name="kin_relationship" id="kin_relationship" class="form-control">
                                                    <option value="">Relationship</option>
                                                    <option value="Brother">Brother</option>
                                                    <option value="Sister">Sister</option>
                                                    <option value="Mother">Mother</option>
                                                    <option value="Father">Father</option>
                                                    <option value="Spouse">Spouse</option>
                                                    <option value="Friend">Friend</option>
                                                    <option value="Child">Child</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" name="kin_address" placeholder="Address" class="form-control" required="" aria-required="true">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="text" name="kin_phone" placeholder="Phone Number" class="form-control" required="" aria-required="true">
                                            </div>
                                        </div>
                                    </div>
                                    </div>

                                        </section>
                                        {{-- <h3>KYC</h3> --}}
                                        
                                        <h3>Identity</h3>
                                        <section>
                                            <div class="">
                                                        <div class="" style="">
                                                            <p>
                                                                <div class="alert alert-info" style="font-weight: 400">
                                                                    Kindly note that you can complete your registration without uploading documentation but you will be required to upload these documents before liquidating your investments
                                                                </div>
                                                            </p>
                                                            <!-- This wraps the whole cropper -->
                                                            <label for="avatar">Upload Passport Photograph</label>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                            <label class="btn btn-info" for="file-selector3">
                                                                <input id="file-selector3" type="file" name="avatar" style="display:none;"
                                                                       onchange="$('#upload-file-info3').html($(this).val());" accept="image/*">
                                                                Upload file
                                                            </label>
                                                            <span class='label label-default' id="upload-file-info3"></span>
                                                        </div>
                                                        </div>
                                                            <div id="image-cropper" class="hide">
                                                              <!-- This is where the preview image is displayed -->
                                                              <div class="cropit-preview">
                                                                <label>Passport Photograph</label>
                                                                  <i class="pe-7s-camera"></i>
                                                              </div>
                                                             <div class="image-controls">
                                                                  <div class="range-container">
                                                                    <span class="before">
                                                                        <i class="pe-7s-box2"></i>
                                                                    </span>
                                                                      <input type="range" class="cropit-image-zoom-input" />
                                                                      <span class="after">
                                                                         <i class="pe-7s-box2"></i>
                                                                      </span>
                                                                  </div>
                                                             {{-- <input type="file" name="avatar" id="avatar" class="cropit-image-input" > --}}
                                                             
                                                             
                                                             </div>
                                                            </div>
                                                        </div>
                                                    </div> <hr>

                                                        <label for="">Mode of Identification</label> <br>
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                            <select name="moi" id="moi" class="form-control">
                                                            <option value="International Passport">International Passport</option>
                                                            <option value="National ID">National ID</option>
                                                            <option value="Voters Card">Voter's Card</option>
                                                            <option value="Driver's Licence">Driver's Licence</option>
                                                        </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="btn btn-info" for="file-selector1">
                                                                <input id="file-selector1" type="file" name="identification" style="display:none;"
                                                                       onchange="$('#upload-file-info').html($(this).val());">
                                                                Upload file
                                                            </label>
                                                            <span class='label label-default' id="upload-file-info"></span>
                                                        </div>
                                                        </div>
    
                                                        <label for="">Upload Utility Bill <small>(valid within 3 months)</small></label>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                            <label class="btn btn-info" for="file-selector2">
                                                                <input id="file-selector2" type="file" name="utility_bill" style="display:none;"
                                                                       onchange="$('#upload-file-info2').html($(this).val());" accept="image/*">
                                                                Upload file
                                                            </label>
                                                            <span class='label label-default' id="upload-file-info2"></span>
                                                        </div>
                                                        </div>
                                        </section>
                                        <h3>Submit</h3>
                                        <section>
                                            <div class="row m-t-10">
                                                <div class="col-md-12">
                                                    <small>By clicking "Create new account", you agree to  <a href="/terms" target="_blank" class="">TradeFi's Terms and Condition</a></small>
                                                </div>
                                            </div>
                                        </section>
                                    </div>

                                    <!--<button class="btn  btn-cons m-t-10" style="background-color:#134e5e;border-color:#134e5e;color:#f2f6f7" type="submit">Create a new account</button>-->
                                    {{-- <button class="btn  btn-cons m-t-10" style="background-color:#2C71EF;border-color:#2C71EF;color:#f2f6f7" type="submit">Create a new account</button> --}}

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade slide-up disable-scroll" id="learnmoremodal" role="dialog" aria-hidden="false" style="max-height: 100%;
overflow-y: auto;">
        <div class="modal-dialog">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                    </div>
                    <div class="modal-body ">

                        <div style=" background-color: black;text-align:center">
                            <iframe width="70%" height="315" src="https://www.youtube.com/embed/rD25slnTqAE?rel=0&amp;controls=1&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <nav class="header bg-header transparent-light " data-pages="header" data-pages-header="autoresize" data-pages-resize-class="dark">
        <div class="container relative">

            <div class="pull-left">

                <div class="header-inner text-white">
                     {{-- <b style="font-size: 12px; margin-top:10px">Endorsed by &nbsp;</b><img src="{{ asset('assets/images/fmdq.png') }}" width="120px" alt="fmdq"> --}}
                     <b style="font-size: 12px; margin-top:10px">Endorsed by FMDQ OTC Securities Exchange
                </div>
            </div>

            <div class="pull-right">
                <div class="header-inner">
                    <div class="visible-sm-inline visible-xs-inline menu-toggler pull-right p-l-10" data-pages="header-toggle" data-pages-element="#header">
                        <div class="one"></div>
                        <div class="two"></div>
                        <div class="three"></div>
                    </div>
                </div>
            </div>

            <div class="pull-right menu-content clearfix" data-pages="menu-content" data-pages-direction="slideRight" id="header">

                <div class="pull-right">
                    <a href="#" class="text-black link padding-10 visible-xs-inline visible-sm-inline pull-right m-t-10 m-b-10 m-r-10" data-pages="header-toggle" data-pages-element="#header">
                        <i class=" pg-close_line"></i>
                    </a>
                </div>

                <div class="header-inner">
                    <ul class="menu">
                        <li>
                            <a href="/" data-text="Home" class="active">Home </a>
                        </li>
                        <li class="classic">
                            <a href="javascript:;" data-text="Support"> Support <i class="pg-arrow_minimize m-l-5"></i></a>
                            <nav class="classic ">
                                <span class="arrow"></span>
                                <ul>
                                    <li>
                                        <a href="/faq-e" target="_blank">FAQs</a>
                                    </li>
                                </ul>
                            </nav>
                        </li>

                        <li class="classic">
                            <a href="javascript:;" data-text="Legal">  Legal <i class="pg-arrow_minimize m-l-5"></i></a>
                            <nav class="classic ">
                                <span class="arrow"></span>
                                <ul>
                                    <li>
                                        <a href="/terms" target="_blank">Terms &amp; Use</a>
                                    </li>
                                    <li>
                                        <a href="/aml" target="_blank">AML Policy</a>
                                    </li>
                                   <div class="hide">
                                        <li>
                                        <a href="#" target="_blank">Privacy Policy</a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">General Use</a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">Data Policy</a>
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">Cookie Use Policy</a>
                                    </li>
                                   </div>
                                </ul>
                            </nav>
                        </li>
                        @if(!auth()->check())
                        <li>
                            <a href="#" data-text="Contact" class="btn fs-12 btn-white hidden-sm hidden-xs" data-toggle="modal" data-target="#loginmodal">Login </a>
                            <a class="btn btn-bordered fs-12 btn-black  font-montserrat fs-12 all-caps pull-bottom visible-sm visible-xs  sm-static sm-m-l-20 sm-m-r-20" href="#" style="margin-bottom: 10%;margin-top: 10%;" data-toggle="modal" data-target="#loginmodal">Login</a>

                        </li>
                        <li>
                            <a class="btn btn-bordered fs-12 btn-white hidden-sm hidden-xs" href="#" id="signup">Sign Up</a>
                            <a class="btn btn-bordered fs-12 btn-black  font-montserrat fs-12 all-caps pull-bottom visible-sm visible-xs buy-now sm-static sm-m-l-20 sm-m-r-20" href="#" data-toggle="modal" data-target="#signupmodal">Register</a>
                        </li>
                        @else
                        <a href="/home" data-text="Contact" class="btn fs-12 btn-white hidden-sm hidden-xs" >Dashboard </a>
                        <a class="btn btn-bordered fs-12 btn-black  font-montserrat fs-12 all-caps pull-bottom visible-sm visible-xs  sm-static sm-m-l-20 sm-m-r-20" href="/home" style="margin-bottom: 10%;margin-top: 10%;" >Dashboard</a>
                        @endif
                    </ul>
                </div>

            </div>
        </div>
    </nav>

    <section class="jumbotron full-vh relative">
        <div class="container-xs-height full-height z-index-1">
            <div class="col-xs-height col-middle text-left">

                <div class="inner full-height">
                    <div class="container-xs-height full-height">
                        <div class="col-xs-height col-middle text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <img src="{{ asset('assets/img/logo-wo-bg.png') }}" width="100%">
                                        <h3 class="light text-white m-t-5" data-swiper-parallax="-15%">
                                         Trade Fixed Income Securities in the Nigerian Market
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div>
        <div class="static-video"></div>
            <div class="remove-on-mobile op-left bottom-right full-width full-vh z-index-1" data-vide-bg="mp4: {{ asset('assets/video/hero.mp4') }}, webm: {{ asset('assets/video/hero.webM') }},  data-vide-options="posterType: jpg, loop: true, muted: true, position: 50% 0%" >
        </div>
        </div>
        
        <div class="practice-wrapper">
            <a id="start_tour" href="#trade_section" class="btn btn-lg btn-black font-montserrat all-caps no-border fs-13">Learn</a>
            <a id="practice" href="#practice_section" class="btn btn-lg btn-black  font-montserrat all-caps no-border fs-13">Practice</a>
            <a id="trade" href="#trade_section2" class="btn btn-lg btn-black  font-montserrat all-caps no-border fs-13">Trade</a>
        </div>

        <div  class="video-overlay z-index-1"></div>
    </section>

    <section class="p-b-60 p-t-60 sm-p-b-30" id="trade_section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 text-center">
                    {{-- <h6 class="block-title m-b-0 ">Securities Trading</h6> --}}
                    {{-- <h1 class="m-t-5"></h1> --}}
                    <p>
                       The Fixed Income Assets of Investors purchased on TradeFi shall remain the proprietary assets of the investor for the entire period of their investment.</p>

 

                    <p>Comercio Partners shall not leverage on investors’ assets for their proprietary transactions</p>
                    <p class="font-arial fs-12 hint-text m-t-20">

                    </p>

                </div>
            </div>
        </div>
    </section>

    <section class="p-b-60 p-t-60" id="tour_section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                 <img class="" src="{{ asset('assets/img/demo/lv1.jpg') }}" width="200" alt="" style="display: block; margin-left: auto;margin-right: auto;padding-top: 30px">
                </div>
                <div class="col-sm-4 col-sm-offset-1 p-t-50 sm-p-t-0">
                    <!--<h6 class="block-title m-b-0 ">TradeFi's </h6>-->
                    <h1 class="m-t-5">TradeFi's Edubase</h1>
                    <p class="m-t-30">
                       Our easy to use platform educates you on the basics of the fixed income market. You are able to take an accredited assessment with the  ICAP Training Institute which awards you an e-certificate. 

                    </p>
                    {{-- <p class="hint-text font-arial  m-t-30"><b>Trade Fi's Edubase </b>educates you on Fixed Income Market and how to trade within it.
                    </p>
 --}}
                    {{-- <button data-toggle="modal" data-target="#learnmoremodal" class="btn btn-default btn-sm  btn-rounded m-r-20"> Learn more <i class="fa fa-play-circle-o" aria-hidden="true"></i></button> --}}
                    <a href="http://education.tradefi.ng" class="btn btn-sm  btn-rounded " style="color: #fff;background-color: #2C71EF;border-color: #2C71EF;">Start Learning</a>
                </div>
            </div>
        </div>
    </section>

    <section class="demo-bg-section p-t-100 p-b-100" style="background:  linear-gradient( rgba(0,0,0,.5),   rgba(0,0,0,.5)),url('assets/images/bg6.jpg') no-repeat fixed center; " id="practice_section">
        <!--<div class="container-xs-height full-height"> -->
        <div>
            <div class="col-xs-height col-middle text-left">

                <div class="inner full-height">
                    <div class="container-xs-height full-height">
                        <div class="col-xs-height col-middle">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-4 col-sm-offset-1">
                                        <h6 class="block-title m-b-0 text-menu hint-text ">TradeFi's Simulation</h6>
                                        <h1 class="m-t-5 text-white">Real World Scenarios <br>Actualized...</h1>
                                        <p class="m-t-30 text-white">Start off with N10,000,000 virtual cash to understand the dynamics of trading in the fixed income market with our trade and investing simulator module.
                                        </p>
                                        <p class="hint-text font-arial small m-t-30 text-white"><b> TradeFi's Simulator </b> provides an opportunity to learn about basic investment concepts.
                                        </p>

                                        {{-- <button class="btn btn-default btn-sm  btn-rounded m-r-20 " data-toggle="modal" data-target="#learnmoremodal">Learn more <i class="fa fa-play-circle-o" aria-hidden="true"></i></button> --}}
                                        <a href="https://simulation.tradefi.ng" target="_blank" class="btn btn-sm  btn-rounded " style="color: #fff;background-color: #1528A2;border-color: #1528A2;">Enter Test Environment</a>
                                    </div>
                                    <div class="col-sm-6">
                                       

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


 
    <section class="p-b-60 p-t-60 sm-p-b-30" id="trade_section2">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 text-center">
                    <h6 class="block-title m-b-0 ">Securities Trading</h6>
                    <h1 class="m-t-5">TradeFi's Activation</h1>
                    <p>
                       Get access to the market, engage in investing and trading fixed income instruments. The securities tradefi lets you invest in are federal government bonds and Nigerian Treasury Bills.</p>
                    <p class="font-arial fs-12 hint-text m-t-20">

                    </p>

                </div>
            </div>
        </div>
    </section>

    

    <section class="container container-fixed-lg p-t-40 p-b-40">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-md-7">
                        <div class="pull-left sm-pull-reset text-center m-t-5">
                        </div>
                    </div>
                    <div class="col-md-5 text-right sm-text-center">
                        <!--<button class="btn btn-white pull-right sm-pull-reset sm-m-t-20">Yes, I want it</button>-->
                        <a href="#" data-toggle="modal" data-target="#loginmodal" class="btn  pull-right btn-sm  btn-rounded " style="color: white;background-color: #DC9A3A;border-color: #DC9A3A;">Invest</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    



    <section id="section1" class="p-b-100 p-t-10 hide">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <h2 class="inline p-r-15 m-b-0"><img src="{{ asset('assets/images/crop.svg') }}" class="feature-icon" alt></h2>
                    <h5 class="block-title m-b-0 inline">FGN Bonds </h5>
                    <div class="p-l-45">
                        <h2 class="m-t-0">Note them down</h2>
                        <p class="m-t-20">Brief Note About FGN Bonds</p>
                        <p class="font-arial hint-text small m-t-30">Memos, e-mails, messages, shopping lists and to-do lists.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <h2 class="inline p-r-15 m-b-0"><img src="{{ asset('assets/images/meter.svg') }}" class="feature-icon" alt></h2>
                    <h5 class="block-title m-b-0 inline">Treasury Bills  </h5>
                    <div class="p-l-45">
                        <h2 class="m-t-0">Crystal Clear</h2>
                        <p class="m-t-20">Brief Note About FGN Bonds</p>
                        <h6 class="block-title m-b-5 fs-13 m-t-30 ">Retina ready</h6>
                        <p>Ready made 2x for retina displays</p>
                        <h6 class="block-title m-b-5 fs-13 m-t-30">Vector elements</h6>
                        <p>CSS vector elements and icons.</p>
                        <p class="font-arial hint-text small m-t-30">Icon Fonts, Vector SVG's, pages vector icons, Font awesome., Retina Ready.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <h2 class="inline p-r-15 m-b-0"><img src="{{ asset('assets/images/size.svg') }}" class="feature-icon" alt></h2>
                    <h5 class="block-title m-b-0 inline">Any Screen </h5>
                    <div class="p-l-45">
                        <h2 class="m-t-0">Keep connected</h2>
                        <p class="m-t-20">Quick chat helps you to Keep in touch with your friends and colleagues while working. It has a unique responsive design.</p>
                        <p class="font-arial hint-text small m-t-30">Multipurpose, Highly Customizable Chat UI design for anyone.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="p-b-100 p-t-100 hide" style="background:  linear-gradient( rgba(0,0,0,.5),   rgba(0,0,0,.5)),url('assets/images/bg1.jpg') no-repeat fixed center; ">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <h6 class="block-title m-b-0 text-white text-center">Be in the Loop</h6>
                    <h1 class="text-white text-center m-t-5">Get notified on TradeFi's Helpful Trading Tips </h1>
                    <p class="small hint-text p-t-0 text-white text-center ">We value your privacy. None of the details supplied will be shared with external parties</p>
                    <div class="form-group form-group-default input-group  m-t-40 bg-transparent b-a b-transparent-white">
                        <label class="text-white">Email Address</label>
                        <input type="email" class="form-control text-white" placeholder="Example@yourmailserver.com" style>
                        <span class="input-group-btn">
                            <button class="btn btn-white m-r-10 btn-cons" type="button">Subscribe!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="p-b-30 p-t-40">
        <div class="container sm-text-center">
            <div class="row">
                <div class="col=sm-12">
                   
                </div>
            </div>
            <div class="row">
                
                <div class="col-sm-4">

                    <div class="m-t-10 ">
                        <ul class="no-style fs-11 no-padding font-arial">
                            <li class="inline no-padding"><a href="#" style="    margin-top: -10px;" class="hint-text text-master p-l-10 p-r-10 xs-no-padding xs-m-t-10"><a href="http://www.comerciopartners.com"><b style="font-size: 12px">Powered by</b> <img src="{{ asset('assets/images/comercio-partners-retina.png') }}" class="fmdq-logo" width="50px" alt="comercio" title="Comercio Partners Asset Management"></a> </a></li>
                            
                             
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4 text-center">
                      {{-- <b style="font-size: 12px">Endorsed by &nbsp;</b><img src="{{ asset('assets/images/fmdq.png') }}" class="fmdq-logo" width="50px" alt="fmdq"> --}}
                    <a href="http://cavidel.com" title="Cavidel Limited">
                    <b style="font-size: 12px">Developed by&nbsp;</b><img src="{{ asset('images/logo.png') }}" class="fmdq-logo" width="80px" alt="fmdq">
                      </a>
                </div>
                <div class="col-sm-4 text-right font-arial sm-text-left">
                     <b>Address:</b> 10B Layi Yusuf Crescent, Off Admiralty Way, Lekki Phase 1, Lagos, Nigeria. <br> Tel: 08098723334,  08178723334 <br> Email: info@tradefi.ng
                    <p class="fs-11 muted m-t-5 sm-text-center">Copyright &copy; 2018 TradeFi. All Rights Reserved.</p>
                    
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('assets/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('webapp/vendor/jquery/dist/jquery.min.js') }}"></script> 
    <script src="{{ asset('assets/plugins/telinput/js/intlTelInput.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('assets/plugins/velocity/velocity.min.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('assets/plugins/velocity/velocity.ui.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('assets/plugins/vide/jquery.vide.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    {{-- <script src='https://www.google.com/recaptcha/api.js'></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="{{ asset('pages/js/pages.frontend.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/cropit/0.5.1/jquery.cropit.min.js"></script> --}}
{{-- <script src="https://github.com/scottcheng/cropit/blob/master/dist/jquery.cropit.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('webapp/vendor/steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('js/parsley.js') }}"></script>
    <script src="{{ asset('js/jquery.form.min.js') }}"></script>
    
    <script src="{{ asset('js/jquery.captcha.basic.min.js') }}"></script>

<script>
      // $('#form-login').validate();
      // $(function(){
       $('#form-login').captcha();
       $("#form-login").submit(function(e){
                e.preventDefault();
                var that = $(this);
                var button = $("#login-submit");
               $.ajax({
                   url: '/get-new-token',
                   type: 'GET',
                   beforeSend: function(){
                        console.log('loading...');
                        button.attr('disabled', 'disabled');
                        // button.html('<i style="font-size: 16px" class="fa fa-circle-o-notch fa-spin"></i>');
                    }
               }).done(function(data) {
                   // console.log(data);
                   $new_token = data;
                   button.removeAttr('disabled');
                    // console.log('token',$new_token);
                   $.ajax({
                    url: "{{ route('login') }}",
                    type: 'POST',
                    data: {
                        '_token': $new_token,
                        'username' : that.find('[name=username]').val(),
                        'password' : that.find('[name=password]').val()
                    },
                    beforeSend: function(){
                        console.log('loading...');
                        button.attr('disabled', 'disabled');
                        button.html('<i style="font-size: 16px" class="fa fa-circle-o-notch fa-spin"></i>');
                    }
                }).done(function(data, textStatus, jqXHR) {
                    
                    // button.removeAttr('disabled');
                    if(jqXHR.status == 200){
                        // login was successful
                        window.location.href = "{{ route('home') }}"
                    } else {
                        return false;
                    }
                    
                })
                .fail(function(error) {
                     button.removeAttr('disabled');
                    button.text("Log in");
                    if(error.responseJSON.errors){
                        $.each(error.responseJSON.errors, function(index, val) {
                        // console.log(val.length);
                            $('.captcha-error').html(val)
                        });
                    } else {
                         $('.captcha-error').hide();
                    }

                    if(error.responseJSON.username != '') {
                         $('.username-error').html(error.responseJSON.username)
                    } else {
                        $('.username-error').hide();
                    }

                })
                .always(function() {
                   
                });
               });
               
                
                
                
            });
      // })
    </script>
    <!-- test -->
    <!-- test -->
    
    <script>

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
         
        $(function(){
            // tel input
           
 
            // var vid = document.getElementsByTagName('video');
            // vid[0].play();
             $("#wizard").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "fade",
                autoFocus: true,
                saveState: true,
                labels: {
                    cancel: "Cancel",
                    finish: "Create a new account",
                    next: "<i class='ion-arrow-right-c'></i>",
                    previous: "<i class='ion-arrow-left-c'></i>",
                    loading: "Loading ..."
                },
                onFinished: function() {
                    $("#form-register").submit();
                }
            });
              $('[type="tel"]').intlTelInput({
                initialCountry: "ng",
                utilsScript: "{{  asset('assets/plugins/telinput/js/utils.js') }}"
            });
        var timeout = {{ request()->has('timeout') ? 1 : 0 }};
            // window.location.reload();
            if(timeout == 1) {
                // commented becaise it might cause an unending reload
                // window.location.reload();
                $('.inactivity-msg').show();
                $('#loginmodal').modal();
            } else {
                $('.inactivity-msg').hide();
            }
            $('#dobx').datepicker({
                autoclose: true,
                allowInput: true,
                todayHighlight: false
            });
            var error_markup = $('.error-markup'),
            success_markup = $('.success-markup');
                    error_markup.html('');
                    error_markup.hide();
                    success_markup.hide();


             $('#form-register').submit(function() { 
                // inside event callbacks 'this' is the DOM element so we first 
                // wrap it in a jQuery object and then invoke ajaxSubmit 
                 $('#phone').val($('#phone').intlTelInput("getNumber"));
                 var that = $(this),
                button = that.find('[href="#finish"]');
                $(this).ajaxSubmit({
                    url: "{{ route('users.store') }}",
                    dataType:  'json',        // 'xml', 'script', or 'json' (expected server response type) 
                    clearForm: true,        // clear all form fields after successful submit 
                    resetForm: true ,
                    beforeSerialize: function(){
                        button.html('<i style="font-size: 16px" class="fa fa-circle-o-notch fa-spin"></i>');
                    },
                    error: function(error){
                        console.log(error);
                        button.html('Create a new Account');
                         error_markup.html('');
                        if(Object.keys(error.responseJSON).length > 0){
                            error_markup.show();
                            success_markup.hide();
                        }
                        $.each(error.responseJSON, function(index, val) {
                             /* iterate through array or object */
                             // console.log(val);
                             error_markup.append('<div>'+val + '</div>')
                        });
                    },
                    success: function(data, textStatus, jqXHR){
                        console.log(data);
                        $("#form-register").parsley().destroy();
                        error_markup.html(''); 
                        error_markup.fadeOut();
                        if(jqXHR.status == 200){ 
                            console.log(data);
                             success_markup.fadeIn();
                             $('#upload-file-info').html('');
                             $('#upload-file-info2').html('');
                             $('#upload-file-info3').html('');
                             $(".steps li").removeClass('done');
                             $(".steps li").addClass('disabled');
                             button.html('Create a new Account');
                        }
                    } 
                }); 
         
                // !!! Important !!! 
                // always return false to prevent standard browser submit and page navigation 
                return false; 
            }); 
            var datepicker_config = {
                altInput: true,
                altFormat: "F j, Y",
                allowInput: true,
                dateFormat: "Y-m-d",
            };
           $(".date").flatpickr(datepicker_config);

           $("#form-register").parsley();
        });


    </script>

   <script>
       if( navigator.userAgent.match(/Android/i)
            || navigator.userAgent.match(/webOS/i)
            || navigator.userAgent.match(/iPhone/i)
            || navigator.userAgent.match(/iPad/i)
            || navigator.userAgent.match(/iPod/i)
            || navigator.userAgent.match(/BlackBerry/i)
            || navigator.userAgent.match(/Windows Phone/i)) {
                $('body').addClass('mobile');
                $('.remove-on-mobile').remove();
       }
   </script>

</body>

</html>