@extends("admin.tickets")

@section("panel")
    <div id="filter">
        <form method="post" action="/dashboard/tickets">
            @csrf

            <input type="text" name="search-query" placeholder="Zoek...">
            <div class="dropdown" id="is-paid" data-value="">
                <input type="hidden" class="dropdown-value" name="is-paid" value="">
                <div class="selected">
                    <span>Betaald</span>
                    <img class="dropdown-arrow" src="{{ asset('assets/media/images/down-arrow.png') }}" alt="">
                </div>
                <div class="options">
                    <span data-value="1">Betaald</span>
                    <span data-value="0">Niet betaald</span>
                </div>
            </div>
            <div class="dropdown" id="payment-status" data-value="">
                <input type="hidden" class="dropdown-value" name="payment-status" value="">
                <div class="selected">
                    <span>Betaalstatus</span>
                    <img class="dropdown-arrow" src="{{ asset('assets/media/images/down-arrow.png') }}" alt="">
                </div>
                <div class="options">
                    <span data-value="UNPAID">UNPAID</span>
                    <span data-value="PAID">PAID</span>
                    <span data-value="REFUNDED">REFUNDED</span>
                    <span data-value="REFUNDING">REFUNDING</span>
                    <span data-value="EXPIRED">EXPIRED</span>
                    <span data-value="MANUAL">MANUAL</span>
                    <span data-value="REFUNDFAIL">REFUNDFAIL</span>
                </div>
            </div>
            <div class="dropdown" id="is-used" data-value="">
                <input type="hidden" class="dropdown-value" name="is-used" value="">
                <div class="selected">
                    <span>Gebruikt</span>
                    <img class="dropdown-arrow" src="{{ asset('assets/media/images/down-arrow.png') }}" alt="">
                </div>
                <div class="options">
                    <span data-value="1">Gebruikt</span>
                    <span data-value="0">Ongebruikt</span>
                </div>
            </div>

            <input type="submit" name="filter-button" value="filter" class="button next">
        </form>

        <span id="amount-of-tickets">{{ $tickets->count() }} tickets</span>
    </div>

    @if ($tickets->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tijd</th>
                    <th>Naam</th>
                    <th>Email</th>
                    <th>PaymentID</th>
                    <th>Betaalstatus</th>
                    <th>Gebruikt</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr data-attr-ticket-id="{{ $ticket->id }}" data-attr-payment-id="{{ $ticket->payment_id }}">
                        <td>#{{ $ticket->id }}</td>
                        <td>{{ $ticket->created_at }}</td>
                        <td>{{ $ticket->firstname }} {{ $ticket->lastname }}</td>
                        <td>{{ $ticket->email }}</td>
                        <td>{{ $ticket->payment_id }}</td>
                        <td class="status-td">
                            <div class="status {{ strtolower($ticket->payment_status) }}">{{ $ticket->payment_status }}</div>
                        </td>
                        <td class="used-status">
                            @if ($ticket->used)
                                <img alt="Ja" src="{{ asset('assets/media/images/admin/used.png') }}">
                            @else
                                <img alt="Nee" src="{{ asset('assets/media/images/admin/unused.png') }}">
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a target="_blank" href="/ticket/{{ $ticket->code }}"><img alt="" title="Bekijk ticket" src="{{ asset('assets/media/images/admin/view.png') }}"></a>
                                <img class="resend-mail" alt="" title="Herzend e-mail" src="{{ asset('assets/media/images/admin/resend.png') }}">
                                <img class="refund-ticket" alt="" title="Ticket terugbetalen" src="{{ asset('assets/media/images/admin/refund.png') }}">
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <span>Geen tickets gevonden...</span>
    @endif
@stop
