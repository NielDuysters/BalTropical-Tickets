<!DOCTYPE html>
<html>
    <head>
        @include("partials.head", ["title" => "Verkoop gesloten"])
    </head>
    <body>
        <div id="container">

            @include("partials.header")

            <main>
                <div id="progress"><div id="progress-bar"></div></div>
                <div id="screen-container">
                    <div class="screen" id="shutdown">
                        <span class="screen-title">De ticketverkoop is gesloten.</span>

                        <div class="screen-content">
                            U kan online geen tickets meer kopen.
                        </div>
                    </div>
                </div>

                <a href="/ticket-help" id="ticket-error-url">Ticket gekocht maar niet ontvangen?</a>
            </main>

            @include("partials.footer")

        </div>
    </body>
</html>
