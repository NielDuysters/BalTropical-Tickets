<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Ticket;

function send_mail($to, $from, $reply_to, $subject, $message, $attachment = null) {
    $mail = new PHPMailer;
    $mail->isSendmail();
    $mail->addReplyTo($reply_to, $reply_to);
    $mail->setFrom($from, $from);
    $mail->addAddress($to, $to);
    if ($attachment != null) {
        $mail->addAttachment($attachment);
    }
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->IsHTML(true);
    $mail->Host = "127.0.0.1";
    $mail->Mailer = "smtp";
    $mail->Port = 1025;
    if(!$mail->send()) {
        Log::error("Fout bij verzenden van mail naar " . $to . " " . $mail->ErrorInfo);
    } else {
        Log::info("Mail verzonden naar " . $to . ".");
    }
}

function send_ticket($ticket) {
    $html = Storage::get("./public/email/send-ticket.html");
    $html = str_replace("%firstname%", $ticket->firstname, $html);
    $html = str_replace("%url%", env("APP_URL") . "/ticket/" . $ticket->code, $html);

    $mail = new PHPMailer;
    $mail->isSendmail();
    $mail->addReplyTo(env("HELP_EMAIL_ADDRESS"), env("HELP_EMAIL_ADDRESS"));
    $mail->setFrom("noreply@baltropical.be", "noreply@baltropical.be");
    $mail->addAddress($ticket->email, $ticket->email);
    $mail->Subject = "Uw ticket voor Bal Tropical.";
    $mail->Body = $html;
    $mail->IsHTML(true);
    $mail->AddEmbeddedImage("assets/media/images/big-logo.png", 'baltropical-logo', 'baltropical.png');
    $mail->AddEmbeddedImage("assets/media/images/facebook-email.png", 'facebook-logo', 'facebook.png');
    $mail->Host = "127.0.0.1";
    $mail->Mailer = "smtp";
    $mail->Port = 1025;
    if(!$mail->send()) {
        Log::error("Fout bij verzenden van ticket mail (#".$ticket->id.") naar " . $ticket->email . " " . $mail->ErrorInfo);
        return false;
    }

    Log::info("Ticket (#".$ticket->id.") mail verzonden naar " . $ticket->email . ".");
    return true;
}

function send_refund($ticket) {
    $html = Storage::get("./public/email/send-refund.html");
    $html = str_replace("%firstname%", $ticket->firstname, $html);

    $mail = new PHPMailer;
    $mail->isSendmail();
    $mail->addReplyTo(env("HELP_EMAIL_ADDRESS"), env("HELP_EMAIL_ADDRESS"));
    $mail->setFrom("noreply@baltropical.be", "noreply@baltropical.be");
    $mail->addAddress($ticket->email, $ticket->email);
    $mail->Subject = "Uw ticket voor Bal Tropical is terugbetaald.";
    $mail->Body = $html;
    $mail->IsHTML(true);
    $mail->AddEmbeddedImage("assets/media/images/big-logo.png", 'baltropical-logo', 'baltropical.png');
    $mail->AddEmbeddedImage("assets/media/images/facebook-email.png", 'facebook-logo', 'facebook.png');
    $mail->Host = "127.0.0.1";
    $mail->Mailer = "smtp";
    $mail->Port = 1025;
    if(!$mail->send()) {
        Log::error("Fout bij verzenden van ticket refund mail (#".$ticket->id.") naar " . $ticket->email . " " . $mail->ErrorInfo);
        return false;
    }

    Log::info("Ticket (#".$ticket->id.") refund mail verzonden naar " . $ticket->email . ".");
    return true;
}

function send_hellofood_mail($ticket) {
    $html = Storage::get("./public/email/send-hellofood-mail.html");
    $html = str_replace("%firstname%", $ticket->firstname, $html);

    $mail = new PHPMailer;
    $mail->isSendmail();
    $mail->setFrom("noreply@baltropical.be", "noreply@baltropical.be");
    $mail->addAddress($ticket->email, $ticket->email);
    $mail->Subject = "Bal Tropical - Bestel bij Hellofood.";
    $mail->Body = $html;
    $mail->IsHTML(true);
    $mail->AddEmbeddedImage("assets/media/images/hellofood.png", 'hellofood-logo', 'hellofood.png');
    $mail->AddEmbeddedImage("assets/media/images/facebook-email.png", 'facebook-logo', 'facebook.png');
    $mail->Host = "127.0.0.1";
    $mail->Mailer = "smtp";
    $mail->Port = 1025;
    $mail->send();
    return true;
}
