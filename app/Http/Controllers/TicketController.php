<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get tickets owned by the authenticated user
        $ownedTickets = Ticket::where('assigned_to', $user->id)->get();

        // Get tickets assigned to the authenticated user
        $assignedTickets = Ticket::whereHas('assignedUsers', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        // Merge both collections and remove duplicates
        $tickets = $ownedTickets->merge($assignedTickets)->unique('id');
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $users = User::all();
        return view('tickets.create', compact('users'));
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'description' => 'required|string',
                'assigned_users' => 'required|array',
                'assigned_users.*' => 'exists:users,id'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }
            // dd($request);

            $ticket = Ticket::create([
                'title' => $request->title,
                'description' => $request->description,
                'priority' => $request->priority,
                'assigned_to' => auth()->user()->id
            ]);
            if ($ticket) {
                $ticket->assignedUsers()->attach($request->assigned_users);
                foreach ($request->assigned_users as  $value) {
                    $user = User::where('id', $value)->first();
                    $email = $user->email;
                    $name = $user->lastname . ' ' . $user->firstname;
                    $author = auth()->user()->lastname . ' ' . auth()->user()->firstname;
                    $subject = $author . " vous a ajouté à une discussion";
                    $link =  route('tickets.show', $ticket->id);
                    Mail::send(
                        'email.ticket_create',
                        ['name' => $name, 'ticket' => $ticket, 'author' => $author, 'link' => $link],
                        function ($mail) use ($email, $name, $subject) {
                            $mail->from(getenv('MAIL_FROM_ADDRESS'), "HOPITAL SAINT ANTOINE DE PADOUE");
                            $mail->to($email, $name);
                            $mail->subject($subject);
                        }
                    );
                }

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
        // dd($ticket->assignedUsers());
        $messages = $ticket->messages()->with('user')->get();
        // dd($messages[1]->replies);
        return view('tickets.show', compact('ticket', 'messages'));
    }

    public function addMessage(Request $request, Ticket $ticket)
    {
        try {
            $validator = Validator::make($request->all(), [
                'content' => 'required',
                'parent_id' => 'nullable|exists:ticket_messages,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }

            $message = TicketMessage::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'content' => $request->content,
                'parent_id' => $request->parent_id, // Store parent_id if it's a reply
            ]);
            
             // ...
            if ($message) {
                foreach ($ticket->assignedUsers()->get() as  $value) {
                    $content = strip_tags(($message->content));
                    $email = $value->email;
                    $name = $value->lastname . ' ' . $value->firstname;
                    $author = auth()->user()->lastname . ' ' . auth()->user()->firstname;
                    $subject = $author . " a ajouté un message à une discussion";
                    $link =  route('tickets.show', $ticket->id);

                    Mail::send(
                        'email.ticket_message',
                        ['name' => $name, 'ticket' => $ticket, 'author' => $author, 'link' => $link, 'sms' => strip_tags($content)],
                        function ($mail) use ($email, $name, $subject) {
                            $mail->from(getenv('MAIL_FROM_ADDRESS'), "HOPITAL SAINT ANTOINE DE PADOUE");
                            $mail->to($email, $name);
                            $mail->subject($subject);
                        }
                    );
                }
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
        $users = User::all();
        $personnes = $ticket->assignedUsers()->get();
        return view('tickets.edit', ['users' => $users, 'ticket' => $ticket, 'personnes' => $personnes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        try {

            $validator = Validator::make($request->all(), [
                'title' => 'nullable|string',
                'description' => 'nullable|string',
                'assigned_users' => 'nullable|array',
                'assigned_users.*' => 'exists:users,id'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors());
            }
            // dd($request);

            $ticket->update([
                'title' => $request->title,
                'description' => $request->description,
                'priority' => $request->priority,
                'assigned_to' => auth()->user()->id
            ]);
            if ($ticket) {
                $ticket->assignedUsers()->sync($request->assigned_users);
                foreach ($request->assigned_users as  $value) {
                    $user = User::where('id', $value)->first();
                    $email = $user->email;
                    $name = $user->lastname . ' ' . $user->firstname;
                    $author = auth()->user()->lastname . ' ' . auth()->user()->firstname;
                    $subject = $author . " vous a ajouté à un ou plusieurs membres à la discussion";
                    $link =  route('tickets.show', $ticket->id);
                    Mail::send(
                        'email.ticket_addperson',
                        ['name' => $name, 'ticket' => $ticket, 'author' => $author, 'link' => $link],
                        function ($mail) use ($email, $name, $subject) {
                            $mail->from(getenv('MAIL_FROM_ADDRESS'), "HOPITAL SAINT ANTOINE DE PADOUE");
                            $mail->to($email, $name);
                            $mail->subject($subject);
                        }
                    );
                }

                Log::channel('gestion_ticket_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a ajouté des membres à la discussion ' . $ticket->title);
                return redirect()->route('tickets.show', $ticket->id);
            }
        } catch (\Throwable $th) {
            Log::channel('gestion_ticket_log')->info(auth()->user()->lastname . ' ' . auth()->user()->firstname . ' a essayé d\'ajouter des membres à la discussion ' . $request->title . ' sans succès');
            return redirect()->back()->with('errors', $th->getMessage());
        }
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
                        <a href="/gestion_tickets/tickets/' . $ticket->id . '>' .
                        $ticket->title
                        . ' </a>
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
