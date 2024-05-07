<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public function index()
    {
        // $tickets = (auth()->user()->role_id == 1) ? Ticket::all() : Ticket::where('created_by', Auth::id())->get();
        $tickets = Ticket::all();
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        try {
            $ticket = Ticket::create([
                'title' => $request->title,
                'description' => $request->description,
                'priority' => $request->priority,
                'created_by' => Auth::id(),
            ]);
            if ($ticket) {
                Log::channel('gestion_ticket_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a créé le ticket' . $ticket->title);
                return redirect()->route('tickets.show', $ticket->id);
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_ticket_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé de créer le ticket ' . $request->title . ' sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    public function show(Ticket $ticket)
    {
        $messages = $ticket->messages()->with('user')->get();
        return view('tickets.show', compact('ticket', 'messages'));
    }

    public function addMessage(Request $request, Ticket $ticket)
    {
        try {
            //code...
            $message = TicketMessage::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'content' => $request->content,
            ]);
            // Update ticket status or other logic as needed
            // ...
            if ($message) {
                Log::channel('gestion_ticket_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a ajouté un message au ticket ' . $ticket->title);
                return redirect()->route('tickets.show', $ticket->id);
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_ticket_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé d\'ajouter un message au ticket ' . $ticket->title . 'sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }
    /**
     * Display a listing of the resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }


    public function search(Request $request)
    {
        try {
            // die($request);
            if ($request->ajax()) {
            }
            $output = "";
            $tickets = DB::table('tickets')->where('title', 'LIKE', '%' . $request->searchticket . "%")->get();
            if ($tickets) {
                foreach ($tickets as $key => $ticket) {
                    // $url = asset($ticket->image);
                    $output .= '<tr>
                    <td>
                        <a href="/gestion_tickets/tickets/'. $ticket->id.'>'. 
                            $ticket->title
                       .' </a>
                    </td>
                </tr>';
                }
            }
            return Response($output);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
        // return  json_encode($pharmacies, JSON_PRETTY_PRINT);
    }
}
