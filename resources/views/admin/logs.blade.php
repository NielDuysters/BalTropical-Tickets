@extends("admin.dashboard")

@section("head")
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin/logs.css') }}">
@stop

@section("panel")
    <div id="logs">@if ($logs == "")Geen logs om weer te geven...@else{{ $logs }}@endif</div>
@stop
