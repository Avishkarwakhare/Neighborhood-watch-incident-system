<x-app-layout>
    <div class="container py-8 max-w-4xl">
        <div class="flex justify-between items-center mb-8">
            <h1 class="font-heading text-navy text-3xl m-0">Announcements</h1>
            @can('create', App\Models\Announcement::class)
                <a href="{{ route('announcements.create') }}" class="btn-primary">Post Announcement</a>
            @endcan
        </div>

        <div class="space-y-6">
            @forelse($announcements as $announcement)
                <x-announcement-card :announcement="$announcement" />
            @empty
                <div class="text-center p-12 rounded-xl shadow-sm border border-sand" style="background: var(--bg-card, #ffffff);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="mx-auto mb-4 text-sand"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                    <p class="text-charcoal opacity-70">No active announcements for your zone right now.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $announcements->links() }}
        </div>
    </div>
</x-app-layout>
