<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mollie\Laravel\Facades\Mollie;
use App\Models\Ticket;
use DB;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    public function buy_tickets() {
        $settings = get_settings();

        if (is_shutdown($settings)) {
            return redirect()->route("shutdown");
        }

        return view("buy-tickets")
            ->with("settings", $settings);
    }

    public function shutdown() {
        return view("shutdown");
    }

    public function not_found() {
        return view('errors.404');
    }

    public function faq() {
        return view('faq');
    }

    public function failure() {
        return view("failure");
    }

    public function general_terms() {
        return view("algemene-voorwaarden");
    }
    public function privacyterms() {
        return view("privacyvoorwaarden");
    }
}
