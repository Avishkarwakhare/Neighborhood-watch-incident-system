@props(['announcement'])

@php
    $bg = match($announcement->priority) {
        'emergency' => 'bg-rose text-white',
        'urgent' => 'bg-amber text-charcoal',
        default => 'bg-sand text-charcoal',
    };
@endphp

<div class="card-handcrafted mb-4 {{ $bg }}" style="border-left: 6px solid rgba(0,0,0,0.1);">
    <div class="flex justify-between items-start mb-2">
        <h4 class="font-heading m-0" style="font-size: 1.25rem;">
            <a href="{{ route('announcements.show', $announcement) }}" style="color: inherit; text-decoration: none;">{{ $announcement->title }}</a>
        </h4>
        @if($announcement->priority === 'emergency')
            <span class="pulse-border" style="display:inline-block; width:10px; height:10px; background-color:white; border-radius:50%;"></span>
        @endif
    </div>
    <p class="text-sm opacity-90 mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
        {{ $announcement->body }}
    </p>
    <div class="text-xs opacity-70 flex justify-between items-center">
        <span>By {{ $announcement->user->name }}</span>
        <span class="font-mono" data-timestamp="{{ $announcement->created_at->toIso8601String() }}">{{ $announcement->created_at->diffForHumans() }}</span>
    </div>
</div>
