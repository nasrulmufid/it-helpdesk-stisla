@extends('layouts.app')

@section('title', 'Laporan Status Tiket')

@section('content')
    <x-page-header title="Laporan Status Tiket" description="Distribusi tiket berdasarkan status dan prioritas"
        :back="route('reports.index')" back-label="Kembali ke Laporan">
        <x-slot:actions>
            <a href="{{ route('reports.export-pdf', ['type' => 'ticket-status', 'start_date' => $startDate, 'end_date' => $endDate]) }}"
                class="button button--primary"><x-icon name="file-down" /> Export PDF</a>
        </x-slot:actions>
    </x-page-header>

    <div class="page__body flex flex-col gap-6">
        @include('reports._filter', ['action' => route('reports.ticket-status')])

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Open" :value="$statusCounts['open']" icon="circle-alert" tone="info" />
            <x-stat-card label="Dalam Proses" :value="$statusCounts['in_progress']" icon="refresh-cw" tone="primary" />
            <x-stat-card label="Terselesaikan" :value="$statusCounts['resolved']" icon="circle-check" tone="success" />
            <x-stat-card label="Ditutup" :value="$statusCounts['closed']" icon="check-check" tone="neutral" />
        </div>

        <div class="card">
            <div class="card__header"><h3 class="card__title">Distribusi Prioritas</h3></div>
            <div class="card__body">
                <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                    @foreach([['low', 'Low', 'text-success-emphasis'], ['medium', 'Medium', 'text-warning-emphasis'], ['high', 'High', 'text-danger-emphasis'], ['critical', 'Critical', 'text-danger-emphasis']] as [$key, $label, $color])
                        <div class="text-center">
                            <p class="text-3xl {{ $color }}">{{ $priorityCounts[$key] }}</p>
                            <p class="text-sm text-muted-foreground mt-1">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card__header"><h3 class="card__title">Daftar Tiket ({{ $tickets->count() }} tiket)</h3></div>
            <div class="table-responsive">
                <table class="table table--hover table--align-middle">
                    <thead class="table__head--alt">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Pengguna</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Status</th>
                            <th scope="col">Prioritas</th>
                            <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td>#{{ $ticket->id }}</td>
                                <td><a href="{{ route('tickets.show', $ticket) }}" class="link">{{ Str::limit($ticket->title, 40) }}</a></td>
                                <td>{{ $ticket->user->name ?? '-' }}</td>
                                <td>{{ $ticket->category->name ?? '-' }}</td>
                                <td><x-status-badge :status="$ticket->status" /></td>
                                <td><x-priority-badge :priority="$ticket->priority" /></td>
                                <td class="whitespace-nowrap text-muted-foreground">{{ $ticket->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <x-empty-row :colspan="7" icon="inbox" title="Tidak ada tiket dalam periode ini" />
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
