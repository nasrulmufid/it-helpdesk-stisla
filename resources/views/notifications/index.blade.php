@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
    <x-page-header title="Notifikasi" description="Pantau aktivitas tiket dan tugas Anda. Notifikasi otomatis dihapus setelah 30 hari.">
        <x-slot:actions>
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="button button--outline button--neutral"><x-icon name="check-check" /> Tandai semua dibaca</button>
            </form>
        </x-slot:actions>
    </x-page-header>

    <div class="page__body">
        <div class="card">
            <div class="card__body flex flex-col gap-4">
                @forelse($notifications as $notification)
                    @php($data = $notification->data)
                    <div class="media items-start {{ $notification->read_at ? '' : 'media--unread' }}">
                        <div class="media__figure">
                            <span class="icon-box {{ $notification->read_at ? '' : 'icon-box--primary' }}">
                                {{ strtoupper(substr($data['type'] ?? 'N', 0, 1)) }}
                            </span>
                        </div>
                        <div class="media__content">
                            <div class="media__title flex flex-wrap items-center justify-between gap-2">
                                {{ $data['title'] ?? 'Tiket' }}
                                <span class="text-xs font-normal text-muted-foreground">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="media__description">{{ $data['message'] ?? '' }}</div>
                            <div class="media__meta flex flex-wrap items-center gap-2">
                                @if(!empty($data['ticket_number']))
                                    <span class="badge badge--soft badge--primary">{{ $data['ticket_number'] }}</span>
                                @endif
                                @if(!empty($data['by_user_name']))
                                    <span>Oleh {{ $data['by_user_name'] }}</span>
                                @endif
                                @if(!empty($data['url']))
                                    <a href="{{ $data['url'] }}" class="link">Lihat detail</a>
                                @endif
                            </div>
                        </div>
                        @unless($notification->read_at)
                            <div class="media__action">
                                <form action="{{ route('notifications.read', $notification) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="button button--sm button--ghost button--primary">Tandai dibaca</button>
                                </form>
                            </div>
                        @endunless
                    </div>
                @empty
                    <div class="empty-state">
                        <span class="empty-state__media"><x-icon name="bell" /></span>
                        <h3 class="empty-state__title">Belum ada notifikasi</h3>
                    </div>
                @endforelse
            </div>
            @if($notifications->hasPages())
                <div class="card__footer">{{ $notifications->links() }}</div>
            @endif
        </div>
    </div>
@endsection
