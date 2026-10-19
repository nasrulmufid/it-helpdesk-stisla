@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <x-page-header title="Dashboard Admin" description="Ringkasan seluruh aktivitas help desk" />

    <div class="page__body flex flex-col gap-6">
        {{-- Statistik --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Total Tiket" :value="$stats['total_tickets']" icon="ticket" tone="primary"
                :href="route('tickets.index')" />
            <x-stat-card label="Tiket Terbuka" :value="$stats['open_tickets']" icon="circle-alert" tone="info"
                :href="route('tickets.index', ['status' => 'open'])" />
            <x-stat-card label="Dalam Proses" :value="$stats['in_progress_tickets']" icon="refresh-cw" tone="warning"
                :href="route('tickets.index', ['status' => 'in_progress'])" />
            <x-stat-card label="Terselesaikan" :value="$stats['resolved_tickets']" icon="circle-check" tone="success"
                :href="route('tickets.index', ['status' => 'resolved'])" />
            <x-stat-card label="Tiket Kritis" :value="$stats['critical_tickets']" icon="flame" tone="danger"
                :href="route('tickets.index', ['priority' => 'critical'])" />
            <x-stat-card label="Total Pengguna" :value="$stats['total_users']" icon="users" tone="primary"
                :href="route('admin.users')" />
            <x-stat-card label="Teknisi" :value="$stats['total_technicians']" icon="wrench" tone="info"
                :href="route('admin.users')" />
            <x-stat-card label="Tiket Ditutup" :value="$stats['closed_tickets']" icon="check-check" tone="neutral"
                :href="route('tickets.index', ['status' => 'closed'])" />
        </div>

        {{-- Tiket terbaru --}}
        <section class="page__section">
            <div class="card">
                <div class="card__header">
                    <h2 class="card__title">Tiket Terbaru</h2>
                    <div class="card__action">
                        <a href="{{ route('tickets.index') }}" class="button button--sm button--ghost button--primary">
                            Lihat Semua <x-icon name="arrow-right" />
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table--hover table--align-middle">
                        <thead class="table__head--alt">
                            <tr>
                                <th scope="col">No. Tiket</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Pengguna</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Prioritas</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ditugaskan</th>
                                <th scope="col" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTickets as $ticket)
                                <tr>
                                    <td class="whitespace-nowrap">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="link font-medium">{{ $ticket->ticket_number }}</a>
                                    </td>
                                    <td class="font-medium">{{ $ticket->title }}</td>
                                    <td class="whitespace-nowrap">{{ $ticket->user->name }}</td>
                                    <td class="whitespace-nowrap">{{ $ticket->category->icon }} {{ $ticket->category->name }}</td>
                                    <td><x-priority-badge :ticket="$ticket" /></td>
                                    <td><x-status-badge :ticket="$ticket" /></td>
                                    <td class="whitespace-nowrap {{ $ticket->assignedTo ? '' : 'text-muted-foreground italic' }}">
                                        {{ $ticket->assignedTo->name ?? 'Belum ditugaskan' }}
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="button button--sm button--outline button--neutral">Lihat</a>
                                    </td>
                                </tr>
                            @empty
                                <x-empty-row :colspan="8" icon="ticket" title="Belum ada tiket" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Tiket per kategori --}}
        <section class="page__section">
            <div class="page__section-header">
                <h2 class="page__section-title">Tiket per Kategori</h2>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($ticketsByCategory as $category)
                    <div class="card">
                        <div class="card__body">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="icon-box icon-box--lg">{{ $category->icon }}</span>
                                    <span class="font-medium truncate">{{ $category->name }}</span>
                                </div>
                                <span class="badge badge--soft badge--primary">{{ $category->tickets_count }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
