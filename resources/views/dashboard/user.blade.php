@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
    <x-page-header :title="'Selamat Datang, ' . auth()->user()->name . '!'"
        description="Kelola tiket IT support Anda dengan mudah" />

    <div class="page__body flex flex-col gap-6">
        {{-- Statistik --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Total Tiket" :value="$stats['total_tickets']" icon="ticket" tone="primary"
                :href="route('tickets.index')" />
            <x-stat-card label="Terbuka" :value="$stats['open_tickets']" icon="circle-alert" tone="info"
                :href="route('tickets.index', ['status' => 'open'])" />
            <x-stat-card label="Dalam Proses" :value="$stats['in_progress_tickets']" icon="refresh-cw" tone="warning"
                :href="route('tickets.index', ['status' => 'in_progress'])" />
            <x-stat-card label="Terselesaikan" :value="$stats['resolved_tickets']" icon="circle-check" tone="success"
                :href="route('tickets.index', ['status' => 'resolved'])" />
        </div>

        {{-- Aksi cepat --}}
        <section class="page__section">
            <div class="page__section-header">
                <h2 class="page__section-title">Quick Actions</h2>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                <a href="{{ route('tickets.create') }}" class="card stat-card">
                    <div class="card__body">
                        <div class="media">
                            <div class="media__figure"><span class="icon-box icon-box--lg icon-box--primary"><x-icon name="plus" /></span></div>
                            <div class="media__content">
                                <div class="media__title">Buat Tiket Baru</div>
                                <div class="media__description">Laporkan masalah Anda</div>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ route('tickets.index') }}" class="card stat-card">
                    <div class="card__body">
                        <div class="media">
                            <div class="media__figure"><span class="icon-box icon-box--lg icon-box--info"><x-icon name="clipboard-list" /></span></div>
                            <div class="media__content">
                                <div class="media__title">Lihat Semua Tiket</div>
                                <div class="media__description">Kelola tiket Anda</div>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="card">
                    <div class="card__body">
                        <div class="media">
                            <div class="media__figure"><span class="icon-box icon-box--lg icon-box--success"><x-icon name="clock" /></span></div>
                            <div class="media__content">
                                <div class="media__title">Response Time</div>
                                <div class="media__description">~2 jam rata-rata</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Tiket saya --}}
        <section class="page__section">
            <div class="card">
                <div class="card__header">
                    <h2 class="card__title">Tiket Saya</h2>
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
                                <th scope="col">Kategori</th>
                                <th scope="col">Prioritas</th>
                                <th scope="col">Status</th>
                                <th scope="col">Teknisi</th>
                                <th scope="col" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td class="whitespace-nowrap">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="link font-medium">{{ $ticket->ticket_number }}</a>
                                    </td>
                                    <td class="font-medium">{{ $ticket->title }}</td>
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
                                <x-empty-row :colspan="7" icon="ticket" title="Belum ada tiket">
                                    <a href="{{ route('tickets.create') }}" class="button button--primary button--sm">Buat Tiket Pertama</a>
                                </x-empty-row>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
