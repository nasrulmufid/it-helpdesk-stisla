@extends('layouts.app')

@section('title', 'Migrasi Data')

@section('content')
    <x-page-header title="Migrasi Data" description="Import dan Export data sistem dalam format CSV" />

    <div class="page__body flex flex-col gap-6">
        <div class="grid gap-6 lg:grid-cols-3">
            @foreach([
                ['users', 'Pengguna (Users)', 'Kelola data user, teknisi, dan admin melalui file CSV.', 'Master Data', 'users', 'primary'],
                ['categories', 'Kategori (Categories)', 'Kelola kategori tiket dan klasifikasi masalah.', 'Master Data', 'tag', 'success'],
                ['tickets', 'Tiket (Tickets)', 'Migrasi data tiket historis atau bulk creation tiket.', 'Transactional Data', 'ticket', 'warning'],
            ] as [$type, $title, $text, $kind, $icon, $tone])
                <div class="card">
                    <div class="card__body flex flex-col gap-4">
                        <div class="flex items-center justify-between gap-3">
                            <span class="icon-box icon-box--lg icon-box--{{ $tone }}"><x-icon :name="$icon" /></span>
                            <span class="badge badge--soft">{{ $kind }}</span>
                        </div>
                        <div>
                            <h3 class="font-semibold">{{ $title }}</h3>
                            <p class="text-sm text-muted-foreground mt-1">{{ $text }}</p>
                        </div>

                        <div class="flex flex-col gap-2">
                            <a href="{{ route('admin.migration.template', $type) }}" class="button button--outline button--neutral button--block">
                                <x-icon name="file-down" /> Unduh Template
                            </a>
                            <a href="{{ route('admin.migration.export', $type) }}" class="button button--outline button--neutral button--block">
                                <x-icon name="download" /> Export ke CSV
                            </a>
                        </div>

                        <hr class="separator">

                        <form action="{{ route('admin.migration.import', $type) }}" method="POST" enctype="multipart/form-data"
                            class="flex flex-col gap-3">
                            @csrf
                            <div class="field">
                                <label for="file-{{ $type }}" class="field__label">Import CSV</label>
                                <input type="file" id="file-{{ $type }}" name="file" accept=".csv" required class="input">
                            </div>
                            <button type="submit" class="button button--primary button--block">
                                <x-icon name="upload" /> Jalankan Import
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="alert alert--info">
            <x-icon name="info" />
            <div class="alert__title">Petunjuk Penting</div>
            <div class="alert__description">
                <ul class="list-disc ps-5 flex flex-col gap-1">
                    <li>Gunakan file template CSV yang disediakan untuk memastikan format kolom sesuai.</li>
                    <li>Untuk data <strong>Users</strong>, password akan di-hash secara otomatis saat diimport.</li>
                    <li>Untuk data <strong>Tickets</strong>, pastikan email user dan nama kategori sudah terdaftar di sistem.</li>
                    <li>Sistem akan melewati baris jika email user sudah terdaftar (untuk import Users).</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
