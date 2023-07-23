<!DOCTYPE html>
<html>
    <head>
        <title>Bal Tropical - Uw Ticket</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-inputs.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/ticket.css') }}">
        <script defer src="{{ asset('assets/js/qrcode.min.js') }}"></script>
        <script defer src="{{ asset('assets/js/ticket-page.js') }}"></script>
    </head>
    <body>
        <div id="container">
            <img id="logo" src="{{ asset('assets/media/images/big-logo.png') }}">
            <span id="print-logo">Bal Tropical</span>
            <div id="ticket">
                <div id="user-info">
                    <span id="name">{{ $ticket->firstname }} {{ $ticket->lastname }}</span>
                    <span id="birthdate">{{ $ticket->birthdate }} <strong>({{ date_diff(date_create($ticket->birthdate), date_create('now'))->y }} jaar)</strong></span>
                </div>
                <div id="qr-code"></div>
                <span id="ticket-id">#{{ $ticket->id }}</span>
            </div>

            <div id="rules">
                <span class="title">REGELS</span>
                <ul>
                    <li>Dit ticket is beveiligd. Kopi&euml;ren is niet mogelijk</li>
                    <li>Ticket geweigerd aan de ingang = nieuw ticket kopen aan de kassa zonder discussie.</li>
                </ul>
            </div>

            <div id="print-button">
                <img src="{{ asset('assets/media/images/print.png') }}" alt="">
                <span>Afdrukken</span>
            </div>
        </div>
        <div id="hellofood-print-text">
            <div>
                <img alt="Hellofood" src="{{ asset('assets/media/images/hellofood.png') }}">
                <p>Zin om eten te bestellen? Bestel nu op Hellofood.be en gebruik onderstaande promocode voor 10% korting op je eerste bestelling!</p>
                <div class="promocode">HFBALTROPICAL10</div>
            </div>
        </div>

        <div id="popup-background"></div>
        <div id="hellofood-popup">
            <div id="hellofood-popup-close-button" class="close-hellofood-popup">&times;</div>
            <div>
                <img alt="Hellofood" src="{{ asset('assets/media/images/hellofood.png') }}">
                <p>Zin om eten te bestellen? Bestel nu op Hellofood.be en gebruik onderstaande promocode voor 10% korting op je eerste bestelling!</p>
                <div class="promocode">HFBALTROPICAL10</div>
            </div>
            <div id="hellofood-popup-buttons">
                <a class="button next" target="_blank" href="https://hellofood.be">Naar Hellofood</a>
                <div class="button no close-hellofood-popup">Sluiten</div>
            </div>
        </div>
    </body>
</html>
