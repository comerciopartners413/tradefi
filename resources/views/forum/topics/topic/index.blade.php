@extends('layouts.app')
@push('styles')
<style>
    .post {
        border: 1px solid #efdecd47;
    }

    hr {
        border-top: 1px solid rgba(239, 222, 205, 0.25);
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/at.js/1.5.4/css/jquery.atwho.min.css">
@endpush
@section('content')
            <p><a href="{{ url('/forum') }}">&laquo; Back to your topics</a></p>
            <report-topic-button topic-slug="{{ $topic->slug }}" class="pull-right report-text report-topic"></report-topic-button>
            <div class="panel panel-filled">
                <div class="panel-heading" >
                    <div class="pull-left">
                        <h4>{{ $topic->title }}</h4>
                    {{ Carbon\Carbon::createFromTimeStamp(strtotime($topic->created_at))->diffForHumans() }} by <a href="/user/profile/{{ '@' . TradefiUBA\User::findOrFail($topic->user_id)->username }}">{{ '@' . TradefiUBA\User::findOrFail($topic->user_id)->username }}</a>
                    <br />
                    @can ('delete', $topic)
                        <form action="{{ route('forum.topics.topic.delete', $topic) }}" method="post">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-link danger-link"><span class="glyphicon glyphicon-remove"></span> Delete</button>
                        </form>
                    @endcan
                    </div>
                    @if (Auth::check())
                       <div class="pull-right">
                            <subscribe-button topic-slug="{{ $topic->slug }}"></subscribe-button>
                       </div>
                    @endif
                    <div class="clearfix"></div>
                    <br />
                    <span class="text-muted pull-right badge">{{ count($posts) }}</span>
                    <br />
                </div>

                <div class="panel-body">
                    @if (count($posts))
                        @foreach ($posts as $post)
                            <report-post-button topic-slug="{{ $topic->slug }}" post-id="{{ $post->id }}" class="pull-right report-text"></report-post-button>
                            <div class="post panel panel-filled" id="post-{{ $post->id }}" style="padding: 15px">
                               {{--  <img src="{{ Config::get('s3.buckets.images') . '/avatars/' . (TradefiUBA\User::findOrFail($post->user_id)->hasCustomAvatar() ?  TradefiUBA\User::findOrFail($post->user_id)->avatar : 'avatar-blank.png') }}" width="60" height="60" class="img-thumbnail pull-left" alt="{{ $topic->title }} image"/> --}} <small class="pull-left">{{ Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }} by <a href="/user/profile/{{ '@' . $user = TradefiUBA\User::findOrFail($post->user_id)->username }}"></a> <a href="/user/profile/{{ '@' . $user = TradefiUBA\User::findOrFail($post->user_id)->username }}">{{ '@' . $user = TradefiUBA\User::findOrFail($post->user_id)->username }}</a></small>
                                <br /> <hr>
                                <div style="font-size: 15px; color: #efdecd; margin-top: 10px">
                                    {!! GrahamCampbell\Markdown\Facades\Markdown::convertToHtml(
                                        $post->body
                                    ) !!}
                                </div>
                                @can ('edit', $post)
                                    <a href="{{ route('forum.topics.topic.posts.post.edit', [$topic, $post]) }}"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                                @endcan
                                @can ('delete', $post)
                                    <form class="inline" action="{{ route('forum.topics.topic.posts.post.delete', [$topic, $post]) }}" method="post">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-link danger-link"><span class="glyphicon glyphicon-remove"></span> Delete</button>
                                    </form>
                                @endcan
                            </div>
                        @endforeach
                    @else
                        <p>The are currently no posts for this topic.</p>
                    @endif

                    <br />
                    @if (Auth::check())
                        <form action="{{ route('forum.topics.posts.create.submit', $topic) }}" method="post">
                            <div class="form-group{{ $errors->has('post') ? ' has-error' : '' }}">
                                <label for="post" class="control-label">Your Reply</label>
                                <textarea name="post" id="post" class="form-control" placeholder="Your reply to {{ $topic->title }}" rows="8" required></textarea>
                                @if ($errors->has('post'))
                                    <div class="help-block danger">
                                        {{ $errors->first('post') }}
                                    </div>
                                @endif
                            </div>
                            <div class="help-block pull-left">
                                Feel free to use Markdown. Use @username to mention another user.
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-warning pull-right">Add Reply</button>
                        </form>
                    @else
                        <p style="text-align: center">Please <a href="{{ url('/register') }}">register</a> and <a href="{{ url('/login') }}">login</a> to join the conversation.</p>
                    @endif
                </div>

            </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Caret.js/0.3.1/jquery.caret.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/at.js/1.5.4/js/jquery.atwho.min.js"></script>
<script>
    $(function(){
        $('#post').atwho({
            at: "@",
            data: {!! $subscribers !!}
        });
    });
</script>
@endpush
