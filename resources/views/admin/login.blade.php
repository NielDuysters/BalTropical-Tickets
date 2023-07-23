<!DOCTYPE html>
<html>
    <head>
        <title>Bal Tropical - Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">

        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin/login.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-inputs.css') }}">
    </head>
    <body>
        <form id="login-form" method="post" action="/dashboard/login">
            @csrf
            <h1>Login</h1>

            <div class="input-line">
                <img alt="" src="{{ asset('assets/media/images/admin/user.png') }}">
                <input type="text" name="name" placeholder="Naam" required>
            </div>
            <div class="input-line">
                <img alt="" src="{{ asset('assets/media/images/admin/password.png') }}">
                <input type="password" name="password" placeholder="Wachtwoord" required>
            </div>

            <input type="submit" name="login-button" class="button next" value="Inloggen">

            @if ($errors->has('auth_failure'))
                <div class="error">
                    {{ $errors->first('auth_failure') }}
                </div>
            @endif
        </form>
    </body>
</html>
