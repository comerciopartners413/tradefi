<?php

namespace TradefiUBA\Http\Controllers;

use Auth;
use TradefiUBA\User;
use TradefiUBA\Post;
use TradefiUBA\Topic;
use TradefiUBA\GetMentionedUsers;
use TradefiUBA\Events\PostDeleted;
use Illuminate\Http\Request;
use TradefiUBA\Events\UsersMentioned;
use TradefiUBA\Events\UserPostedOnTopic;
use Illuminate\Support\Collection;
use TradefiUBA\Http\Requests\CreatePostFormRequest;
use TradefiUBA\Http\Requests\UpdatePostFormRequest;

class PostsController extends Controller
{

    /**
     * Creates a Post.
     *
     * @param  TradefiUBA\Http\Request\CreatePostFormRequest $request
     * @param  TradefiUBA\Topic                              $topic
     * @return Illuminate\Http\Response
     */
    public function create (CreatePostFormRequest $request, Topic $topic)
    {
        $post = new Post();
        $post->topic_id = $topic->id;
        $post->user_id = $request->user()->id;

        // change @username to markdown link
        // I.e. @username -> [@username](APP_URL/user/profile/@username)
        $url = env('APP_URL');
        $post->body = preg_replace('/\@\w+/', "[\\0]($url/user/profile/\\0)", $request->post);

        $post->save();

        // do @mention functionality
        $mentioned_users = GetMentionedUsers::handle($request->post);

        if (count($mentioned_users)) {
            event(new UsersMentioned($mentioned_users, $topic, $post));
        }

        event(new UserPostedOnTopic($topic, $post, $request->user()));

        return redirect()->route('forum.topics.topic.show', [
            'topic' => $topic,
        ]);
    }

    /**
     * Displays a form to edit a Post.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  TradefiUBA\Topic                $topic
     * @param  TradefiUBA\Post                 $post
     * @return Illuminate\Http\Response
     */
    public function edit (Request $request, Topic $topic, Post $post)
    {
        $this->authorize('edit', $post);

        return view('forum.topics.topic.posts.post.edit', [
            'topic' => $topic,
            'post' => $post,
        ]);
    }

    /**
     * Updates a Post.
     *
     * @param  TradefiUBA\Http\Requests\UpdatePostFormRequest  $request
     * @param  TradefiUBA\Topic                                $topic
     * @param  TradefiUBA\Post                                 $post
     * @return Illuminate\Http\Response
     */
    public function update (UpdatePostFormRequest $request, Topic $topic, Post $post)
    {
        $this->authorize('update', $post);

        $post->body = $request->post;
        $post->save();

        $mentioned_users = $this->getMentionedUsers($request);

        if (count($mentioned_users)) {
            event(new UsersMentioned($mentioned_users, $topic, $post));
        }

        return redirect()->route('forum.topics.topic.show', [
            'topic' => $topic,
        ]);
    }

    /**
     * Deletes a Post.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  TradefiUBA\Topic                $topic
     * @param  TradefiUBA\Post                 $post
     * @return Illuminate\Http\Response
     */
    public function destroy (Request $request, Topic $topic, Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        if ($post->user->id !== $request->user()->id) {
            event(new PostDeleted($post));
        }

        return redirect()->route('forum.topics.topic.show', [
            'topic' => $topic,
        ]);
    }

}
