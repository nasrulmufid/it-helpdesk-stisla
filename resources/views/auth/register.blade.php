@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="flex flex-col gap-3">
        <span class="brand-mark">HD</span>
        <div>
            <h1 class="text-2xl">Buat akun</h1>
            <p class="text-muted-foreground mt-1">Daftar untuk membuat akun baru.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
        @csrf

        <div class="field">
            <label for="name" class="field__label">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="input" placeholder="Budi Utomo"
                autocomplete="name" required autofocus @error('name') aria-invalid="true" aria-describedby="name-error"
                @enderror>
            <x-form-error name="name" />
        </div>

        <div class="field">
            <label for="email" class="field__label">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="input"
                placeholder="nama@email.com" autocomplete="email" required @error('email') aria-invalid="true"
                aria-describedby="email-error" @enderror>
            <x-form-error name="email" />
        </div>

        <div class="field">
            <label for="phone" class="field__label">Nomor Telepon <span
                    class="text-muted-foreground font-normal">(opsional)</span></label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="input" placeholder="08123456789"
                autocomplete="tel" @error('phone') aria-invalid="true" aria-describedby="phone-error" @enderror>
            <x-form-error name="phone" />
        </div>

        <div class="field">
            <label for="department" class="field__label">Departemen <span class="text-danger-emphasis">*</span></label>
            <select id="department" name="department" class="select" required @error('department') aria-invalid="true"
            aria-describedby="department-error" @enderror>
                <option value="">-- Pilih Departemen --</option>
                @foreach(config('departments.list') as $department)
                    <option value="{{ $department }}" {{ old('department') == $department ? 'selected' : '' }}>
                        {{ $department }}
                    </option>
                @endforeach
            </select>
            <x-form-error name="department" />
        </div>

        <div class="field">
            <label for="password" class="field__label">Password</label>
            <input type="password" id="password" name="password" class="input" placeholder="••••••••"
                autocomplete="new-password" required @error('password') aria-invalid="true"
                aria-describedby="password-error" @enderror>
            <x-form-error name="password" />
        </div>

        <div class="field">
            <label for="password_confirmation" class="field__label">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="input"
                placeholder="••••••••" autocomplete="new-password" required>
        </div>

        <button type="submit" class="button button--primary button--block button--lg">Daftar Sekarang</button>
    </form>

    <p class="text-center text-sm text-muted-foreground">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="link">Login di sini</a>
    </p>
@endsection