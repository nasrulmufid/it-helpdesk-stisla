@props(['label', 'value', 'icon', 'tone' => 'primary', 'href' => null, 'unit' => null])
{{-- Kartu statistik. Jika `href` diisi, seluruh kartu menjadi tautan. --}}
@php $tag = $href ? 'a' : 'div'; @endphp
<{{ $tag }} @if($href) href="{{ $href }}" @endif {{ $attributes->class(['card', 'stat-card']) }}>
    <div class="card__body">
        <div class="stat">
            <div>
                <div class="stat__label">{{ $label }}</div>
                <div class="stat__value">{{ $value }}@if($unit) <span class="stat__unit">{{ $unit }}</span>@endif</div>
            </div>
            <span class="icon-box icon-box--lg icon-box--{{ $tone }}"><x-icon :name="$icon" /></span>
        </div>
    </div>
</{{ $tag }}>
