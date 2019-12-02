@extends('layouts.app')

@section('content')

<div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-note"></i>
                        </div>
                        <div class="header-title">
                            <h3>Forum</h3>
                            <small>
                                Join the conversation. Rub minds with other users in the TradeFi community
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="panel panel-filled">
                <div class="panel-heading">
                <span class="pull-left" style="color: #eee; font-size: 20px">
                    Topics
                </span>

                <div class="pull-right">
                    <a href="{{ route('forum.topics.create.form') }}"  class="btn btn-warning">Create a topic</a>
                </div>

                <div class="clearfix"></div>


                </div>

                <div class="panel-body" >
                    
                    <br />
                    <ul class="" style="padding-left: 0px;">
                        @if (count($topics))
                            @foreach ($topics as $topic)
                                <li class="panel panel-filled list-unstyled" style="padding: 15px ">
                                    <a style="font-size: 20px; color: #efdecd;" href="/forum/topics/{{ $topic->slug }}">{{ $topic->title }} <span style="    margin-left: 15px;border-color: orange;color: rgb(238, 238, 238);margin-top: -1px;" class="badge">{{ $topic->postCount() }}</span></a>
                                    <br />
                                    <strong>Created</strong> {{ Carbon\Carbon::createFromTimeStamp(strtotime($topic->created_at))->diffForHumans() }}
                                    <br />
                                    <strong>Last post</strong> {{ Carbon\Carbon::createFromTimeStamp(strtotime($topic->updated_at))->diffForHumans() }}
                                    @can ('delete', $topic)
                                        <form action="{{ route('forum.topics.topic.delete', $topic) }}" method="post">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-link danger-link"><span class="glyphicon glyphicon-remove"></span> Delete</button>
                                        </form>
                                    @endcan
                                </li>
                            @endforeach
                        @else
                            <br>
                            <p>There are currently no topics listed in the forum.</p>
                        @endif
                    </ul>
                </div>

            </div>
@endsection


