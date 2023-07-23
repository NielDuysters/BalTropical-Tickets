<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mollie\Laravel\Facades\Mollie;
use App\Models\Ticket;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TicketSupportController extends Controller
{

    public function index() {
        return view('ticket-support');
    }

    public function resend_mail(Request $req) {
        $tickets = Ticket::where("email", $req->get("email"))->where("paid", 1)->get();

        if ($tickets->count() == 0) {
            return;
        }

        foreach ($tickets as $ticket) {
            send_ticket($ticket);
        }
    }

    public function contact(Request $req) {
        $file = $req->file('file');
        $file_name = "betaalbewijs-" . rand(1000, 100000) . "." . $file->extension();
        $x = $file->storeAs('ticket-support', $file_name);
		Log::info("x" . $x);

        $mail_body = $req->get("name") . " (" . $req->get("email") . ") meld het volgende probleem: <p>" . $req->get("description") . "</p>--------------------------------";
        send_mail(env("HELP_EMAIL_ADDRESS"), env("HELP_EMAIL_ADDRESS"), $req->get("email"), "Probleem met ticket van " . $req->get("name"), $mail_body, Storage::path("ticket-support/" . $file_name));

        File::delete(Storage::path("ticket-support/" . $file_name));
        return;
    }
}
