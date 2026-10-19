@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <x-page-header title="Laporan Help Desk" description="Lihat ringkasan dan statistik lengkap sistem help desk">
        <x-slot:actions>
            <a href="{{ route('reports.export-pdf') }}" class="button button--primary"><x-icon name="file-down" /> Export PDF</a>
        </x-slot:actions>
    </x-page-header>

    <div class="page__body flex flex-col gap-6">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Total Tiket" :value="number_format($totalTickets)" icon="ticket" tone="primary" />
            <x-stat-card label="Total Pengguna" :value="number_format($totalUsers)" icon="users" tone="success" />
            <x-stat-card label="Total Teknisi" :value="number_format($totalTechnicians)" icon="wrench" tone="info" />
            <x-stat-card label="Rata-rata Respon" :value="$avgResponseTime" unit="menit" icon="timer" tone="warning" />
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach([
                ['reports.ticket-status', 'Status Tiket', 'Lihat distribusi status dan prioritas tiket', 'chart-pie', 'primary'],
                ['reports.category-performance', 'Performa Kategori', 'Analisis tiket berdasarkan kategori', 'layers', 'success'],
                ['reports.technician-performance', 'Performa Teknisi', 'Evaluasi kinerja setiap teknisi', 'wrench', 'info'],
                ['reports.user-activity', 'Aktivitas Pengguna', 'Monitor aktivitas tiket pengguna', 'users', 'warning'],
            ] as [$routeName, $title, $text, $icon, $tone])
                <a href="{{ route($routeName) }}" class="card stat-card">
                    <div class="card__body flex flex-col gap-3">
                        <span class="icon-box icon-box--lg icon-box--{{ $tone }}"><x-icon :name="$icon" /></span>
                        <div>
                            <h3 class="font-semibold">{{ $title }}</h3>
                            <p class="text-sm text-muted-foreground mt-1">{{ $text }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="card">
            <div class="card__header"><h3 class="card__title">Statistik Cepat</h3></div>
            <div class="card__body">
                <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                    @foreach([
                        ['open', 'Tiket Open', 'text-info-emphasis'],
                        ['in_progress', 'Sedang Diproses', 'text-primary-emphasis'],
                        ['resolved', 'Terselesaikan', 'text-success-emphasis'],
                        ['closed', 'Ditutup', 'text-muted-foreground'],
                    ] as [$status, $label, $color])
                        <div class="text-center">
                            <p class="text-3xl {{ $color }}">{{ \App\Models\Ticket::where('status', $status)->count() }}</p>
                            <p class="text-sm text-muted-foreground mt-1">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
