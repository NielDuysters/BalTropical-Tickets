<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Ticket;

function update_setting($property, $value) {
    $settings_file = json_decode(Storage::disk("local")->get("settings.json"));
    $settings_file->$property = $value;
    Storage::disk("local")->put("settings.json", json_encode($settings_file));
}

function get_settings() {
    return json_decode(Storage::disk("local")->get("settings.json"));
}
