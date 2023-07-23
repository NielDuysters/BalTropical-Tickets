<!DOCTYPE html>
<html>
    <head>
        @include("partials.head", ["title" => "Pagina niet gevonden"])
    </head>
    <body>
        <div id="container">

            @include("partials.header")

            <main>
                <div id="progress"><div id="progress-bar"></div></div>
                <div id="screen-container">
                    <div class="screen" id="not-found">
                        <span class="screen-title">Pagina niet gevonden.</span>
                        <div class="screen-content">
                            Deze pagina is niet gevonden.
                        </div>
                    </div>
                </div>
            </main>

            <a href="/ticket-help" id="ticket-error-url">Ticket gekocht maar niet ontvangen?</a>

            @include("partials.footer")

        </div>
    </body>
</html>
