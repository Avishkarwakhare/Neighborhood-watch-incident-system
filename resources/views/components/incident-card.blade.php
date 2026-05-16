@props(['incident'])

<div class="card-handcrafted incident-card severity-{{ $incident->severity }} {{ $incident->severity === 'critical' ? 'pulse-border' : '' }} mb-4">
    <div class="flex justify-between items-start">
        <div class="flex items-center gap-2 mb-2">
            <!-- Category Icon placeholder -->
            <div class="text-charcoal opacity-70">
                @if($incident->category === 'theft')
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                @elseif($incident->category === 'fire')
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" /></svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                @endif
            </div>
            <h3 class="font-heading m-0 text-navy" style="font-size: 1.25rem;">
                <a href="{{ route('incidents.show', $incident) }}" class="text-navy" style="text-decoration:none;">{{ $incident->title }}</a>
            </h3>
        </div>
        <x-status-badge :status="$incident->status" />
    </div>

    <p class="text-sm text-charcoal opacity-80 mt-2 mb-4" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
        {{ $incident->description }}
    </p>

    <div class="flex justify-between items-end mt-4 pt-4" style="border-top: 1px solid var(--color-sand);">
        <div class="flex items-center gap-3">
            @if($incident->is_anonymous)
                <div style="width: 32px; height: 32px; border-radius: 50%; background-color: var(--color-sand); display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/></svg>
                </div>
                <span class="text-sm font-medium">Anonymous Neighbor</span>
            @else
                @if($incident->user->avatar)
                    <img src="{{ asset('storage/' . $incident->user->avatar) }}" alt="Avatar" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                @else
                    <div style="width: 32px; height: 32px; border-radius: 50%; background-color: var(--color-cream); color: var(--color-navy); display: flex; align-items: center; justify-content: center; font-weight: bold; border: 1px solid var(--color-sand);">
                        {{ substr($incident->user->name, 0, 1) }}
                    </div>
                @endif
                <span class="text-sm font-medium">{{ $incident->user->name }}</span>
            @endif
        </div>
        
        <div class="text-right text-sm opacity-70">
            <div class="font-mono" style="font-size: 0.75rem;" data-timestamp="{{ $incident->created_at->toIso8601String() }}">
                {{ $incident->created_at->diffForHumans() }}
            </div>
            <div class="flex items-center gap-1 justify-end mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                <span>{{ \Illuminate\Support\Str::limit($incident->location_address, 20) }}</span>
            </div>
        </div>
    </div>
</div>
