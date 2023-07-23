<!DOCTYPE html>
<html>
    <head>
        <title>Bal Tropical - Scanner</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="initial-scale=1, viewport-fit=cover, width=device-width">
        <meta name="apple-mobile-web-app-capable" content="yes"></meta>
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"></meta>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/scanner/scanner.css') }}">
        <script defer type="module" src="{{ asset('assets/js/scanner/scanner.js') }}"></script>
    </head>
    <body>
        <video id="camera"></video>

        <img alt="Herladen" src="{{ asset('assets/media/images/scanner/reload.png') }}" id="reload">

        <div id="response">
            <img id="status" src="{{ asset('assets/media/images/scanner/waiting.png') }}">
            <span id="user"><span id="name"></span> <span id="age"></span></span>
            <span id="ticket-id"></span>
            <span id="error"></span>
        </div>
    </body>
</html>
