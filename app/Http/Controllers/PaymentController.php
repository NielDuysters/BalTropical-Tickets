<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mollie\Laravel\Facades\Mollie;
use App\Models\Ticket;
use DB;

class PaymentController extends Controller
{

    public function payment(Request $req) {
        $tickets = $req->json()->all();

        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => number_format((count($tickets) * floatval(get_settings()->price)), 2, '.', ''),
            ],
            "description" => "Tickets voor Bal Tropical.",
            "redirectUrl" => ENV('APP_URL') . "/check",
            "webhookUrl" => ENV('APP_URL') . "/payment/hook",
        ]);

        $payment->redirectUrl = ENV('APP_URL') . "/check/" . $payment->id;
        $payment->update();

        Log::info("Transactie met payment_id " . $payment->id . " is aangemaakt.");

        try {
            DB::beginTransaction();

            foreach ($tickets as $t) {
                $ticket = new Ticket;
                $ticket->firstname = $t['firstname'];
                $ticket->lastname = $t['lastname'];
                $ticket->email = $t['email'];
                $ticket->birthdate = $t['birthdate'];
                $ticket->accepted_agreements = $t['accepted_agreements'];
                $ticket->payment_id = $payment->id;
                $ticket->payment_status = "UNPAID";
                $ticket->code = bin2hex(openssl_random_pseudo_bytes(24));
                $ticket->from_current_user = $t['from_current_user'];
                $ticket->save();

                Log::info("Ticket #" . $ticket->id . " is aangemaakt.");
            }

            DB:: commit();
        } catch (\Throwable $e) {
            // An error occured
            DB::rollback();

            // and throw the error again.
            throw $e;

            return response(500);
        }

        return response($payment->getCheckoutUrl(), 200)
                  ->header('Content-Type', 'text/plain');
    }

    public function payment_hook(Request $req) {
        $payment_id = $req->input('id');
        $payment = Mollie::api()->payments->get($payment_id);

        if ($payment->isPaid()) {
            if (!$payment->hasRefunds() && !$payment->hasChargebacks()) {
                $tickets = Ticket::where("payment_id", $payment_id);
                $tickets->update([
                    "paid" => 1,
                    "payment_status" => "PAID",
                ]);

                foreach ($tickets->get() as $ticket) {
                    Log::info("Ticket #" . $ticket->id . " is betaald.");
                    send_ticket($ticket);
                    send_hellofood_mail($ticket);
                }
            } else {
                $tickets = Ticket::where("payment_id", $payment_id)->where("payment_status", "REFUNDING");
                $tickets->update([
                    "payment_status" => "REFUNDED",
                ]);

                foreach ($tickets->get() as $ticket) {
                    Log::info("Ticket #" . $ticket->id . " is terugbetaald.");
                    send_refund($ticket);
                }
            }
        } else {
            if (!$payment->hasRefunds() && !$payment->hasChargebacks()) {
                DB::table("tickets")
                    ->where("payment_id", $payment_id)
                    ->update([
                        "paid" => 0,
                        "payment_status" => strtoupper($payment->status),
                    ]);
            } else {
                DB::table("tickets")
                    ->where("payment_id", $payment_id)
                    ->where("payment_status", "REFUNDING")
                    ->update([
                        "payment_status" => "REFUNDFAIL",
                    ]);
            }
        }
    }

    public function check($payment_id) {
        $payment = Mollie::api()->payments->get($payment_id);
        if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
            $ticket = Ticket::where("payment_id", $payment_id)
                ->where("from_current_user", 1)
                ->first();
            return redirect()->route("ticket", ["code" => $ticket->code]);
        } else {
            return redirect()->route("failure");
        }
    }

    public function execute_refunds($key) {
        if ($key != env("SECRET_KEY")) {
            return false;
        }

        $to_refund = Ticket::selectRaw("COUNT(*) AS amount, payment_id")
            ->where(function($q) {
                $q->where("payment_status", "REFUNDING");
                $q->orWhere("payment_status", "REFUNDFAIL");
            })
            ->whereRaw("updated_at < (NOW() - INTERVAL 1 HOUR)")
            ->groupBy("payment_id")
            ->get();

        foreach ($to_refund as $r) {
            Log::info("Refund endpoint executed voor payment_id " . $r->payment_id . " met aantal: " . $r->amount . ".");

            $payment = Mollie::api()->payments->get($r->payment_id);
            $refund = $payment->refund([
                "amount" => [
                   "currency" => "EUR",
                   "value" => number_format($r->amount * floatval(get_settings()->price), 2, '.', ''),
                ]
            ]);
        }
    }
}
