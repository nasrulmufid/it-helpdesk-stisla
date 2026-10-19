@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
    <x-page-header title="Edit Pengguna" description="Update informasi pengguna"
        :back="route('admin.users')" back-label="Kembali ke Pengguna" />

    <div class="page__body">
        <div class="card max-w-3xl">
            <div class="card__header">
                <div class="media">
                    <div class="media__figure"><x-avatar :name="$user->name" size="lg" /></div>
                    <div class="media__content">
                        <h2 class="card__title">{{ $user->name }}</h2>
                        <p class="card__subtitle">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card__body flex flex-col gap-5">
                    <div class="field">
                        <label for="name" class="field__label">Nama Lengkap <span class="text-danger-emphasis">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="input"
                            placeholder="Masukkan nama lengkap" required
                            @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
                        <x-form-error name="name" />
                    </div>

                    <div class="field">
                        <label for="email" class="field__label">Email <span class="text-danger-emphasis">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="input"
                            placeholder="contoh@email.com" required
                            @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                        <x-form-error name="email" />
                    </div>

                    <div class="field">
                        <label for="department" class="field__label">Departemen <span class="text-danger-emphasis">*</span></label>
                        <select name="department" id="department" class="select" required
                            @error('department') aria-invalid="true" aria-describedby="department-error" @enderror>
                            <option value="">-- Pilih Departemen --</option>
                            @foreach(config('departments.list') as $department)
                                <option value="{{ $department }}" {{ old('department', $user->department) == $department ? 'selected' : '' }}>
                                    {{ $department }}
                                </option>
                            @endforeach
                        </select>
                        <x-form-error name="department" />
                    </div>

                    <div class="alert alert--neutral">
                        <x-icon name="lock" />
                        <div class="alert__title">Ubah Password (Opsional)</div>
                        <div class="alert__description">
                            <p class="mb-4">Kosongkan jika tidak ingin mengubah password.</p>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="field">
                                    <label for="password" class="field__label">Password Baru</label>
                                    <input type="password" name="password" id="password" class="input"
                                        placeholder="Minimal 8 karakter" autocomplete="new-password"
                                        @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
                                    <x-form-error name="password" />
                                </div>
                                <div class="field">
                                    <label for="password_confirmation" class="field__label">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="input"
                                        placeholder="Ketik ulang password" autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('admin.users._role-picker', ['current' => $user->role])
                </div>

                <div class="card__footer flex-wrap justify-end gap-2">
                    <a href="{{ route('admin.users') }}" class="button button--neutral button--outline">Batal</a>
                    <button type="submit" class="button button--primary">Update Pengguna</button>
                </div>
            </form>
        </div>
    </div>
@endsection
