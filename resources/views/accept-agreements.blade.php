<!DOCTYPE html>
<html>
    <head>
        @include("partials.head", ["title" => "Accepteer de voorwaarden."])
        <script defer src="{{ asset('assets/js/accept-agreements.js') }}"></script>
    </head>
    <body>
        <div id="container">

            @include("partials.header")

            <main>
                <div id="progress"><div id="progress-bar"></div></div>
                <div id="screen-container">
                    <div class="screen" id="accept-agreements">
                        <span class="screen-title">Accepteer de voorwaarden.</span>

                        <form action="/ticket/{{ $ticket->code }}/agreements" method="post" class="form" id="agreements-form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="checkbox-wrapper">
                                <div class="checkbox checkbox-small" data-selected="false">
                                    <img alt="V" src="{{ asset('assets/media/images/check.png') }}">
                                </div>
                                <span class="checkbox-label">Ik accepteer de <a target="_blank" href="/algemene-voorwaarden">algemene voorwaarden</a> en de <a target="_blank" href="/privacyvoorwaarden">privacyvoorwaarden</a>.</span>
                                <input name="agreements" type="checkbox" value="true" required>
                            </div>

                            @if (date_diff(date_create($ticket->birthdate), date_create('now'))->y < 16)
                                <div class="checkbox-wrapper">
                                    <div class="checkbox checkbox-small" data-selected="false">
                                        <img alt="V" src="{{ asset('assets/media/images/check.png') }}">
                                    </div>
                                    <span class="checkbox-label">Ik ben jonger dan 16 jaar maar heb toestemming van mijn ouders.</span>
                                    <input name="underaged" type="checkbox" value="true">
                                </div>
                            @endif
                        </form>

                        @if (isset($error))
                            <span class="error"><strong>Foutmelding:</strong> {{ $error }}</span>
                        @endif

                        <div class="screen-buttons-container">
                            <div class="screen-buttons-container-buttons">
                                <div class="button next" id="submit-button">Volgende</div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            @include("partials.footer")

        </div>
    </body>
</html>
