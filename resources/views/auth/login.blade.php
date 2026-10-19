@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="flex flex-col gap-3">
        <span class="brand-mark">HD</span>
        <div>
            <h1 class="text-2xl">Selamat datang kembali</h1>
            <p class="text-muted-foreground mt-1">Login ke akun IT Help Desk Anda.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
        @csrf

        <div class="field">
            <label for="email" class="field__label">Email</label>
            <div class="input-group input-group--lg">
                <span class="input-group__text"><x-icon name="mail" /></span>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="input"
                    placeholder="nama@email.com" autocomplete="email" required autofocus
                    @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
            </div>
            <x-form-error name="email" />
        </div>

        <div class="field">
            <label for="password" class="field__label">Password</label>
            <div class="input-group input-group--lg">
                <span class="input-group__text"><x-icon name="lock" /></span>
                <input type="password" id="password" name="password" class="input" placeholder="••••••••"
                    autocomplete="current-password" required
                    @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
            </div>
            <x-form-error name="password" />
        </div>

        <div class="field__item">
            <input type="checkbox" id="remember" name="remember" class="checkbox">
            <label for="remember" class="field__label">Ingat saya</label>
        </div>

        <button type="submit" class="button button--primary button--block button--lg">
            Login <x-icon name="arrow-right" />
        </button>
    </form>

    <p class="text-center text-sm text-muted-foreground">
        Belum punya akun?
        <a href="{{ route('register') }}" class="link">Daftar di sini</a>
    </p>
@endsection
