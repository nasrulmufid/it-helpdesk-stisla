@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
    <x-page-header title="Manajemen Pengguna" description="Kelola akses dan role pengguna sistem">
        <x-slot:actions>
            <a href="{{ route('admin.users.create') }}" class="button button--primary">
                <x-icon name="user-plus" /> Tambah Pengguna
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="page__body">
        <div class="card">
            <div class="table-responsive">
                <table class="table table--hover table--align-middle">
                    <thead class="table__head--alt">
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Departemen</th>
                            <th scope="col">Telepon</th>
                            <th scope="col">Dibuat</th>
                            <th scope="col" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <x-avatar :name="$user->name" />
                                        <span class="font-medium">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="text-muted-foreground">{{ $user->email }}</td>
                                <td><x-role-badge :role="$user->role" /></td>
                                <td>{{ $user->department ?? '-' }}</td>
                                <td class="whitespace-nowrap">{{ $user->phone ?? '-' }}</td>
                                <td class="whitespace-nowrap text-muted-foreground">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <div class="flex justify-end gap-1">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="button button--sm button--ghost button--neutral button--icon-only" aria-label="Edit {{ $user->name }}" title="Edit">
                                            <x-icon name="pencil" />
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="button button--sm button--ghost button--danger button--icon-only"
                                                aria-label="Hapus {{ $user->name }}" title="Hapus">
                                                <x-icon name="trash-2" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="card__footer">{{ $users->links() }}</div>
            @endif
        </div>
    </div>
@endsection
