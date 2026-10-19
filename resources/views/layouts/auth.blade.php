<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    @include('layouts.partials.head')
</head>

<body>
    <main class="auth">
        {{-- Kiri: form --}}
        <section class="auth__panel">
            <button type="button" class="button button--ghost button--neutral button--icon-only auth__toggle"
                data-theme-toggle aria-label="Ganti tema"></button>

            <div class="auth__form">
                @include('layouts.partials.flash', ['showErrors' => false])

                @yield('content')
            </div>
        </section>

        {{-- Kanan: showcase brand (disembunyikan di layar kecil) --}}
        <aside class="auth__aside">
            <a href="{{ url('/') }}" class="auth__brand">
                <span class="auth__brand-mark"><x-icon name="headset" /></span>
                <span class="auth__brand-name">IT Help Desk</span>
            </a>
            <div>
                <h2 class="auth__pitch-title">Masalah IT beres, <span>tanpa ribet.</span></h2>
                <p class="auth__pitch-lede">Laporkan kendala, pantau progres tiket, dan terhubung langsung dengan tim support — semua dalam satu tempat.</p>
            </div>
        </aside>
    </main>
</body>

</html>
