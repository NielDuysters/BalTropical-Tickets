@extends("admin.administrators")

@section("panel")
    <form method="post" action="/dashboard/administrators/edit/{{ $admin->id }}">
        @csrf

        <span class="label">{{ $admin->name }}</span>

        <div class="input-line">
            <input type="password" name="password" placeholder="Nieuw wachtwoord" minlength="5" required>
        </div>
        <div class="input-line">
            <input type="password" name="rp_password" placeholder="Herhaal wachtwoord" required>
        </div>

        @isset($error)
            <span class="error"><strong>Foutmelding:</strong> {{ $error }} </span>
        @endisset

        <input type="submit" name="submit-button" value="Wijzigen" class="button next">
    </form>
@stop
