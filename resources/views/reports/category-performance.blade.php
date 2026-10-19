@extends('layouts.app')

@section('title', 'Laporan Performa Kategori')

@section('content')
    <x-page-header title="Laporan Performa Kategori" description="Analisis tiket berdasarkan kategori"
        :back="route('reports.index')" back-label="Kembali ke Laporan">
        <x-slot:actions>
            <a href="{{ route('reports.export-pdf', ['type' => 'category-performance', 'start_date' => $startDate, 'end_date' => $endDate]) }}"
                class="button button--primary"><x-icon name="file-down" /> Export PDF</a>
        </x-slot:actions>
    </x-page-header>

    <div class="page__body flex flex-col gap-6">
        @include('reports._filter', ['action' => route('reports.category-performance')])

        <div class="grid gap-4 md:grid-cols-3">
            <x-stat-card label="Total Kategori" :value="$categoryStats->count()" icon="layers" tone="primary" />
            <x-stat-card label="Kategori Paling Aktif" :value="$categoryStats->sortByDesc('total')->first()['category']->name ?? '-'" icon="trending-up" tone="success" />
            <x-stat-card label="Total Tiket" :value="$categoryStats->sum('total')" icon="ticket" tone="info" />
        </div>

        <div class="card">
            <div class="card__header"><h3 class="card__title">Statistik per Kategori</h3></div>
            <div class="table-responsive">
                <table class="table table--hover table--align-middle">
                    <thead class="table__head--alt">
                        <tr>
                            <th scope="col">Kategori</th>
                            <th scope="col" class="text-center">Total</th>
                            <th scope="col" class="text-center">Open</th>
                            <th scope="col" class="text-center">In Progress</th>
                            <th scope="col" class="text-center">Resolved</th>
                            <th scope="col" class="text-center">Closed</th>
                            <th scope="col">Rata-rata Resolusi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categoryStats as $stat)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <span class="icon-box">{{ $stat['category']->icon }}</span>
                                        <div>
                                            <div class="font-medium">{{ $stat['category']->name }}</div>
                                            <div class="text-xs text-muted-foreground">{{ $stat['category']->description ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center font-semibold">{{ $stat['total'] }}</td>
                                <td class="text-center"><span class="badge badge--soft badge--info">{{ $stat['open'] }}</span></td>
                                <td class="text-center"><span class="badge badge--soft badge--primary">{{ $stat['in_progress'] }}</span></td>
                                <td class="text-center"><span class="badge badge--soft badge--success">{{ $stat['resolved'] }}</span></td>
                                <td class="text-center"><span class="badge badge--soft">{{ $stat['closed'] }}</span></td>
                                <td class="whitespace-nowrap">{{ $stat['avg_resolution_time'] }} jam</td>
                            </tr>
                        @empty
                            <x-empty-row :colspan="7" icon="layers" title="Tidak ada data kategori" />
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
