@props(['status'])

@php
    $bg = match($status) {
        'pending' => 'bg-sand text-charcoal',
        'under_review' => 'bg-amber text-white',
        'resolved' => 'bg-olive text-white',
        'dismissed' => 'bg-charcoal text-white',
        default => 'bg-sand text-charcoal',
    };
    $label = str_replace('_', ' ', ucfirst($status));
@endphp

<span class="px-2 py-1 text-xs font-semibold rounded-full {{ $bg }}" style="white-space: nowrap;">
    {{ $label }}
</span>
