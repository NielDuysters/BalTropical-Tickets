<!DOCTYPE html>
<html>
    <head>
        @include("partials.head", ["title" => "Veelgestelde vragen."])
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/faq.css') }}">
        <script defer src="{{ asset('assets/js/faq.js') }}"></script>
    </head>
    <body>
        <div id="container">

            @include("partials.header")

            <main>
                <div id="progress"><div id="progress-bar"></div></div>
                <div id="screen-container">
                    <div class="screen" id="faq">
                        <span class="screen-title">Veelgestelde vragen.</span>

                        <div class="screen-content">
                            <a class="accordion-toggle">Ik heb een ticket gekocht maar niet ontvangen.</a>
                            <div class="accordion-content">
                                <p>
                                    Vervelend om te horen! Controleer zeker eerst je spam. Als je ticket ook daar niet ziet kan je naar onze <a target="_blank" href="/ticket-help">hulp-pagina</a> gaan.
                                </p>
                            </div>
                            <a class="accordion-toggle">Ik heb hulp nodig bij de aankoop.</a>
                            <div class="accordion-content">
                                  <p>
                                      Probeer eerst onze <a target="_blank" href="/ticket-help">hulp-pagina</a>. Als dat je niet verder helpt kan je ons mailen op <a target="_blank" href="mailto:help@baltropical.be">help@baltropical.be</a>.
                                  </p>
                            </div>
                            <a class="accordion-toggle">Kan een ticket terugbetaald worden?</a>
                            <div class="accordion-content">
                                  <p>
                                     In sommige gevallen is dit mogelijk. Mail hiervoor naar <a target="_blank" href="mailto:help@baltropical.be">help@baltropical.be</a>.
                                  </p>
                            </div>
                            <a class="accordion-toggle">Kan ik meerdere tickets kopen?</a>
                            <div class="accordion-content">
                                  <p>
                                    Ja zeker! Je kan meerdere tickets toevoegen en dan op "volgende" klikken om deze samen af te rekenen.
                                  </p>
                            </div>
                            <a class="accordion-toggle">Kan ik mijn ticket doorgeven?</a>
                            <div class="accordion-content">
                                  <p>
                                      Dit is mogelijk. Let er wel op dat elk ticket slechts eenmaal geldig is. Een ticket doorgeven is op eigen risico. Als iemand anders eerst incheckt met je ticket, kan je zelf niet meer inchecken.
                                  </p>
                            </div>
                            <a class="accordion-toggle">Kan de QRCode op mijn ticket kopi&euml;ren?</a>
                            <div class="accordion-content">
                                  <p>
                                      Dit is niet mogelijk. De QRCode op de tickets zijn beveiligd.
                                  </p>
                            </div>
                            <a class="accordion-toggle">Is betalen veilig?</a>
                            <div class="accordion-content">
                                  <p>
                                      Alle betalingen verlopen veilig via Mollie en worden gedaan over een versleutelde SSL-verbinding.
                                  </p>
                            </div>
                            <a class="accordion-toggle">Welke betaalmogelijkheden zijn er?</a>
                            <div class="accordion-content">
                                  <p>
                                      Je kan betalen met Bancontact.
                                  </p>
                            </div>
                            <a class="accordion-toggle">Ik wil contact opnemen.</a>
                            <div class="accordion-content">
                                  <p>
                                      Je kan ons mailen op <a target="_blank" href="mailto:help@baltropical.be">help@baltropical.be</a>.
                                  </p>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="/ticket-help" id="ticket-error-url">Ticket gekocht maar niet ontvangen?</a>
            </main>

            @include("partials.footer")

        </div>
    </body>
</html>
