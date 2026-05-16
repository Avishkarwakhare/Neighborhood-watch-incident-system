<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-heading text-navy text-3xl m-0">Zones Management</h2>
        <button class="btn-primary" onclick="alert('Create Zone modal placeholder')">Add New Zone</button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-sand overflow-x-auto">
        <table class="w-full text-left" style="min-width: 800px;">
            <thead>
                <tr class="border-b border-sand bg-cream">
                    <th class="p-4 font-bold uppercase text-xs opacity-70">Zone Name</th>
                    <th class="p-4 font-bold uppercase text-xs opacity-70">Location</th>
                    <th class="p-4 font-bold uppercase text-xs opacity-70">Warden</th>
                    <th class="p-4 font-bold uppercase text-xs opacity-70">Incidents</th>
                    <th class="p-4 font-bold uppercase text-xs opacity-70 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand">
                @forelse($zones as $zone)
                    <tr class="hover:bg-cream hover:bg-opacity-30 transition">
                        <td class="p-4">
                            <div class="font-bold text-navy">{{ $zone->name }}</div>
                            <div class="text-xs opacity-70 truncate max-w-xs">{{ $zone->description }}</div>
                        </td>
                        <td class="p-4 text-sm">
                            {{ $zone->city }}, {{ $zone->state }}
                        </td>
                        <td class="p-4 text-sm">
                            @if($zone->warden)
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-olive text-white flex items-center justify-center text-xs font-bold">{{ substr($zone->warden->name, 0, 1) }}</div>
                                    <span>{{ $zone->warden->name }}</span>
                                </div>
                            @else
                                <span class="text-amber italic">Unassigned</span>
                            @endif
                        </td>
                        <td class="p-4 text-sm">
                            <span class="bg-sand px-2 py-1 rounded-full font-mono">{{ $zone->incidents_count }}</span>
                        </td>
                        <td class="p-4 text-right">
                            <button class="text-terracotta border-none bg-transparent hover:underline cursor-pointer text-sm mr-2" onclick="alert('Edit Zone modal placeholder')">Edit</button>
                            <form action="{{ route('admin.zones.destroy', $zone) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this zone?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose border-none bg-transparent hover:underline cursor-pointer text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center opacity-70">No zones defined yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $zones->links() }}
    </div>
</x-admin-layout>
