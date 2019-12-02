@extends('layouts.app')

@section('content')
            <div class="panel panel-filled">
                <div class="panel-heading" style="font-size: 20px">Create a Topic</div>

                <div class="panel-body">
                    <form action="{{ route('forum.topics.create.submit') }}" method="post">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="control-label">Topic Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ (old('title') ? old('title') : '' ) }}" placeholder="Your post's title">
                            @if ($errors->has('title'))
                                <div class="help-block danger">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                            <div class="help-block">
                                <p>All titles need to be unique.</p>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('post') ? ' has-error' : '' }}">
                            <label for="post" class="control-label">Your Post</label>
                            <textarea name="post" id="post" class="form-control" placeholder="Be expressive" rows="8">{{ (old('post') ? old('post') : '' ) }}</textarea>
                            @if ($errors->has('post'))
                                <div class="help-block danger">
                                    {{ $errors->first('post') }}
                                </div>
                            @endif
                        </div>
                        <div class="help-block pull-left">
                            Feel free to use Markdown.
                        </div>
                        <div class="form-group checkbox pull-right">
                            <label for="subscribe">
                                <input type="checkbox" name="subscribe" id="subscribe" style="margin-top:4px; padding: 8px" checked> &nbsp; Subscribe to topic?
                            </label>
                        </div>
                        <br />
                        <br />
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-warning">Create Topic</button>
                    </form>
                </div>

            </div>
@endsection
