@props(['role'])
@php
    [$label, $class] = match ($role) {
        'admin' => ['Admin', 'badge badge--soft badge--danger'],
        'general_manager' => ['General Manager', 'badge badge--soft badge--primary'],
        'technician' => ['Teknisi', 'badge badge--soft badge--info'],
        default => ['User', 'badge badge--soft'],
    };
@endphp
<span {{ $attributes->class($class) }}>{{ $label }}</span>
