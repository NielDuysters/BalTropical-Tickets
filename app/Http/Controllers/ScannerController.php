<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mollie\Laravel\Facades\Mollie;
use App\Models\Ticket;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Session;

class ScannerController extends Controller
{
    public function scanner() {
        if (!Session::has("scanner_auth")) {
            return redirect()->route("scanner.login");
        }

        return view("scanner.scanner");
    }

    public function login() {
        if (Session::has("scanner_auth")) {
            return redirect()->route("scanner");
        }

        return view("scanner.login");
    }

    public function authenticate(Request $req) {
        $scanner_pass_hash = get_settings()->scanner_pass;

        if (!$req->filled("password")) {
            return redirect()->back()
            ->withErrors([
                'auth_failure' => "Geef een wachtwoord in.",
            ]);
        }

        if (Hash::check($req->get("password"), $scanner_pass_hash)) {
            Session::put("scanner_auth", true);
            return redirect()->route("scanner");
        }

        return redirect()->back()
        ->withErrors([
            'auth_failure' => "Fout wachtwoord.",
        ]);
    }

    public function download() {
        if (!Session::has("scanner_auth")) {
            return redirect()->route("scanner.login");
        }

        return view("scanner.download");
    }

    public function check(Request $req) {
        if (!Session::has("scanner_auth")) {
            return false;
        }

        if (!$req->filled("code")) {
            return false;
        }

        $ticket = Ticket::where("code", $req->get("code"))->first();

        $status = "OK";
        if ($ticket == NULL || $ticket->paid != 1 || $ticket->used == 1) {
            if ($ticket == NULL) {
                Log::info("Code " . $req->get("code") . " gescand maar geen ticket gevonden.");
            }
            if ($ticket->paid != 1) {
                Log::info("Ticket #" . $ticket->id . " gescand maar is niet betaald.");
            }
            if ($ticket->used == 1) {
                Log::info("Ticket #" . $ticket->id . " gescand maar was al gebruikt.");
            }

            $status = "NOK";
        } else {
            $ticket->used = 1;
            $ticket->save();

            Log::info("Ticket #" . $ticket->id . " gescand en toegelaten.");
        }


        return response()->json([
            'status' => $status,
            'ticket' => json_encode($ticket),
        ]);
    }
}
