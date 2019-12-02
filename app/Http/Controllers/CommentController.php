<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Mail\SendTicketComment;
use TradefiUBA\TicketComment;
use Illuminate\Http\Request;
use Pusher\PushNotifications\PushNotifications as PN;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $comment          = new TicketComment($request->all());
        $comment->user_id = auth()->user()->id;
        if (auth()->user()->id == 1) {
            $comment->ticket->update(['status' => 1]);
        }
        if ($comment->save()) {
            // if ($comment->ticket->profile->id !== auth()->user()->id) {
            $owner = $comment->ticket->profile->user;
            // update ticket to open
            $comment->ticket->update([
                'status' => 1,
            ]);
            \Mail::to($owner->email)->queue(new SendTicketComment($owner, $comment));
            if (auth()->user()->admin) {
                $pushNotifications = new PN([
                    'instanceId' => env('PUSHER_PN_INSTANCE_ID'),
                    'secretKey'  => env('PUSHER_PN_SECRET_KEY'),
                ]);

                $publishResponse = $pushNotifications->publish(['private.' . $comment->ticket->profile->user->id],
                    array("fcm" => array("notification" => array(
                        "title" => "Ticket Reply",
                        "body"  => 'Update on Ticket #' . $comment->ticket->ticket_id,
                    ),
                        "data"                              => [
                            'type'      => 'ticket',
                            'ticket_id' => $comment->ticket->ticket_id,
                            'subject'   => $comment->ticket->details,
                            'data'      => $comment->comment,
                            'admin'     => auth()->user()->admin == 1 ? 1 : 0,
                        ]),
                    ));
                return redirect("/admin/tickets/{$comment->ticket->ticket_id}")->with('success', 'Comment was posted');
            }
            $pushNotifications = new PN([
                'instanceId' => env('PUSHER_PN_INSTANCE_ID'),
                'secretKey'  => env('PUSHER_PN_SECRET_KEY'),
            ]);

            $publishResponse = $pushNotifications->publish(['private.' . $comment->ticket->profile->user->id],
                array("fcm" => array("notification" => array(
                    "title" => "Ticket Reply",
                    "body"  => 'Update on Ticket #' . $comment->ticket->ticket_id,
                ),
                    "data"                              => [
                        'type'      => 'ticket',
                        'ticket_id' => $comment->ticket->ticket_id,
                        'subject'   => $comment->ticket->details,
                        'data'      => $comment->comment,
                        'admin'     => auth()->user()->admin == 1 ? 1 : 0,
                    ]),
                ));
            return redirect("/ticket/{$comment->ticket->ticket_id}")->with('success', 'Comment was posted');
            // }

        } else {
            // return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
