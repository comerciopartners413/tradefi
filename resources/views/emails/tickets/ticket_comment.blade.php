<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Replied on your ticket with Ref no: {{ $comment->ticket->ticket_id }}</title>
</head>
<body>
    <p>
        @if($comment->user->admin)
        {{ $comment->ticket->profile->firstname }} has replied to ticket #{{ $comment->ticket->ticket_id }}.
        @else
        {{ $comment->ticket->profile->firstname }} has replied to ticket #{{ $comment->ticket->ticket_id }}.
       @endif
    </p> <hr>
    <p>
         {{  $comment->comment }}
    </p>

{{--     <p>Title: {{ $comment->ticket->details }}</p>
    <p>Status: {{ $comment->ticket->status }}</p> --}}

    <p>
        You can view the ticket at any time at {{ url('ticket/'. $comment->ticket->ticket_id) }}
    </p>

</body>
</html>