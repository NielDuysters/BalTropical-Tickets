<!DOCTYPE html>
<html>
    <head>
        @include("partials.head", ["title" => "Fout"])
    </head>
    <body>
        <div id="container">

            @include("partials.header")

            <main>
                <div id="progress"><div id="progress-bar"></div></div>
                <div id="screen-container">
                    <div class="screen" id="shutdown">
                        <span class="screen-title">Er is iets foutgelopen.</span>

                        <div class="screen-content">
                            Er is iets onverwacht foutgelopen.
                        </div>

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <a href="/" class="button ok">Ok</a>
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
