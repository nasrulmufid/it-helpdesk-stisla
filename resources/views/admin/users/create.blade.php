@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <x-page-header title="Tambah Pengguna" description="Buat akun pengguna baru"
        :back="route('admin.users')" back-label="Kembali ke Pengguna" />

    <div class="page__body">
        <div class="card max-w-3xl">
            <div class="card__header"><h2 class="card__title">Informasi Pengguna</h2></div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="card__body flex flex-col gap-5">
                    <div class="field">
                        <label for="name" class="field__label">Nama Lengkap <span class="text-danger-emphasis">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="input"
                            placeholder="Masukkan nama lengkap" required
                            @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
                        <x-form-error name="name" />
                    </div>

                    <div class="field">
                        <label for="email" class="field__label">Email <span class="text-danger-emphasis">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="input"
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
                                <option value="{{ $department }}" {{ old('department') == $department ? 'selected' : '' }}>
                                    {{ $department }}
                                </option>
                            @endforeach
                        </select>
                        <x-form-error name="department" />
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="field">
                            <label for="password" class="field__label">Password <span class="text-danger-emphasis">*</span></label>
                            <input type="password" name="password" id="password" class="input"
                                placeholder="Minimal 8 karakter" autocomplete="new-password" required
                                @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
                            <x-form-error name="password" />
                        </div>
                        <div class="field">
                            <label for="password_confirmation" class="field__label">Konfirmasi Password <span class="text-danger-emphasis">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="input"
                                placeholder="Ketik ulang password" autocomplete="new-password" required>
                        </div>
                    </div>

                    @include('admin.users._role-picker', ['current' => 'user'])
                </div>

                <div class="card__footer flex-wrap justify-end gap-2">
                    <a href="{{ route('admin.users') }}" class="button button--neutral button--outline">Batal</a>
                    <button type="submit" class="button button--primary">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
@endsection
