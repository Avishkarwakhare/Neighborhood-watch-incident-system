@props(['severity'])

@php
    $color = match($severity) {
        'low' => 'text-olive',
        'medium' => 'text-amber',
        'high' => 'text-terracotta',
        'critical' => 'text-rose',
        default => 'text-charcoal',
    };
@endphp

<span class="font-bold {{ $color }} uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">
    {{ $severity }}
</span>
