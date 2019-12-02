@extends('layouts.app')
@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">
<link rel="stylesheet" href="{{ asset('css/imageviewer.css') }}">
<style>
    #iv-container {
    z-index: 9999999;
}
</style>
@endpush
@section('content')
     <!-- Main content-->
        <div class="container-fluid">

            <div class="row m-t-sm">

                <div class="col-md-12">
                    <div class="panel panel-filled">

                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="media">
                                        @if($user->hasCustomAvatar())
                                <img class="image" style="width: 50px; border-radius: 50%" src="{{ asset('storage/avatar/'.$user->avatar) }}" data-high-res-src="{{ asset('storage/avatar/'.$user->avatar) }}" alt="avatar">
                                @else
                                <span style="display: inline-block;" class="abbr-avatar">{{ $user->abbreviation($user->profile->firstname) }}</span>
                                @endif
                                        <h3 class="m-t-xs m-b-xs">
                                            {{ $user->profile->fullname }}
                                        </h3>
                                        <small>
                                            <b>Address: </b> {{ $user->profile->address }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <table class="table small m-t-sm">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <strong class="c-white m-r-xs">Firstname</strong> {{ $user->profile->firstname }}
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="c-white m-r-xs">Lastname</strong> {{ $user->profile->lastname }}
                                            </td>
                                            <td>
                                                <strong class="c-white m-r-xs">Username</strong> {{ $user->username }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="c-white m-r-xs">Email Address</strong> {{ $user->email }}
                                            </td>
                                            <td>
                                                <strong class="c-white m-r-xs">Gender</strong> {{ $user->profile->gender }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="c-white m-r-xs">Phone Number</strong> {{ $user->profile->phone }}
                                            </td>
                                            <td>
                                                <strong class="c-white m-r-xs">D.O.B</strong> {{ $user->profile->dob }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-3 m-t-sm">
                                <span class="c-white">
                                    Activation
                                </span>
                                    <br>
                                    <small>
                                        Activate user's traderoom. An automatic mail will be sent to the user.
                                    </small>
                                    @permission('approve_traderoom')
                                    <div class="btn-group m-t-sm">
                                        <a href="#" class="btn btn-warning btn-sm activate-btn {{ $user->ActivatedFlag == 1 ? 'disabled' : '' }}" data-user-id="{{ $user->id }}" ><i class="fa fa-check"></i> Activate Traderoom</a>
                                    </div>
                                    @endpermission


                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">

                        <div class="panel-body">
                            <h4 class="text-warning">Checklist</h4>
                            
                              <div class="row">
                                <div class="col-sm-8">
                                  <div class="row">
                                  @ability('admin_authorizer,ops_authorizer', 'update_cash_account')
                                     <div class="col-sm-4">
                                      <div class="form-inline">
                                        <select id="" class="form-control text-uppercase select_company" style="{{ !empty($user->company_id)? 'border:1px solid green' : '' }}" data-init-plugin="select2">
                                          <option value="">None</option>
                                          @foreach ($companies as $company)
                                            <option value="{{ $company->id }}" class="text-uppercase" {{ ($user->company_id == $company->id)? 'selected' : '' }}>{{ $company->name }}</option>
                                          @endforeach
                                        </select>
                                        <button class="btn btn-sm btn-warning save_company">
                                          <i class="fa fa-save c-white"></i>
                                        </button>
                                      </div>
                                    </div>
                                     <div class="col-sm-4">
                                      <div class="form-inline">
                                        <input type="text" class="form-control input-sm" name="cash_account" placeholder="Cash Account" value="{{ isset($user->cash_account) ? $user->cash_account : null }}">
                                        <button class="btn btn-sm btn-warning" id="cash_account_btn">
                                            <i class="fa fa-save c-white"></i>
                                        </button>
                                      </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="form-inline">
                                        <input type="text" class="form-control input-sm" name="securities_account" placeholder="Securities Account" value="{{ isset($user->securities_account) ? $user->securities_account : null }}">
                                        <button class="btn btn-sm btn-warning" id="securities_account_btn">
                                            <i class="fa fa-save c-white"></i>
                                        </button>
                                      </div>
                                    </div>
                                   @endability
                                  </div>
                                </div>

                                <div class="col-sm-4">
                                  <div class="">
                                    @ability('admin_authorizer,ops_authorizer', 'check_kyc_bvn_account_details')
                                    <button class="btn btn-sm btn-default kyc-toggler">Check KYC</button>
                                    <button class="btn btn-sm btn-default cash-account-toggler">Cash Account</button>
                                    <button class="btn btn-sm btn-default sec-account-toggler">Securities Account</button>
                                    @endability
                                  </div>
                                </div>
                              </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">

                        <div class="panel-body">
                            <h4 class="text-warning">Banking Details</h4>


                            <table class="table">
                                <thead>
                                <tr>

                                    <th style="padding-left: 0">Bank Name</th>
                                    {{-- <th>Branch</th> --}}
                                    <th>Account Number</th>
                                    <th>BVN</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="padding-left: 0">
                                       {{ $user->profile->bank_detail->bank  ? $user->profile->bank_detail->bank->name : 'N/A'  }}
                                    </td>
                                    {{-- <td>{{ $user->profile->bank_detail ? $user->profile->bank_detail->branch : 'N/A' }}</td> --}}
                                    <td>{{ $user->profile->bank_detail->account_number ? $user->profile->bank_detail->account_number : 'N/A' }}</td>
                                    <td>{{ $user->profile->bank_detail->bvn ? $user->profile->bank_detail->bvn : 'N/A' }}</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">

                        <div class="panel-body">
                            <h4 class="text-warning">Next of Kin Details</h4>


                            <table class="table">
                                <thead>
                                <tr>

                                    <th style="padding-left: 0">Full Name</th>
                                    <th>Relationship</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="padding-left: 0">
                                       {{ $user->profile->kin_fullname }}
                                    </td>
                                    <td>{{ $user->profile->kin_relationship }}</td>
                                    <td>{{ $user->profile->kin_phone }}</td>
                                    <td>{{ $user->profile->kin_address }}</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">

                        <div class="panel-body">
                            <h4 class="text-warning">Uploaded Documents</h4>
                             <div class="row">
                                 <div class="col-sm-6">
                                     <h5>Identification</h5>
                                     {{-- check type of extension if type of pdf --}}
                                     @if($user->identification != '')
                                        <a href="{{ asset('storage/identification/'.$user->identification) }}">Click to View</a>
                                      @else
                                       <img src="{{ asset('storage/identification/'.$user->identification) }}" class="image img-rounded" width="200" data-high-res-src="{{ asset('storage/identification/'.$user->identification) }}" alt="ID">
                                     @endif
                                   
                                 </div>

                                 <div class="col-sm-6">
                                     <h5>Utility Bill</h5>
                                     @if($user->utility_bill != '')
                                        <a href="{{ asset('storage/utility_bill/'.$user->utility_bill) }}">Click to View</a>
                                      @else
                                       <img src="{{ asset('storage/utility_bill/'.$user->utility_bill) }}" class="image img-rounded" width="200" data-high-res-src="{{ asset('storage/utility_bill/'.$user->utility_bill) }}" alt="ID">
                                     @endif
                                 </div>
                             </div>

                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="row hide">

                <div class="col-md-12">
                    <div class="panel panel-filled">

                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-3 col-xs-6 text-center">
                                    <h2 class="no-margins">
                                        534
                                    </h2>
                                    <span class="c-white">Commits</span> in last week
                                </div>
                                <div class="col-md-3 col-xs-6 text-center">
                                    <h2 class="no-margins">
                                        126
                                    </h2>
                                    <span class="c-white">Public</span> gists
                                </div>
                                <div class="col-md-3 col-xs-6 text-center">
                                    <h2 class="no-margins">
                                        680
                                    </h2>
                                    <span class="c-white">New code</span> line
                                </div>
                                <div class="col-md-3 col-xs-6 text-center">
                                    <h2 class="no-margins">
                                        14
                                    </h2>
                                    <span class="c-white">New</span> builds
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    <!-- End main content-->             
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/imageviewer.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.activate-btn').click(function(e) {
        e.preventDefault();
        var userID =  $(this).data('userId');

        var that = $(this);

        $.ajax({
            url: '/admin/users/activate/'+ userID,
          type: 'POST',
          data: {userID: userID},
          beforeSend: function(){
           that.text('Loading...');
          }
        })
        .done(function() {
           that.html('<i class="fa fa-check"></i> Activated');
           toastr.success(data);
           // remove node 
        })
        .fail(function(error) {
            that.html('<i class="fa fa-check"></i> Activate Traderoom');
            console.log("error");
            toastr.error(error.responseText);
        })
        .always(function() {
            console.log("complete");
        });
        
        
    });
	$('.datepicker').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd'
	});
    $('#tab1').DataTable({});
    
    $(function(){
       $(function () {
    var viewer = ImageViewer({
        // zoomValue: 50,
        // maxZoom : 50
    });
    $('.image').click(function () {
        var imgSrc = this.src,
            highResolutionImage = $(this).data('high-res-img');
 
        viewer.show(imgSrc, highResolutionImage);
    });
});


       // update flags
       $('.kyc-toggler').click(function(e) {
           e.preventDefault();
           var that = $(this);
           var real_text = $(this).text();
           $.ajax({
               url: '/users/kyc-flag',
               type: 'post',
               data: {
                    id: {{ $user->id }}
               },
               beforeSend: function() {
                that.text('updating...');
               }
           })
           .done(function(data) {
               that.text(real_text).attr('disabled', 'disabled');
               toastr.success(data);
           })
           .fail(function(error) {
               that.text(real_text);
               toastr.error(error.responseText);
           })
           .always(function() {
               that.text(real_text);
           });
           
       });

       $('.cash-account-toggler').click(function(e) {
           e.preventDefault();
           var that = $(this);
           var real_text = $(this).text();
           $.ajax({
               url: '/users/cash-flag',
               type: 'post',
               data: {
                    id: {{ $user->id }}
               },
               beforeSend: function() {
                that.text('updating...');
               }
           })
           .done(function(data) {
               that.text(real_text).attr('disabled', 'disabled');
               toastr.success(data);
           })
           .fail(function(error) {
               that.text(real_text);
               toastr.error(error.responseText);
           })
           .always(function() {
               that.text(real_text);
           });
           
       });

       $('.sec-account-toggler').click(function(e) {
           e.preventDefault();
           var that = $(this);
           var real_text = that.text();
           $.ajax({
               url: '/users/sec-flag',
               type: 'post',
               data: {
                    id: {{ $user->id }}
               },
               beforeSend: function() {
                that.text('updating...');
               }
           })
           .done(function(data) {
               that.text(real_text).attr('disabled', 'disabled');
               toastr.success(data);
           })
           .fail(function(error) {
               that.text(real_text);
               toastr.error(error.responseText);
           })
           .always(function() {
               that.text(real_text);
           });
           
       });


       // update cash account manually
       $('#cash_account_btn').click(function(e) {
           e.preventDefault();
           var that = $(this);
           var real_text = that.text();
           var cash_account = $(this).parent().find('[name=cash_account]').val();
           $.ajax({
               url: '/users/update-cash-account',
               type: 'post',
               data: {
                    id: {{ $user->id }},
                    cash_account: cash_account

               },
               beforeSend: function() {
                that.text('updating...');
               }
           })
           .done(function(data) {
               // that.text(real_text).attr('disabled', 'disabled');
               toastr.success(data);
           })
           .fail(function(error) {
               that.text(real_text);
               toastr.error(error.responseText);
           })
           .always(function() {
               that.text(real_text);
           });
           
       });


       $('#securities_account_btn').click(function(e) {
           e.preventDefault();
           var that = $(this);
           var real_text = that.text();
           var securities_account = $(this).parent().find('[name=securities_account]').val();
           $.ajax({
               url: '/users/update-securities-account',
               type: 'post',
               data: {
                    id: {{ $user->id }},
                    securities_account: securities_account

               },
               beforeSend: function() {
                that.text('updating...');
               }
           })
           .done(function(data) {
               // that.text(real_text).attr('disabled', 'disabled');
               toastr.success(data);
           })
           .fail(function(error) {
               that.text(real_text);
               toastr.error(error.responseText);
           })
           .always(function() {
               that.text(real_text);
           });
           
       });

    })

    $('body').on('click', '.save_company', (e) => {
      let scope = $(e.target).closest('.panel');
      let btn = scope.find('.save_company').html('<i class="fa fa-spinner fa-pulse"></i>');
      let company_id = scope.find('select.select_company').val();
      let user_id = '{{ $user->id }}';
      if (company_id != '') {
        $.post('/admin/users/save_company', {user_id, company_id, _token: '{{ csrf_token() }}'}, function(data, status){
          // console.log(data);
          toastr.success('Applied successfully.');
          scope.find('.save_company').html('<i class="fa fa-save c-white"></i>');
        });
      }
    });
</script>
@endpush
