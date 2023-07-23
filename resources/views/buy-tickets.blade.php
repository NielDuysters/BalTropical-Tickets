<!DOCTYPE html>
<html>
    <head>
        @include("partials.head", ["title" => "Ticket kopen"])

        <meta name="ticket-price" content="{{ $settings->price }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/buy-tickets.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/confirm.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/payment.css') }}">
        <script defer src="{{ asset('assets/js/ticket.js') }}"></script>
        <script defer src="{{ asset('assets/js/buy-tickets.js') }}"></script>
        <script defer src="{{ asset('assets/js/confirm.js') }}"></script>
        <script defer src="{{ asset('assets/js/payment.js') }}"></script>
    </head>
    <body>
        <div id="container">

            @include("partials.header")

            <main>
                <div id="all-tickets-container">
                    <span id="ticket-amount">Aantal tickets: <span id="ticket-amount-value">1</span></span>

                    <div id="all-tickets-list"></div>
                </div>
                <div id="progress"><div id="progress-bar"></div></div>
                <div id="screen-container">
                    <div class="screen" id="buy-tickets">
                        <span class="screen-title">Vul uw info in.</span>

                        <div class="form">
                            <div class="input-line half">
                                <input type="text" name="firstname" placeholder="Voornaam">
                                <input type="text" name="lastname" placeholder="Achternaam">
                            </div>
                            <div class="input-line">
                                <input type="email" name="email" placeholder="E-mailadres">
                            </div>
                            <div class="input-line half date-input-wrapper">
                                <span class="label">Geboortedatum</span>
                                <div class="date-wrapper">
                                    <input type="text" class="date-input" name="birthdate-day" placeholder="dag">
                                    <div class="date-input month dropdown" id="birthdate-month" data-value="">
                                        <input type="hidden" class="dropdown-value" name="birthdate-month" value="">
                                        <div class="selected">
                                            <span>Maand</span>
                                            <img class="dropdown-arrow" src="{{ asset('assets/media/images/down-arrow.png') }}" alt="">
                                        </div>
                                        <div class="options">
                                            <span data-value="1">Januari</span>
                                            <span data-value="2">Februari</span>
                                            <span data-value="3">Maart</span>
                                            <span data-value="4">April</span>
                                            <span data-value="5">Mei</span>
                                            <span data-value="6">Juni</span>
                                            <span data-value="7">Juli</span>
                                            <span data-value="8">Augustus</span>
                                            <span data-value="9">September</span>
                                            <span data-value="10">Oktober</span>
                                            <span data-value="11">November</span>
                                            <span data-value="12">December</span>
                                        </div>
                                    </div>
                                    <input type="text" class="date-input" name="birthdate-year" placeholder="jaar">
                                </div>
                            </div>

                            <span id="buy-tickets-error"><strong>Foutmelding: </strong>Niet alle velden zijn correct ingevuld.</span>
                        </div>

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <div class="button add-ticket"><img class="add-image" src="{{ asset('assets/media/images/basket.png') }}" alt=""> toevoegen</div>
                            </div>
                            <div class="price">Totale prijs: &euro;<span class="price-value">{{ str_replace(".", ",", $settings->price) }}</span></div>
                        </div>
                    </div>
                    <div class="screen" id="confirm">
                        <div class="confirm-top">
                            <span class="screen-title">Controleer of uw invoer correct is.</span>
                        </div>
                        <div id="ticket-confirmation-list"></div>
                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <div class="button goto prev" data-next="buy-tickets">Vorige</div>
                                <div class="button goto next" data-next="payment">Volgende</div>
                            </div>
                            <div class="price">Totale prijs: &euro;<span class="price-value">6,35</span></div>
                        </div>
                    </div>
                    <div class="screen" id="payment">
                        <span class="screen-title">Ga door naar betalen.</span>
                        <div class="screen-content">
                            <div id="price-container">
                                <span>Bedrag: &euro;<span id="price-value">0,00</span></span>
                            </div>
                            <p>
                                U kan nu betalen met Bancontact. Sluit het betaalvenster niet en houd uw bankkaart alvast bij de hand, u heeft slechts 10 minuten om de betaling te voltooien.
                            </p>
                        </div>
                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <div class="button goto prev" data-next="confirm">Vorige</div>
                                <div class="button payment next" id="payment-button"><img src="{{ asset('assets/media/images/bancontact.png') }}" alt=""> Betalen</div>
                            </div>
                        </div>

                        <div id="loading-screen">
                            <img src="{{ asset('assets/media/images/loading.svg') }}">
                        </div>
                    </div>
                </div>

                <a href="/ticket-help" id="ticket-error-url">Ticket gekocht maar niet ontvangen?</a>
            </main>

            @include("partials.footer")

        </div>
    </body>
</html>
