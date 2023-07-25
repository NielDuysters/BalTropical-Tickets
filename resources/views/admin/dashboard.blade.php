<!DOCTYPE html>
<html>
    <head>
        <title>Bal Tropical - Dashboard</title>
        <meta charset="utf-8">

        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin/dashboard.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-inputs.css') }}">
        <script defer src="{{ asset('assets/js/admin/dashboard.js') }}"></script>
        <script defer src="{{ asset('assets/js/custom-inputs.js') }}"></script>

        @yield("head")
    </head>
    <body>
        <div id="container">
            <nav id="dashboard-nav">
                <span id="dashboard-title">Dashboard</span>
                <ul>
                    <li>
                        <a href="/dashboard/tickets">
                            <img src="{{ asset('assets/media/images/admin/tickets.png') }}" alt="">
                            <span>Tickets</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/settings">
                            <img src="{{ asset('assets/media/images/admin/settings.png') }}" alt="">
                            <span>Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/shutdown">
                            <img src="{{ asset('assets/media/images/admin/tickets.png') }}" alt="">
                            <span>Shutdown</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/administrators">
                            <img src="{{ asset('assets/media/images/admin/administrators.png') }}" alt="">
                            <span>Administrators</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/logs">
                            <img src="{{ asset('assets/media/images/admin/logs.png') }}" alt="">
                            <span>Logs</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/logout">
                            <img src="{{ asset('assets/media/images/admin/logout.png') }}" alt="">
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div id="dashboard">
                @yield("top-nav")
                @yield("panel")
            </div>
        </div>
    </body>
</html>
