@props(['ticket' => null, 'priority' => null, 'label' => null])
@php
    $priority ??= $ticket?->priority;
    $label ??= $ticket?->priority_label ?? ucfirst((string) $priority);
    // low=hijau, medium=kuning, high=merah (soft), critical=merah (solid)
    $class = match ($priority) {
        'low' => 'badge badge--soft badge--success',
        'medium' => 'badge badge--soft badge--warning',
        'high' => 'badge badge--soft badge--danger',
        'critical' => 'badge badge--danger',
        default => 'badge badge--soft',
    };
@endphp
<span {{ $attributes->class($class) }}>{{ $label }}</span>
