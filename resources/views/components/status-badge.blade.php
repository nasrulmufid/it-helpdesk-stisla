@props(['ticket' => null, 'status' => null, 'label' => null])
@php
    $status ??= $ticket?->status;
    $label ??= $ticket?->status_label ?? ucfirst(str_replace('_', ' ', (string) $status));
    $class = match ($status) {
        'open' => 'badge badge--soft badge--info',
        'in_progress' => 'badge badge--soft badge--primary',
        'resolved' => 'badge badge--soft badge--success',
        default => 'badge badge--soft', // closed
    };
@endphp
<span {{ $attributes->class($class) }}>{{ $label }}</span>
