@extends('layouts.app')

@section('title', 'Dashboard Teknisi')

@section('content')
    <x-page-header title="Dashboard Teknisi" description="Pantau dan tangani tiket yang ditugaskan kepada Anda" />

    <div class="page__body flex flex-col gap-6">
        {{-- Statistik --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Tiket Saya" :value="$stats['assigned_tickets']" icon="user-check" tone="primary"
                :href="route('tickets.index', ['assigned_to' => auth()->id()])" />
            <x-stat-card label="Terbuka" :value="$stats['open_tickets']" icon="circle-alert" tone="info"
                :href="route('tickets.index', ['status' => 'open'])" />
            <x-stat-card label="Dalam Proses" :value="$stats['in_progress_tickets']" icon="refresh-cw" tone="warning"
                :href="route('tickets.index', ['status' => 'in_progress'])" />
            <x-stat-card label="Terselesaikan" :value="$stats['resolved_tickets']" icon="circle-check" tone="success"
                :href="route('tickets.index', ['status' => 'resolved'])" />
        </div>

        {{-- Tiket yang ditugaskan --}}
        <section class="page__section">
            <div class="card">
                <div class="card__header">
                    <h2 class="card__title">Tiket yang Ditugaskan kepada Saya</h2>
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
                                <th scope="col" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignedTickets as $ticket)
                                <tr>
                                    <td class="whitespace-nowrap">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="link font-medium">{{ $ticket->ticket_number }}</a>
                                    </td>
                                    <td class="font-medium">{{ $ticket->title }}</td>
                                    <td class="whitespace-nowrap">{{ $ticket->user->name }}</td>
                                    <td class="whitespace-nowrap">{{ $ticket->category->icon }} {{ $ticket->category->name }}</td>
                                    <td><x-priority-badge :ticket="$ticket" /></td>
                                    <td><x-status-badge :ticket="$ticket" /></td>
                                    <td class="text-end">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="button button--sm button--outline button--neutral">Lihat</a>
                                    </td>
                                </tr>
                            @empty
                                <x-empty-row :colspan="7" icon="inbox" title="Belum ada tiket yang ditugaskan" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Tiket belum ditugaskan --}}
        <section class="page__section">
            <div class="card">
                <div class="card__header">
                    <h2 class="card__title">Tiket Belum Ditugaskan</h2>
                    <p class="card__subtitle">Tiket yang menunggu untuk diambil</p>
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
                                <th scope="col" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unassignedTickets as $ticket)
                                <tr>
                                    <td class="whitespace-nowrap">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="link font-medium">{{ $ticket->ticket_number }}</a>
                                    </td>
                                    <td class="font-medium">{{ $ticket->title }}</td>
                                    <td class="whitespace-nowrap">{{ $ticket->user->name }}</td>
                                    <td class="whitespace-nowrap">{{ $ticket->category->icon }} {{ $ticket->category->name }}</td>
                                    <td><x-priority-badge :ticket="$ticket" /></td>
                                    <td class="text-end">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('tickets.show', $ticket) }}" class="button button--sm button--outline button--neutral">Lihat</a>
                                            <form action="{{ route('tickets.assignToSelf', $ticket) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="button button--sm button--primary">Ambil</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-empty-row :colspan="6" icon="circle-check" title="Semua tiket sudah ditugaskan" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
