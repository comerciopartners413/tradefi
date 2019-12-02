@extends('layouts.app')
@push('styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css" media="screen">
<style>
.actionBtn {
    margin: 20px 0;
}
    .actionBtn button {
        margin-right: 10px
    }
</style>
@endpush
@section('content')
<div class="container-fluid">
   <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">
                            <div class="pull-right text-right" style="line-height: 14px">


                            </div>
                            <!-- pull right -->
                            <div class="header-icon">
                                <i class="pe page-header-icon pe-7s-display2"></i>
                            </div>
                            <div class="header-title">
                                <h3>Transaction Details</h3>
                                <small>  </small>
                            </div>

                            <div class="pull-right">
                                <a href="{{ url('/home') }}" class="btn btn-warning">Return to Homepage</a>
                                <button  data-toggle="modal" data-target="#fundmodal" class="btn btn-success">Make New Payment</button>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4">
                    </div>

                    <div class="col-md-4">
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-filled">
                           
                                <div class="panel-body">
                                    <table class="table datatable">
                                        <thead>
                                            <th>Customer Information</th>
                                            <th>Description</th>
                                            <th>CPAY Ref</th>
                                            <th>Amount</th>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>{{ $cust_info }}</td>
                                                <td>{{ $desc }}</td>
                                                <td>{{ $cpay_ref }}</td>
                                                <td>₦{{ number_format($amount, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

<script type = "text/javascript" >

       function preventBack(){window.history.forward();}

        setTimeout("preventBack()", 0);

        window.onunload=function(){null};

        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };

    </script>

@endpush
