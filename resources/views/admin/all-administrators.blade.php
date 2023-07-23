@extends("admin.administrators")


@section("panel")
    <div id="admin-list">
        @foreach ($admins as $admin)
            <div class="admin-list-item">
                <span class="name">{{ $admin->name }}</span>
                @if (!$admin->super_admin)
                    <div class="admin-buttons">
                        @if (Auth::user()->super_admin)
                            <a href="/dashboard/administrators/edit/{{ $admin->id }}"><img class="admin-button" src="/assets/media/images/edit.png" alt="Wijzigen"></a>
                        @endif
                        <a href="/dashboard/administrators/delete/{{ $admin->id }}"><img class="admin-button" src="/assets/media/images/delete.png" alt="Verwijderen"></a>
                    </div>
                @else
                    (superadmin)
                @endif
            </div>
        @endforeach
    </div>
@stop
