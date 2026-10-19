@php
    $authUser = auth()->user();
    // Hanya tampilkan notifikasi 7 hari terakhir
    $unreadCount = $authUser->unreadNotifications()->where('created_at', '>=', now()->subDays(7))->count();
    $recentNotifications = $authUser->notifications()->where('created_at', '>=', now()->subDays(7))->latest()->take(5)->get();
@endphp
<header class="navbar">
    <button type="button" class="button button--ghost button--neutral button--icon-only button--flush-start"
        data-stisla-app-shell-toggle aria-label="Buka/tutup sidebar">
        <x-icon name="menu" />
    </button>

    <div class="ms-auto">
        <div class="flex items-center gap-1">
            <span class="hidden xl:inline text-sm text-muted-foreground me-2">{{ now()->translatedFormat('d M Y, H:i') }}</span>

            {{-- Notifikasi --}}
            <div class="relative">
                <button type="button" class="button button--ghost button--neutral button--icon-only"
                    data-stisla-popover-trigger="notifPopover" aria-haspopup="dialog" aria-expanded="false"
                    aria-controls="notifPopover" aria-label="Notifikasi{{ $unreadCount ? " ($unreadCount belum dibaca)" : '' }}">
                    <x-icon name="bell" />
                </button>
                @if($unreadCount > 0)
                    <span class="indicator indicator--danger indicator--pulse absolute top-1 inset-e-1 pointer-events-none"></span>
                @endif
            </div>
            <div class="popover popover--menu w-96 max-w-full shadow-xl" id="notifPopover" data-stisla-popover
                data-stisla-popover-placement="bottom-end">
                <div class="popover__header">
                    <h3 class="popover__title">Notifikasi</h3>
                    @if($unreadCount > 0)
                        <div class="popover__action">
                            <form action="{{ route('notifications.readAll') }}" method="POST">
                                @csrf
                                <button type="submit" class="button button--sm button--ghost button--primary button--flush-end">Tandai semua dibaca</button>
                            </form>
                        </div>
                    @endif
                </div>
                <div class="popover__body">
                    @forelse($recentNotifications as $notification)
                        @php
                            $data = $notification->data;
                            $isUnread = is_null($notification->read_at);
                            $type = $data['type'] ?? '';
                            $icon = str_contains($type, 'baru') ? 'plus'
                                : (str_contains($type, 'status') ? 'refresh-cw'
                                : ((str_contains($type, 'ditugaskan') || str_contains($type, 'diambil')) ? 'user-check' : 'message-square'));
                        @endphp
                        <div class="media items-start {{ $isUnread ? 'media--unread' : '' }}">
                            <div class="media__figure mt-1">
                                <span class="icon-box {{ $isUnread ? 'icon-box--primary' : '' }}"><x-icon :name="$icon" /></span>
                            </div>
                            <div class="media__content">
                                <div class="media__title">
                                    @if(!empty($data['url']))
                                        <a href="{{ $data['url'] }}" class="link">{{ $data['title'] ?? 'Tiket' }}</a>
                                    @else
                                        {{ $data['title'] ?? 'Tiket' }}
                                    @endif
                                </div>
                                <div class="media__description">{{ $data['message'] ?? '' }}</div>
                                <div class="media__meta">
                                    @if(!empty($data['ticket_number']))<span class="badge badge--soft">{{ $data['ticket_number'] }}</span>@endif
                                    {{ $notification->created_at->diffForHumans(null, true) }}
                                </div>
                            </div>
                            @if($isUnread)
                                <div class="media__action">
                                    <form action="{{ route('notifications.read', $notification) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="button button--ghost button--neutral button--icon-only button--sm" aria-label="Tandai dibaca" title="Tandai dibaca">
                                            <x-icon name="check" />
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="empty-state empty-state--sm">
                            <span class="empty-state__media"><x-icon name="inbox" /></span>
                            <h3 class="empty-state__title">Belum ada notifikasi</h3>
                            <p class="empty-state__text">Menampilkan 7 hari terakhir</p>
                        </div>
                    @endforelse
                </div>
                <div class="popover__footer">
                    <a href="{{ route('notifications.index') }}" class="button button--block button--outline button--neutral">
                        Lihat semua notifikasi <x-icon name="arrow-right" />
                    </a>
                </div>
            </div>

            {{-- Tema --}}
            <button type="button" class="button button--ghost button--neutral button--icon-only" data-theme-toggle aria-label="Ganti tema"></button>

            {{-- Menu pengguna --}}
            <div class="menu">
                <button type="button" class="button button--ghost button--neutral flex items-center gap-2"
                    data-stisla-menu-trigger="userMenu" aria-haspopup="menu" aria-expanded="false" aria-controls="userMenu">
                    <span class="hidden sm:inline font-medium">{{ $authUser->name }}</span>
                    <x-avatar :name="$authUser->name" />
                    <x-icon name="chevron-down" />
                </button>
                <div class="menu__popup w-56" id="userMenu" data-stisla-menu role="menu" data-state="closed">
                    <div class="menu__group" role="group" aria-labelledby="userMenuHead">
                        <h3 class="menu__group-label" id="userMenuHead">{{ ucfirst(str_replace('_', ' ', $authUser->role)) }}</h3>
                        <a href="{{ route('notifications.index') }}" class="menu__item" role="menuitem"><x-icon name="bell" />Notifikasi</a>
                    </div>
                    <hr class="menu__separator" role="separator" />
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="menu__item menu__item--danger" role="menuitem"><x-icon name="log-out" />Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
