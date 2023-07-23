<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mollie\Laravel\Facades\Mollie;
use App\Models\Ticket;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }

    public function login() {
        return view("admin.login");
    }

    public function dashboard() {
        return redirect()->route("admin.tickets");
    }

    public function tickets() {
        return view("admin.all-tickets")
            ->with("tickets", Ticket::all()->reverse());
    }

    public function filter_tickets(Request $req) {
        $tickets = Ticket::query();

        if ($req->filled("search-query")) {
            $tickets->where(function($q) use ($req) {
                $q
                ->where("firstname", "like", "%".$req->get("search-query")."%")
                ->orWhere("lastname", "like", "%".$req->get("search-query")."%")
                ->orWhere("email", "like", "%".$req->get("search-query")."%")
                ->orWhere("id", "like", "%".$req->get("search-query")."%")
                ->orWhere("payment_id", "like", "%".$req->get("search-query")."%");
            });
        }

        if ($req->filled("is-paid")) {
            $tickets->where("paid", $req->get("is-paid"));
        }

        if ($req->filled("payment-status")) {
            $tickets->where("payment_status", $req->get("payment-status"));
        }

        if ($req->filled("is-used")) {
            $tickets->where("used", $req->get("is-used"));
        }

        return view("admin.all-tickets")
            ->with("tickets", $tickets->get()->reverse());
    }

    public function resend_email($id) {
        return send_ticket(Ticket::find($id));
    }

    public function refund($id) {
        $tickets = Ticket::where("paid", 1)
            ->where("id", $id);

        if ($tickets->count() == 0) {
            return false;
        }

        $tickets->update([
            "payment_status" => "REFUNDING",
            "paid" => 0,
        ]);

        Log::info("Admin " . Auth::user()->name . " heeft een refund aangemaakt voor ticket # " . $id . ".");
    }

    public function add_ticket_view() {
        return view("admin.add-ticket");
    }

    public function add_ticket(Request $req) {
        for ($i = 0; $i < $req->get("amount"); $i++) {
            $ticket = new Ticket;
            $ticket->firstname = $req->get("firstname");
            $ticket->lastname = $req->get("lastname");
            $ticket->email = $req->get("email");
            $ticket->birthdate = $req->get("birthdate-year") . "-" . $req->get("birthdate-month") . "-" . $req->get("birthdate-day");
            $ticket->accepted_agreements = false;
            $ticket->payment_id = NULL;
            $ticket->payment_status = "MANUAL";
            $ticket->paid = 1;
            $ticket->code = bin2hex(openssl_random_pseudo_bytes(24));
            $ticket->from_current_user = false;
            $ticket->save();

            Log::info("Admin " . Auth::user()->name . " heeft ticket #" . $ticket->id . " toegevoegd.");

            send_ticket($ticket);
        }

        return redirect()->route("admin.tickets");
    }

    public function settings_view() {
        return view("admin.settings")
            ->with("settings", get_settings());
    }

    public function settings_update_price(Request $req) {
        update_setting("price", number_format(floatval(str_replace(",", ".", $req->get("price"))), 2, '.', ''));

        Log::info("Admin " . Auth::user()->name . " heeft de prijs aangepast.");
        return redirect()->route("admin.settings");
    }

    public function settings_update_scanner_password(Request $req) {
        update_setting("scanner_pass", Hash::make($req->get("password")));

        Log::info("Admin " . Auth::user()->name . " heeft de PIN voor de scanner aangepast.");
        return redirect()->route("admin.settings");
    }

    public function settings_empty_tickets() {
        Ticket::truncate();
        Log::info("Admin " . Auth::user()->name . " heeft alle tickets verwijdert.");
        return redirect()->route("admin.settings");
    }

    public function settings_empty_logs() {
        Log::info("Admin " . Auth::user()->name . " heeft alle logs verwijdert.");
        file_put_contents(storage_path()."/logs/laravel.log", "");
        return redirect()->route("admin.settings");
    }

    public function shutdown_view() {
        return view("admin.shutdown")
            ->with("settings", get_settings());
    }

    public function shutdown_toggle() {
        $settings = get_settings();

        if (is_shutdown($settings)) {
            update_setting("shutdown_datetime", "");
            update_setting("shutdown", false);
        } else {
            update_setting("shutdown", !$settings->shutdown);
        }

        Log::info("Admin " . Auth::user()->name . " heeft de shutdown verandert.");
        return redirect()->route("admin.shutdown");
    }

    public function shutdown_datetime(Request $req) {
        Log::info("Admin " . Auth::user()->name . " heeft de shutdown datetime verandert.");
        update_setting("shutdown_datetime", $req->get("shutdown-datetime"));
        return redirect()->route("admin.shutdown");
    }

    public function administrators_view() {
        return view("admin.all-administrators")
            ->with("admins", User::all());
    }

    public function add_administrator_view() {
        return view("admin.add-administrator");
    }

    public function add_administrator(Request $req) {
        if ($req->get("password") != $req->get("rp_password")) {
            return view("admin.add-administrators")
                ->with("error", "Wachtwoord is fout herhaald.");
        }

        $user = new User;
        $user->name = strtolower($req->get("name"));
        $user->email = strtolower($req->get("email"));
        $user->password = Hash::make($req->get("password"));

        if (!$user->save()) {
            return view("admin.add-administrator")
                ->with("error", "Er was een overwachte fout");
        }

        return redirect()->route("admin.all-administrators");
    }

    public function change_administrator_password_view() {
        return view("admin.password-administrator");
    }

    public function change_administrator_password(Request $req) {
        if ($req->get("password") != $req->get("rp_password")) {
            return view("admin.password-administrator")
                ->with("error", "Wachtwoord is fout herhaald.");
        }

        $user = Auth::user();
        $user->password = Hash::make($req->get("password"));
        if (!$user->save()) {
            return view("admin.password-administrator")
                ->with("error", "Er was een overwachte fout");
        }

        return redirect()->route("admin.all-administrators");
    }

    public function edit_administrator_view($id) {
        return view("admin.edit-administrator")
            ->with("admin", User::find($id));
    }

    public function edit_administrator($id, Request $req) {
        if  (!Auth::user()->super_admin) {
            return view("admin.edit-administrator")
                ->with("error", "Enkel de superadmin kan wachtwoorden wijzigen.");
        }

        if ($req->get("password") != $req->get("rp_password")) {
            return view("admin.edit-administrator")
                ->with("error", "Wachtwoord is fout herhaald.");
        }

        $user = User::find($id);
        $user->password = Hash::make($req->get("password"));
        if (!$user->save()) {
            return view("admin.edit-administrator")
                ->with("error", "Er was een overwachte fout");
        }

        return redirect()->route("admin.all-administrators");
    }

    public function delete_administrator($id) {
        $admin = User::find($id);

        if ($admin->super_admin) {
            return;
        }

        $admin->delete();
        return redirect()->route("admin.all-administrators");
    }

    public function view_logs() {
        return view("admin.logs")
            ->with("logs", file_get_contents(storage_path()."/logs/laravel.log"));
    }

    public function logout() {
        Auth::logout();
        return redirect()->route("admin.login");
    }
}
