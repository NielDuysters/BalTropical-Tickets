@extends("admin.dashboard")

@section("head")
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin/shutdown.css') }}">
    <script defer src="{{ asset('assets/js/admin/shutdown.js') }}"></script>
@stop

@section("panel")

    <div class="section" id="status">
        @if (!is_shutdown($settings))
            <img src="{{ asset('assets/media/images/admin/enabled.png') }}" alt="">
            Systeem staat aan
        @else
            <img src="{{ asset('assets/media/images/admin/disabled.png') }}" alt="">
            Systeem staat uit
        @endif
    </div>

    <form method="post" action="/dashboard/shutdown/toggle">
        @csrf

        @if (!is_shutdown($settings))
            <span class="label">Systeem uitzetten</span>
            <img alt="Uitzetten" id="power-button" class="off" src="{{ asset('assets/media/images/admin/power-off.png') }}">
        @else
            <span class="label">Systeem aanzetten</span>
            <img alt="Aanzetten" id="power-button" class="on" src="{{ asset('assets/media/images/admin/power-on.png') }}">
        @endif
    </form>

    <form method="post" action="/dashboard/shutdown/set-datetime">
        @csrf
        <div class="input-line half">
            <span class="label">Automatisch uit</span>
            <input type="datetime-local" name="shutdown-datetime" value="{{ $settings->shutdown_datetime }}" required>
        </div>
        <input type="submit" name="update-shutdown-datetime" value="Aanpassen" class="button next">
    </form>
@stop
