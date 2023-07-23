<!DOCTYPE html>
<html>
    <head>
        <title>Bal Tropical - Scanner</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/scanner/download.css') }}">
        <link rel="manifest" href="{{ asset('assets/js/scanner/manifest.json') }}">
        <script defer src="{{ asset('assets/js/scanner/download.js') }}"></script>
    </head>
    <body>
        <span id="title">Download</span>
        <div id="download-buttons">
            <img alt="Android" class="install-pwa" id="android" src="{{ asset('assets/media/images/scanner/android.png') }}">
            <img alt="iOS" class="install-pwa" id="ios" src="{{ asset('assets/media/images/scanner/ios.png') }}">
        </div>

        <a id="continue" href="/scanner?download=false">Of ga verder in de browser.</a>


        <div id="popup-background"></div>
        <div id="install-pwa-container">
            <div id="install-pwa-ios">Swipe naar boven in Safari zodat de knopjes vanonder zichtbaar worden. Klik op <img alt="het middelste icoontje" src="/assets/media/images/scanner/safari-icon-1.png"> vanonder op je scherm en vervolgens op <img alt="[+]" src="/assets/media/images/scanner/safari-icon-2.png"> <i>Zet op beginscherm</i> om de app te installeren op je iPhone. <div class="close-install-popup">&times;</div></div>
            <div id="install-pwa-android">Open deze pagina in Chrome. Klik op <img alt="de drie puntjes in Chrome" src="/assets/media/images/scanner/android-icon-1.png"> rechtsboven in je browser en vervolgens op <i>App installeren</i> om de app te installeren op je Android. <div class="close-install-popup">&times;</div></div>
        </div>
    </body>
</html>
