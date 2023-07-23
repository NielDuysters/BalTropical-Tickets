<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mollie\Laravel\Facades\Mollie;
use App\Models\Ticket;
use DB;

class TicketController extends Controller
{
    public function ticket($code) {
        $ticket = Ticket::where("code", $code)->first();

        if ($ticket == null || !$ticket->paid) {
            return redirect()->route("404");
        }

        if (!$ticket->accepted_agreements) {
            return view("accept-agreements")
                ->with("ticket", $ticket);
        }

        return view("ticket")
            ->with("ticket", $ticket);
    }

    public function accept_agreements($code, Request $req) {
        $ticket = Ticket::where("code", $code)->first();

        if ($ticket == null || !$ticket->paid) {
            return redirect()->route("404");
        }

        $accepted = false;
        if ($req->get("agreements")) {
            $accepted = true;
        }

        if (date_diff(date_create($ticket->birthdate), date_create('now'))->y < 16) {
            if ($accepted && $req->get("underaged")) {
                $accepted = true;
            } else {
                $accepted = false;
            }
        }

        if ($accepted) {
            $ticket->accepted_agreements = true;
            $ticket->save();
            return redirect()->route("ticket", ["code" => $ticket->code]);
        } else {
            return view("accept-agreements")
                ->with("ticket", $ticket)
                ->with("error", "Accepteer de voorwaarden.");
        }
    }
}
