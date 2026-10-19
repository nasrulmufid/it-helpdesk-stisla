@extends('layouts.app')

@section('title', 'Laporan Performa Teknisi')

@section('content')
    <x-page-header title="Laporan Performa Teknisi" description="Evaluasi kinerja setiap teknisi"
        :back="route('reports.index')" back-label="Kembali ke Laporan">
        <x-slot:actions>
            <a href="{{ route('reports.export-pdf', ['type' => 'technician-performance', 'start_date' => $startDate, 'end_date' => $endDate]) }}"
                class="button button--primary"><x-icon name="file-down" /> Export PDF</a>
        </x-slot:actions>
    </x-page-header>

    <div class="page__body flex flex-col gap-6">
        @include('reports._filter', ['action' => route('reports.technician-performance')])

        {{-- Kartu per teknisi --}}
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse($technicianStats as $stat)
                @php($rate = $stat['total_assigned'] > 0 ? round(($stat['resolved'] / $stat['total_assigned']) * 100) : 0)
                <div class="card">
                    <div class="card__header">
                        <div class="media">
                            <div class="media__figure"><x-avatar :name="$stat['technician']->name" size="lg" /></div>
                            <div class="media__content">
                                <h4 class="card__title">{{ $stat['technician']->name }}</h4>
                                <p class="card__subtitle">{{ $stat['technician']->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card__body flex flex-col gap-4">
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div><p class="text-2xl">{{ $stat['total_assigned'] }}</p><p class="text-xs text-muted-foreground">Total Ditugaskan</p></div>
                            <div><p class="text-2xl text-success-emphasis">{{ $stat['resolved'] }}</p><p class="text-xs text-muted-foreground">Terselesaikan</p></div>
                            <div><p class="text-2xl text-primary-emphasis">{{ $stat['in_progress'] }}</p><p class="text-xs text-muted-foreground">Dalam Proses</p></div>
                            <div><p class="text-2xl text-info-emphasis">{{ $stat['response_count'] }}</p><p class="text-xs text-muted-foreground">Total Respon</p></div>
                        </div>
                        <div>
                            <div class="kv"><span class="kv__label">Rata-rata Resolusi</span><span class="font-medium">{{ $stat['avg_resolution_time'] }} jam</span></div>
                            @if($stat['total_assigned'] > 0)
                                <div class="progress progress--block mt-2" role="progressbar" aria-label="Tingkat Penyelesaian"
                                    aria-valuenow="{{ $rate }}" aria-valuemin="0" aria-valuemax="100">
                                    <span class="progress__label">Tingkat Penyelesaian</span>
                                    <span class="progress__value">{{ $rate }}%</span>
                                    <div class="progress__track"><div class="progress__bar progress__bar--success" style="width: {{ $rate }}%"></div></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="card md:col-span-2 xl:col-span-3">
                    <div class="card__body">
                        <div class="empty-state"><span class="empty-state__media"><x-icon name="wrench" /></span><h3 class="empty-state__title">Tidak ada data teknisi</h3></div>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Tabel ringkasan --}}
        <div class="card">
            <div class="card__header"><h3 class="card__title">Ringkasan Performa Teknisi</h3></div>
            <div class="table-responsive">
                <table class="table table--hover table--align-middle">
                    <thead class="table__head--alt">
                        <tr>
                            <th scope="col">Teknisi</th>
                            <th scope="col" class="text-center">Total Tiket</th>
                            <th scope="col" class="text-center">Terselesaikan</th>
                            <th scope="col" class="text-center">Dalam Proses</th>
                            <th scope="col" class="text-center">Total Respon</th>
                            <th scope="col">Rata-rata Resolusi</th>
                            <th scope="col">Tingkat Penyelesaian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($technicianStats as $stat)
                            @php($rate = $stat['total_assigned'] > 0 ? round(($stat['resolved'] / $stat['total_assigned']) * 100) : 0)
                            <tr>
                                <td class="whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <x-avatar :name="$stat['technician']->name" />
                                        <span class="font-medium">{{ $stat['technician']->name }}</span>
                                    </div>
                                </td>
                                <td class="text-center">{{ $stat['total_assigned'] }}</td>
                                <td class="text-center"><span class="badge badge--soft badge--success">{{ $stat['resolved'] }}</span></td>
                                <td class="text-center"><span class="badge badge--soft badge--primary">{{ $stat['in_progress'] }}</span></td>
                                <td class="text-center">{{ $stat['response_count'] }}</td>
                                <td class="whitespace-nowrap">{{ $stat['avg_resolution_time'] }} jam</td>
                                <td class="font-medium">{{ $rate }}%</td>
                            </tr>
                        @empty
                            <x-empty-row :colspan="7" icon="wrench" title="Tidak ada data teknisi" />
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
