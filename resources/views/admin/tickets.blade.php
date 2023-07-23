@extends("admin.dashboard")

@section("head")
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin/tickets.css') }}">
    <script defer src="{{ asset('assets/js/admin/tickets.js') }}"></script>
@stop

@section("top-nav")
    <nav id="top-nav">
        <ul>
            <li><a href="/dashboard/tickets">Alle tickets</a></li>
            <li class="active">
                <a href="/dashboard/tickets/add">
                    <img src="{{ asset('assets/media/images/admin/add.png') }}">
                    Ticket toevoegen
                </a>
            </li>
        </ul>
    </nav>
@stop
