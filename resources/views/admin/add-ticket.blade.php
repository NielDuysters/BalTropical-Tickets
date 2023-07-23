@extends("admin.tickets")

@section("head")
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin/add-ticket.css') }}">
@stop

@section("panel")
    <form method="post" action="/dashboard/tickets/add">
        @csrf

        <div>
            <div class="input-line half">
                <input type="text" name="firstname" placeholder="Voornaam" required>
                <input type="text" name="lastname" placeholder="Achternaam" required>
            </div>
            <div class="input-line">
                <input type="email" name="email" placeholder="E-mailadres" required>
            </div>
            <div class="input-line half date-input-wrapper">
                <span class="label">Geboortedatum</span>
                <div class="date-wrapper">
                    <input type="text" class="date-input" name="birthdate-day" placeholder="dag" required>
                    <div class="date-input month dropdown" id="birthdate-month" data-value="" required>
                        <input type="hidden" class="dropdown-value" name="birthdate-month" value="">
                        <div class="selected">
                            <span>Maand</span>
                            <img class="dropdown-arrow" src="{{ asset('assets/media/images/down-arrow.png') }}" alt="">
                        </div>
                        <div class="options">
                            <span data-value="1">Januari</span>
                            <span data-value="2">Februari</span>
                            <span data-value="3">Maart</span>
                            <span data-value="4">April</span>
                            <span data-value="5">Mei</span>
                            <span data-value="6">Juni</span>
                            <span data-value="7">Juli</span>
                            <span data-value="8">Augustus</span>
                            <span data-value="9">September</span>
                            <span data-value="10">Oktober</span>
                            <span data-value="11">November</span>
                            <span data-value="12">December</span>
                        </div>
                    </div>
                    <input type="text" class="date-input" name="birthdate-year" placeholder="jaar" required>
                </div>
            </div>
        </div>

        <div>
            <div class="input-line half">
                <span class="label">Aantal</span>
                <div class="amount-wrapper">
                    <span class="input-icon">&times;</span>
                    <input type="text" name="amount" value="1" placeholder="Aantal" required>
                </div>
            </div>
        </div>

        <input type="submit" name="submit-button" value="Verzenden" class="button next">
    </form>
@stop
