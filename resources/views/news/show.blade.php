@extends('layouts.app')
@push('styles')
<style>
    .panel-body > * {
        font-family: inherit !important;
        font-size: 14px !important;
        color: rgb(239, 222, 205) !important;
    }

    .panel-body > * > img {
        max-width: 500px !important;
    }
</style>
@endpush
@section('content')

<div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-note2"></i>
                        </div>
                        <div class="header-title">
                            <h3>{!! $news_item->title !!}</h3>
                            <small>
                               TradeFI News
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="panel panel-filled">
                <div class="panel-heading">
                <span class="pull-left" style="color: #eee; font-size: 20px">
                    {{-- News --}}
                </span>

                <div class="clearfix"></div>


                </div>
                <div class="panel-body">
                    {!! $news_item->body !!}
                    <br />
                    <ul class="" style="padding-left: 0px;">
                       
                    </ul>
                </div>

            </div>
@endsection


