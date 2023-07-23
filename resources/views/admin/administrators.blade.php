@extends("admin.dashboard")

@section("head")
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin/administrators.css') }}">
@stop

@section("top-nav")
    <nav id="top-nav">
        <ul>
            <li><a href="/dashboard/administrators">Administrators</a></li>
            <li class="active">
                <a href="/dashboard/administrators/add">
                    <img src="{{ asset('assets/media/images/admin/add.png') }}">
                    Administrator toevoegen
                </a>
            </li>
            <li class="active">
                <a href="/dashboard/administrators/password">
                    <img src="{{ asset('assets/media/images/edit.png') }}">
                    Wijzig wachtwoord
                </a>
            </li>
        </ul>
    </nav>
@stop
