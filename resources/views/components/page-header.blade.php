@props(['title', 'description' => null, 'back' => null, 'backLabel' => 'Kembali'])
{{--
    Header halaman Stisla (.page__header). Slot opsional:
      <x-slot:meta>  — baris badge/info di bawah judul
      <x-slot:actions> — tombol di sisi kanan
--}}
<header class="page__header">
    <div class="page__headline">
        @if($back)
            <a href="{{ $back }}" class="back-link"><x-icon name="arrow-left" /> {{ $backLabel }}</a>
        @endif
        <h1 class="page__title">{{ $title }}</h1>
        @if($description)
            <p class="page__description">{{ $description }}</p>
        @endif
        @isset($meta)
            <div class="flex flex-wrap items-center gap-2 mt-2">{{ $meta }}</div>
        @endisset
    </div>
    @isset($actions)
        <div class="page__action">{{ $actions }}</div>
    @endisset
</header>
