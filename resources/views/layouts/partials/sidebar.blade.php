@php($user = auth()->user())
{{-- Label dibungkus <span> agar bisa disembunyikan saat sidebar menciut (rail). --}}
<aside class="sidebar sidebar--lg sidebar--app" data-stisla-sidebar>
    <header class="sidebar__header">
        <a class="sidebar__brand" href="{{ route('dashboard') }}">
            <x-icon name="headset" />
            <span>Help Desk</span>
        </a>
    </header>

    <div class="sidebar__content">
        <nav class="sidebar__menu" aria-label="Navigasi utama">
            <div class="sidebar__group">
                <span class="sidebar__group-title">Menu</span>
                <ul class="sidebar__list">
                    <li class="sidebar__item">
                        <a class="sidebar__button" href="{{ route('dashboard') }}" @if(request()->routeIs('dashboard')) aria-current="page" @endif>
                            <x-icon name="layout-dashboard" /><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__button" href="{{ route('tickets.index') }}" @if(request()->routeIs('tickets.*')) aria-current="page" @endif>
                            <x-icon name="ticket" /><span>Tiket</span>
                        </a>
                    </li>
                    @if($user->isAdmin() || $user->isGeneralManager())
                        <li class="sidebar__item">
                            <a class="sidebar__button" href="{{ route('reports.index') }}" @if(request()->routeIs('reports.*')) aria-current="page" @endif>
                                <x-icon name="chart-column" /><span>Laporan</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            @if($user->isAdmin())
                <div class="sidebar__group">
                    <span class="sidebar__group-title">Admin</span>
                    <ul class="sidebar__list">
                        <li class="sidebar__item">
                            <a class="sidebar__button" href="{{ route('admin.users') }}" @if(request()->routeIs('admin.users*')) aria-current="page" @endif>
                                <x-icon name="users" /><span>Kelola Pengguna</span>
                            </a>
                        </li>
                        <li class="sidebar__item">
                            <a class="sidebar__button" href="{{ route('admin.categories') }}" @if(request()->routeIs('admin.categories*')) aria-current="page" @endif>
                                <x-icon name="tag" /><span>Kelola Kategori</span>
                            </a>
                        </li>
                        <li class="sidebar__item">
                            <a class="sidebar__button" href="{{ route('admin.migration.index') }}" @if(request()->routeIs('admin.migration.*')) aria-current="page" @endif>
                                <x-icon name="arrow-left-right" /><span>Migrasi Data</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        </nav>
    </div>

    <footer class="sidebar__footer">
        <div class="sidebar__user">
            <x-avatar :name="$user->name" />
            <div class="sidebar__user-text">
                <div class="font-medium text-sm">{{ $user->name }}</div>
                <div class="text-xs text-muted-foreground">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</div>
            </div>
        </div>
    </footer>
</aside>
