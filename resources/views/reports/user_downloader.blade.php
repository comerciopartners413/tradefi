@extends('layouts.app')
@section('content')
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="view-header">

                            <div class="pull-right text-right" style="line-height: 14px">
                                <div class="row">

                                </div>

                            </div>
                            <!-- pull right -->
                            <div class="header-icon">

                                <i class="pe page-header-icon pe-7s-users"></i>
                            </div>
                            <div class="header-title">
                                <h3>Onboarding Downloader</h3>
                                <small>
                                Click the button below to download users that were onboarded
                            </small>
                            </div>

                        </div>
                        <hr>
                        <div class="panel panel-filled">
                            <div class="panel-body">
                                <div class="row">

                                    <div class="col-sm-6">
                                        <p>Download Excel</p>
                                        <a href="{{ url('download-users/xlsx') }}" class="btn btn-success">Download as Excel</a>
                                    </div>

                                    <div class="col-sm-6">
                                        <p>Download CSV</p>
                                        <a href="{{ url('download-users/csv') }}" class="btn btn-success">Download as CSV</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


       @endsection

@push('scripts')
   
@endpush