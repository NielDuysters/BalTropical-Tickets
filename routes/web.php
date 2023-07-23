<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketSupportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ScannerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Pages
Route::get("/", [PageController::class, 'buy_tickets']);
Route::get("/gesloten", [PageController::class, 'shutdown'])->name("shutdown");
Route::get("/ticket-help", [PageController::class, 'ticket_help']);
Route::get("/404", [PageController::class, 'not_found'])->name("404");
Route::get("/fout", [PageController::class, 'failure'])->name("failure");
Route::get("/algemene-voorwaarden", [PageController::class, 'general_terms']);
Route::get("/privacyvoorwaarden", [PageController::class, 'privacyterms']);
Route::get("/faq", [PageController::class, 'faq']);


// Payment
Route::post("/payment", [PaymentController::class, 'payment']);
Route::post("/payment/hook", [PaymentController::class, 'payment_hook']);
Route::get("/check/{payment_id}", [PaymentController::class, 'check']);
Route::get("/refund/{key}", [PaymentController::class, 'execute_refunds']);

// Ticket
Route::get("/ticket/{code}", [TicketController::class, 'ticket'])->name("ticket");
Route::get("/ticket/{code}/agreements", function() {
    return redirect()->route("ticket");
});
Route::post("/ticket/{code}/agreements", [TicketController::class, 'accept_agreements']);

// Ticket Support
Route::get("/ticket-help", [TicketSupportController::class, 'index']);
Route::post("/ticket-help/resend-mail", [TicketSupportController::class, 'resend_mail']);
Route::post("/ticket-help/contact", [TicketSupportController::class, 'contact']);

// Admin
Route::get("/dashboard", [AdminLoginController::class, 'default'])->name("admin.dashboard");
Route::get("/dashboard/login", [AdminLoginController::class, 'login'])->name("admin.login");
Route::post("/dashboard/login", [AdminLoginController::class, 'authenticate']);
Route::get("/dashboard/tickets", [AdminController::class, 'tickets'])->name("admin.tickets");
Route::post("/dashboard/tickets", [AdminController::class, 'filter_tickets']);
Route::post("/dashboard/tickets/resend-email/{id}", [AdminController::class, 'resend_email']);
Route::post("/dashboard/tickets/refund/{id}", [AdminController::class, 'refund']);
Route::get("/dashboard/tickets/add", [AdminController::class, 'add_ticket_view']);
Route::post("/dashboard/tickets/add", [AdminController::class, 'add_ticket']);
Route::get("/dashboard/settings", [AdminController::class, 'settings_view'])->name("admin.settings");
Route::post("/dashboard/settings/price", [AdminController::class, 'settings_update_price']);
Route::post("/dashboard/settings/scanner-password", [AdminController::class, 'settings_update_scanner_password']);
Route::post("/dashboard/settings/empty-tickets", [AdminController::class, 'settings_empty_tickets']);
Route::post("/dashboard/settings/empty-logs", [AdminController::class, 'settings_empty_logs']);
Route::get("/dashboard/shutdown", [AdminController::class, 'shutdown_view'])->name("admin.shutdown");
Route::post("/dashboard/shutdown/toggle", [AdminController::class, 'shutdown_toggle']);
Route::post("/dashboard/shutdown/set-datetime", [AdminController::class, 'shutdown_datetime']);
Route::get("/dashboard/administrators", [AdminController::class, 'administrators_view'])->name("admin.all-administrators");
Route::get("/dashboard/administrators/add", [AdminController::class, 'add_administrator_view']);
Route::get("/dashboard/administrators/password", [AdminController::class, 'change_administrator_password_view']);
Route::post("/dashboard/administrators/password", [AdminController::class, 'change_administrator_password']);
Route::post("/dashboard/administrators/add", [AdminController::class, 'add_administrator']);
Route::get("/dashboard/administrators/edit/{id}", [AdminController::class, 'edit_administrator_view']);
Route::post("/dashboard/administrators/edit/{id}", [AdminController::class, 'edit_administrator']);
Route::get("/dashboard/administrators/delete/{id}", [AdminController::class, 'delete_administrator']);
Route::get("/dashboard/logs", [AdminController::class, 'view_logs']);
Route::get("/dashboard/logout", [AdminController::class, 'logout']);

// Scanner
Route::get("/scanner", [ScannerController::class, 'scanner'])->name("scanner");
Route::get("/scanner/login", [ScannerController::class, 'login'])->name("scanner.login");
Route::post("/scanner/login", [ScannerController::class, 'authenticate']);
Route::get("/scanner/download", [ScannerController::class, 'download']);
Route::post("/scanner/check", [ScannerController::class, 'check']);
