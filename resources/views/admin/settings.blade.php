@extends("admin.dashboard")

@section("head")
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin/settings.css') }}">
    <script defer src="{{ asset('assets/js/admin/settings.js') }}"></script>
@stop

@section("panel")
    <form method="post" action="/dashboard/settings/price">
        @csrf
        <div class="input-line half">
            <span class="label">Prijs</span>
            <div class="amount-wrapper">
                <span class="input-icon">&euro;</span>
                <input type="text" name="price" value="{{ $settings->price }}" placeholder="0,00" required>
            </div>
        </div>
        <input type="submit" name="update-price-button" value="Prijs aanpassen" class="button next">
    </form>

    <form method="post" action="/dashboard/settings/scanner-password">
        @csrf
        <div class="input-line half pin-input">
            <span class="label">Scanner PIN</span>
            <div class="amount-wrapper">
                <input type="password" name="password" value="" placeholder="****" required>
            </div>
        </div>
        <input type="submit" name="update-scanner-password-button" value="Wijzigen" class="button next">
    </form>

    <form method="post" action="/dashboard/settings/empty-tickets">
        @csrf
        <span class="label">Verwijder alle tickets</span>
        <div class="button danger" id="empty-tickets"><img alt="(!)" src="{{ asset('assets/media/images/admin/danger.png') }}">Verwijderen</div>
    </form>

    <form method="post" action="/dashboard/settings/empty-logs">
        @csrf
        <span class="label">Verwijder alle logs</span>
        <div class="button danger" id="empty-logs"><img alt="(!)" src="{{ asset('assets/media/images/admin/danger.png') }}">Verwijderen</div>
    </form>
@stop
