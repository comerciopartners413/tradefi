<?php

namespace TradefiUBA\Http\Controllers;

use TradefiUBA\Mail\SendTicketInformation;
use TradefiUBA\Notifications\ClosedTicket;
use TradefiUBA\Ticket;
use TradefiUBA\TicketCategory;
use Illuminate\Http\Request;
use Pusher\PushNotifications\PushNotifications as PN;

class TicketController extends Controller
{

    public function index()
    {
        $tickets         = auth()->user()->profile->tickets;
        $pending_tickets = count($tickets->where('status', 0));
        $open_tickets    = count($tickets->where('status', 1));
        $closed_tickets  = count($tickets->where('status', 2));

        $categories = TicketCategory::all();
        // dd($ticket_types);
        return view('tickets.index', compact('tickets', 'pending_tickets', 'open_tickets', 'closed_tickets', 'categories'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'details' => 'required',
        ]);
        $ticket             = new Ticket($request->all());
        $ticket->ticket_id  = strtoupper(str_random(10));
        $ticket->profile_id = auth()->user()->profile->id;
        $sender             = auth()->user();
        if ($ticket->save()) {
            // Send mail to User
            // check type of ticket

            if ($ticket->category->name == 'Technical') {
                \Mail::to('info@tradefi.ng')->queue(new SendTicketInformation($sender, $ticket));
            } elseif ($ticket->category->name == 'Transactions') {
                \Mail::to('settlement@tradefi.ng')->queue(new SendTicketInformation($sender, $ticket));
            } elseif ($ticket->category->name == 'Reconciliation') {
                \Mail::to('settlement@tradefi.ng')->queue(new SendTicketInformation($sender, $ticket));
            } elseif ($ticket->category->name == 'Settlement') {
                \Mail::to('settlement@tradefi.ng')->queue(new SendTicketInformation($sender, $ticket));
            } elseif ($ticket->category->name == 'Others') {
                \Mail::to('info@tradefi.ng')->queue(new SendTicketInformation($sender, $ticket));
            }
            \Mail::to($sender->email)->queue(new SendTicketInformation($sender, $ticket));
            return redirect()->route('ticket.index')->with('success', 'Ticket has been sent successfully');
        } else {
            return response()->json([
                'errors' => $this->validate()->errors(),
            ]);
            return back()->withInput()->with('error', 'Ticket was not sent');
        }
    }

    public function show($id)
    {
        $ticket = Ticket::where('ticket_id', $id)->first();

        $ticket_comments = $ticket->comments;
        // dd($ticket_comments);
        return view('tickets.show', compact('ticket', 'ticket_comments'));
    }

    public function show_ticket_admin($id)
    {
        if (\Entrust::hasRole(['ops_authorizer', 'ops_initiator', 'admin', 'super_admin'])) {
            $ticket = Ticket::where('ticket_id', $id)->first();
            // $ticket_comments = $ticket->comments;
            $ticket_comments = $ticket->comments;
            // dd($ticket_comments);
            return view('tickets.show', compact('ticket', 'ticket_comments'));
        } else {
            return back()->with('error', 'You don\'t have permissions');
        }
    }

    public function tickets_admin()
    {
        if (\Entrust::hasRole(['ops_authorizer', 'ops_initiator', 'admin', 'super_admin'])) {
            $tickets        = Ticket::where('status', 1)->orWhere('status', 0)->get();
            $closed_tickets = Ticket::where('status', 2)->get();

            // dd($pending_tickets);
            return view('admin.tickets.index', compact('tickets', 'open_tickets', 'closed_tickets'));
        } else {
            return back()->with('error', 'You don\'t have permisions');
        }
    }

    public function close(Request $request, $id)
    {
        if (\Entrust::hasRole(['ops_authorizer', 'ops_initiator', 'admin', 'super_admin'])) {
            $ticket = Ticket::where('ticket_id', $id)->update([
                'status' => 2,
            ]);
            $ticket_ = Ticket::where('ticket_id', $id)->first();
            $ticket_->profile->user->notify(new ClosedTicket($ticket_));
            activity()
                ->performedOn($ticket_)
                ->causedBy($ticket_->profile->user->id)
                ->log('We have rectified your issue with ticket id <span style="color: #d8c180;">' . $ticket_->ticketid . '</span>');
            // send response to pusher beamer
            $pushNotifications = new PN([
                'instanceId' => env('PUSHER_PN_INSTANCE_ID'),
                'secretKey'  => env('PUSHER_PN_SECRET_KEY'),
            ]);

            $publishResponse = $pushNotifications->publish(['private.' . $ticket_->profile->user->id],
                array("fcm" => array("notification" => array(
                    "title" => "Ticket Closed",
                    "body"  => 'Your Ticket with ID #' . $id . ' has been closed',
                ),
                    "data"                              => [
                        'type' => 'ticket',
                    ]),
                ));
            return redirect('/admin/tickets')->with('success', 'Ticket was closed sucessfully');

        } else {
            return back()->with('error', 'You don\'t have permisions');
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
