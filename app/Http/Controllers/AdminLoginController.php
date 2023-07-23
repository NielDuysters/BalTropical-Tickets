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

class AdminLoginController extends Controller
{

    public function default() {
        if (Auth::user()) {
            return redirect()->route("admin.tickets");
        }

        return redirect()->route("admin.login");
    }

    public function login() {
        return view("admin.login");
    }

    public function authenticate(Request $request) {
        if (Auth::attempt(['name' => $request->get("name"), 'password' => $request->get("password")])) {
            Log::info("Admin " . $request->get("name") . " is ingelogd.");
            return redirect()->route("admin.dashboard");
        }

        return redirect()->back()
        ->withErrors([
            'auth_failure' => "Foute gebruikersnaam of wachtwoord.",
        ]);
    }
}
