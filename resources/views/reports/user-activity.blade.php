@extends('layouts.app')

@section('title', 'Laporan Aktivitas Pengguna')

@section('content')
    <x-page-header title="Laporan Aktivitas Pengguna" description="Monitor aktivitas tiket pengguna"
        :back="route('reports.index')" back-label="Kembali ke Laporan">
        <x-slot:actions>
            <a href="{{ route('reports.export-pdf', ['type' => 'user-activity', 'start_date' => $startDate, 'end_date' => $endDate]) }}"
                class="button button--primary"><x-icon name="file-down" /> Export PDF</a>
        </x-slot:actions>
    </x-page-header>

    <div class="page__body flex flex-col gap-6">
        @include('reports._filter', ['action' => route('reports.user-activity')])

        <div class="grid gap-4 md:grid-cols-3">
            <x-stat-card label="Pengguna Aktif" :value="$userStats->count()" icon="users" tone="primary" />
            <x-stat-card label="Total Tiket" :value="$userStats->sum('total_tickets')" icon="ticket" tone="success" />
            <x-stat-card label="Pengguna Paling Aktif" :value="$userStats->first()['user']->name ?? '-'" icon="trending-up" tone="warning" />
        </div>

        <div class="card">
            <div class="card__header"><h3 class="card__title">Aktivitas Tiket per Pengguna</h3></div>
            <div class="table-responsive">
                <table class="table table--hover table--align-middle">
                    <thead class="table__head--alt">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Pengguna</th>
                            <th scope="col" class="text-center">Total Tiket</th>
                            <th scope="col" class="text-center">Open</th>
                            <th scope="col" class="text-center">Resolved</th>
                            <th scope="col" class="text-center">Closed</th>
                            <th scope="col">Tingkat Penyelesaian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($userStats as $index => $stat)
                            @php
                                $resolved = $stat['resolved'] + $stat['closed'];
                                $rate = $stat['total_tickets'] > 0 ? round(($resolved / $stat['total_tickets']) * 100) : 0;
                                $rateColor = $rate >= 80 ? 'text-success-emphasis' : ($rate >= 50 ? 'text-warning-emphasis' : 'text-info-emphasis');
                            @endphp
                            <tr>
                                <td class="text-muted-foreground">{{ $index + 1 }}</td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <x-avatar :name="$stat['user']->name" />
                                        <div>
                                            <div class="font-medium">{{ $stat['user']->name }}</div>
                                            <div class="text-xs text-muted-foreground">{{ $stat['user']->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center font-semibold">{{ $stat['total_tickets'] }}</td>
                                <td class="text-center"><span class="badge badge--soft badge--info">{{ $stat['open'] }}</span></td>
                                <td class="text-center"><span class="badge badge--soft badge--success">{{ $stat['resolved'] }}</span></td>
                                <td class="text-center"><span class="badge badge--soft">{{ $stat['closed'] }}</span></td>
                                <td class="font-medium {{ $rateColor }}">{{ $rate }}%</td>
                            </tr>
                        @empty
                            <x-empty-row :colspan="7" icon="users" title="Tidak ada data aktivitas pengguna dalam periode ini" />
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
