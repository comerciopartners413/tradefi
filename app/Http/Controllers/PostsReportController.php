<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Post;
use TradefiUBA\Topic;
use TradefiUBA\Report;
use Illuminate\Http\Request;
use TradefiUBA\Events\PostReported;

class PostsReportController extends Controller
{
    /**
     * Returns a Report for a Post.
     * Utilized by ReportPostComponent Vue component.
     *
     * @param  TradefiUBA\Topic               $topic
     * @param  TradefiUBA\Post                $post
     * @return Illuminate\Http\Response
     */
    public function status (Topic $topic, Post $post)
    {
        $report = Report::where('type', Post::class)->where('content_id', $post->id)->first();

        return response()->json($report, 200);
    }

    /**
     * Creates a Report for a Post.
     * Utilized by ReportPostComponent Vue component.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  TradefiUBA\Topic                $topic
     * @param  TradefiUBA\Post                 $post
     * @return Illuminate\Http\Response
     */
    public function report (Request $request, Topic $topic, Post $post)
    {
        // no need for authorization, protected by auth middleware
        $report = new Report();
        $report->user_id = $request->user()->id;
        $report->content_id = $post->id;
        $report->type = Post::class;
        $report->save();

        event(new PostReported($topic, $post, $request->user()));

        return response()->json(null, 200);
    }
}
