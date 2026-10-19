@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <x-page-header title="Edit Kategori" description="Update informasi kategori"
        :back="route('admin.categories')" back-label="Kembali ke Kategori" />

    <div class="page__body">
        <div class="card max-w-3xl">
            <div class="card__header">
                <div class="media">
                    <div class="media__figure"><span class="icon-box icon-box--lg">{{ $category->icon }}</span></div>
                    <div class="media__content">
                        <h2 class="card__title">{{ $category->name }}</h2>
                        <p class="card__subtitle">{{ $category->tickets->count() }} tiket</p>
                    </div>
                </div>
            </div>
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card__body flex flex-col gap-5">
                    @include('admin.categories._form-fields', ['category' => $category])

                    @if($category->tickets->count() > 0)
                        <div class="alert alert--warning">
                            <x-icon name="triangle-alert" />
                            <div class="alert__title">Perhatian</div>
                            <div class="alert__description">
                                Kategori ini memiliki {{ $category->tickets->count() }} tiket. Menonaktifkan atau mengubah
                                kategori akan mempengaruhi tiket yang ada.
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card__footer flex-wrap justify-end gap-2">
                    <a href="{{ route('admin.categories') }}" class="button button--neutral button--outline">Batal</a>
                    <button type="submit" class="button button--primary">Update Kategori</button>
                </div>
            </form>
        </div>
    </div>
@endsection
