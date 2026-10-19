<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Dashboard') · IT Help Desk</title>

{{-- Terapkan tema tersimpan (atau preferensi OS) sebelum render pertama agar tidak berkedip. --}}
<script>
    (function () {
        var t;
        try { t = localStorage.getItem('stisla-theme'); } catch (e) {}
        if (t !== 'dark' && t !== 'light') {
            t = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
        document.documentElement.dataset.theme = t;
    })();
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

@vite(['resources/css/app.css', 'resources/js/app.js'])
