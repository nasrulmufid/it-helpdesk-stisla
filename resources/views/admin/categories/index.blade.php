@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
    <x-page-header title="Manajemen Kategori" description="Kelola kategori tiket help desk">
        <x-slot:actions>
            <a href="{{ route('admin.categories.create') }}" class="button button--primary">
                <x-icon name="plus" /> Tambah Kategori
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="page__body">
        <div class="card">
            <div class="table-responsive">
                <table class="table table--hover table--align-middle">
                    <thead class="table__head--alt">
                        <tr>
                            <th scope="col">Kategori</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Total Tiket</th>
                            <th scope="col" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <span class="icon-box">{{ $category->icon }}</span>
                                        <span class="font-medium">{{ $category->name }}</span>
                                    </div>
                                </td>
                                <td><code>{{ $category->slug }}</code></td>
                                <td class="text-muted-foreground">{{ $category->description }}</td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge badge--soft badge--success">Aktif</span>
                                    @else
                                        <span class="badge badge--soft">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td><span class="badge badge--soft badge--primary">{{ $category->tickets->count() }}</span></td>
                                <td class="text-end">
                                    <div class="flex justify-end gap-1">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                            class="button button--sm button--ghost button--neutral button--icon-only" aria-label="Edit {{ $category->name }}" title="Edit">
                                            <x-icon name="pencil" />
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="button button--sm button--ghost button--danger button--icon-only"
                                                aria-label="Hapus {{ $category->name }}" title="Hapus">
                                                <x-icon name="trash-2" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <x-empty-row :colspan="6" icon="tag" title="Tidak ada kategori" text="Mulai dengan menambahkan kategori baru." />
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
                <div class="card__footer">{{ $categories->links() }}</div>
            @endif
        </div>
    </div>
@endsection
