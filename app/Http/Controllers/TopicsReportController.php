<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Topic;
use TradefiUBA\Report;
use Illuminate\Http\Request;
use TradefiUBA\Events\TopicReported;

class TopicsReportController extends Controller
{
    /**
     * Returns a Report for a Topic.
     * Utilized by ReportTopicComponent Vue component.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  TradefiUBA\Topic                $topic
     * @return Illuminate\Http\Response
     */
    public function status(Request $request, Topic $topic)
    {
        $report = Report::where('type', Topic::class)->where('content_id', $topic->id)->first();

        return response()->json($report, 200);
    }

    /**
     * Creates a Report for a Topic.
     * Utilized by ReportTopicComponent Vue component.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  TradefiUBA\Topic                $topic
     * @return Illuminate\Http\Response
     */
    public function report(Request $request, Topic $topic)
    {
        // no need for authorization, protected by auth middleware
        $report = new Report();
        $report->user_id = $request->user()->id;
        $report->content_id = $topic->id;
        $report->type = Topic::class;
        $report->save();

        event(new TopicReported($topic, $request->user()));

        return response()->json(null, 200);
    }
}
