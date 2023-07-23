@extends("admin.administrators")


@section("panel")
    <form method="post" action="/dashboard/administrators/add">
        @csrf

        <div class="input-line">
            <input type="text" name="name" placeholder="Naam" required>
        </div>
        <div class="input-line">
            <input type="email" name="email" placeholder="E-mailadres" required>
        </div>
        <div class="input-line">
            <input type="password" minlength="5" name="password" placeholder="Wachtwoord" required>
        </div>
        <div class="input-line">
            <input type="password" name="rp_password" placeholder="Herhaal wachtwoord" required>
        </div>

        @isset($error)
            <span class="error"><strong>Foutmelding:</strong> {{ $error }} </span>
        @endisset

        <input type="submit" name="submit-button" value="Toevoegen" class="button next">
    </form>
@stop
