@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <x-page-header title="Tambah Kategori" description="Buat kategori tiket baru"
        :back="route('admin.categories')" back-label="Kembali ke Kategori" />

    <div class="page__body">
        <div class="card max-w-3xl">
            <div class="card__header"><h2 class="card__title">Informasi Kategori</h2></div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="card__body flex flex-col gap-5">
                    @include('admin.categories._form-fields', ['category' => null])
                </div>
                <div class="card__footer flex-wrap justify-end gap-2">
                    <a href="{{ route('admin.categories') }}" class="button button--neutral button--outline">Batal</a>
                    <button type="submit" class="button button--primary">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
@endsection
