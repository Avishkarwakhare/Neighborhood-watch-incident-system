<x-app-layout>
    <div class="container py-8 max-w-3xl">
        <a href="{{ route('announcements.index') }}" class="text-terracotta text-sm hover:underline flex items-center gap-1 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Announcements
        </a>

        @php
            $bg = match($announcement->priority) {
                'emergency' => 'bg-rose text-white',
                'urgent' => 'bg-amber text-charcoal',
                default => 'bg-sand text-charcoal',
            };
        @endphp

        <div class="card-handcrafted {{ $bg }} mb-6" style="border-left: 6px solid rgba(0,0,0,0.1);">
            <div class="flex items-center gap-2 mb-4 opacity-80 uppercase text-xs font-bold tracking-wider">
                @if($announcement->priority === 'emergency')
                    <span class="pulse-border" style="display:inline-block; width:10px; height:10px; background-color:white; border-radius:50%;"></span>
                @endif
                {{ $announcement->priority }} ANNOUNCEMENT
            </div>
            
            <h1 class="font-heading m-0 mb-6" style="font-size: 2.5rem;">{{ $announcement->title }}</h1>
            
            <div class="prose max-w-none text-lg leading-relaxed mb-8">
                {{ nl2br(e($announcement->body)) }}
            </div>
            
            <div class="flex justify-between items-center pt-4" style="border-top: 1px solid rgba(0,0,0,0.1);">
                <div class="flex items-center gap-3">
                    @if($announcement->user->avatar)
                        <img src="{{ asset('storage/' . $announcement->user->avatar) }}" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    @else
                        <div style="width: 40px; height: 40px; border-radius: 50%; background-color: rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; font-weight: bold;">
                            {{ substr($announcement->user->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <div class="font-bold">{{ $announcement->user->name }}</div>
                        <div class="text-xs opacity-70">{{ $announcement->user->role === 'admin' ? 'Admin' : 'Warden' }}</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-mono text-sm" data-timestamp="{{ $announcement->created_at->toIso8601String() }}">{{ $announcement->created_at->diffForHumans() }}</div>
                    <div class="text-xs opacity-70">{{ $announcement->zone->name }}</div>
                </div>
            </div>
        </div>

        @can('update', $announcement)
            <div class="flex gap-4 justify-end">
                <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-rose border-none bg-transparent hover:underline cursor-pointer">Delete</button>
                </form>
            </div>
        @endcan
    </div>
</x-app-layout>
