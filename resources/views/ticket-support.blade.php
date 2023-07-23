<!DOCTYPE html>
<html>
    <head>
        @include("partials.head", ["title" => "Hulp bij ticket"])

        <script defer src="{{ asset('assets/js/ticket-support.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/ticket-support.css') }}">
    </head>
    <body>
        <div id="container">

            @include("partials.header")

            <main>
                <div id="progress"><div id="progress-bar"></div></div>
                <div id="screen-container">
                    <div class="screen" id="start-support">
                        <span class="screen-title">Hulp bij ticket.</span>

                        <div class="screen-content">
                            Vervelend om te horen dat je problemen ondervindt met je ticket! Laten we je even helpen.
                        </div>

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <div class="button next goto" data-next="is-paid">Volgende</div>
                            </div>
                        </div>
                    </div>
                    <div class="screen" id="is-paid">
                        <span class="screen-title">Controleer je bankrekening.</span>

                        <div class="screen-content">
                            Controleer je bankrekening. Is het geld voor het gekochte ticket effectief van je rekening?

                            <div class="explanation">
                                <img src="{{ asset('assets/media/images/explanation.png') }}" alt="(!)">
                                <strong>Advies:</strong> Indien het geld niet van je rekening is er geen ticket gekocht. We raden je aan opnieuw te proberen een ticket te kopen. Als het dan opnieuw niet lukt kan je contact opnemen via <a href="mailto:help@baltropical.be">help@baltropical.be</a>.
                            </div>
                        </div>

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <div class="button next goto" data-next="mail-received">Ja</div>
                                <div class="button no show-explanation">Nee</div>
                            </div>
                        </div>
                    </div>
                    <div class="screen" id="mail-received">
                        <span class="screen-title">Mail ontvangen?</span>

                        <div class="screen-content">
                            Heb je de mail met je ticket ontvangen?
                        </div>

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <div class="button next goto" data-next="open-ticket">Ja</div>
                                <div class="button no goto" data-next="await-mail">Nee</div>
                            </div>
                        </div>
                    </div>
                    <div class="screen" id="await-mail">
                        <span class="screen-title">Wacht op de mail.</span>

                        <div class="screen-content">
                            Zijn er minstens 20 minuten verstreken na het aankopen van het ticket?

                            <div class="explanation">
                                <img src="{{ asset('assets/media/images/explanation.png') }}" alt="(!)">
                                <strong>Advies:</strong> Het kan een tijdje duren eer de mail met je ticket aankomt. Wacht minstens 20 minuten.
                            </div>
                        </div>

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <div class="button next goto" data-next="check-mail">Ja</div>
                                <div class="button no show-explanation">Nee</div>
                            </div>
                        </div>
                    </div>
                    <div class="screen" id="check-mail">
                        <span class="screen-title">Controleer je mail.</span>

                        <div class="screen-content">
                            Heb je gecontroleerd of de mail niet is terecht gekomen in je spam of reclame-folder?

                            <div class="explanation">
                                <img src="{{ asset('assets/media/images/explanation.png') }}" alt="(!)">
                                <strong>Advies:</strong> Controleer alle postvakken van je e-mail. De mail met je ticket kan in de spam beland zijn.
                            </div>
                        </div>

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <div class="button next goto" data-next="resend-mail">Ja</div>
                                <div class="button no show-explanation">Nee</div>
                            </div>
                        </div>
                    </div>
                    <div class="screen" id="resend-mail">
                        <span class="screen-title">Mail herzenden.</span>

                        <div class="screen-content">
                            Geef het e-mailadres waarmee je het ticket gekocht hebt in. Als je e-mailadres bij ons bekend is proberen we het opnieuw op te sturen.

                            <div class="input-line">
                                <input type="email" name="email" placeholder="E-mailadres">
                            </div>

                            <span class="error"><strong>Foutmelding: </strong>Niet alle velden zijn correct ingevuld.</span>
                        </div>

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <div class="button goto" data-next="contact">Overslaan</div>
                                <div class="button next" id="resend-mail-button">Volgende</div>
                            </div>
                        </div>
                    </div>
                    <div class="screen" id="resend-mail-received">
                        <span class="screen-title">Nieuwe mail ontvangen?</span>

                        <div class="screen-content">
                            Heb je deze keer de mail wel ontvangen? Wacht enkele minuten en controleer je spam.
                        </div>

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <div class="button next goto" data-next="solved">Ja</div>
                                <div class="button goto" data-next="contact">Nee</div>
                            </div>
                        </div>
                    </div>
                    <div class="screen" id="open-ticket">
                        <span class="screen-title">Open ticket.</span>

                        <div class="screen-content">
                            Kan je het ticket openen door op de link in de mail te klikken?
                        </div>

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <div class="button next goto" data-next="accept-agreements">Ja</div>
                                <div class="button no goto" data-next="contact">Nee</div>
                            </div>
                        </div>
                    </div>
                    <div class="screen" id="accept-agreements">
                        <span class="screen-title">Voorwaarden geaccepteerd?</span>

                        <div class="screen-content">
                            Heb je de voorwaarden geaccepteerd?

                            <div class="explanation">
                                <img src="{{ asset('assets/media/images/explanation.png') }}" alt="(!)">
                                <strong>Advies:</strong> Je moet de voorwaarden accepteren voordat je het ticket kan gebruiken.
                            </div>
                        </div>

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <div class="button next goto" data-next="contact">Ja</div>
                                <div class="button no show-explanation">Nee</div>
                            </div>
                        </div>
                    </div>
                    <div class="screen" id="contact">
                        <span class="screen-title">Contacteer ons.</span>

                        <div class="form" id="contact-form">
                            <p>Vervelend dat je dit probleem hebt. Neem contact met ons op en beschrijf je probleem zo grondig mogelijk.</p>

                            <div class="input-line half">
                                <input type="text" name="firstname" placeholder="Voornaam" required>
                                <input type="text" name="lastname" placeholder="Achternaam" required>
                            </div>
                            <div class="input-line">
                                <input type="email" name="email" placeholder="E-mailadres" required>
                            </div>
                            <div class="input-line">
                                <textarea name="description" placeholder="Geef een grondige omschrijving van je probleem..." required></textarea>
                            </div>
                            <div class="input-line no-grid">
                                <span class="label">Betaalbewijs: </span>
                                <input type="file" name="file" accept="image/jpg, image/png, application/pdf" required>
                            </div>

                            <span class="error"><strong>Foutmelding: </strong>Niet alle velden zijn correct ingevuld.</span>
                        </div>

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <div class="button next" id="submit-button">Verstuur</div>
                            </div>
                        </div>
                    </div>
                    <div class="screen" id="thank-you">
                        <span class="screen-title">Bedankt!</span>

                        <div class="screen-content">
                            We hebben je vraag goed ontvangen en nemen spoeding contact met je op!
                        </div>

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <a href="/" class="button ok">Ok</a>
                            </div>
                        </div>
                    </div>
                    <div class="screen" id="solved">
                        <span class="screen-title">Top!</span>

                        <div class="screen-content">
                            Blij dat we dit hebben kunnen oplossen!
                        </div>

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <a href="/" class="button ok">Ok</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            @include("partials.footer")

        </div>
    </body>
</html>
