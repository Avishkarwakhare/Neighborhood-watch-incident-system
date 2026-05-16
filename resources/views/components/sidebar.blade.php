<div class="p-6">
    <div class="font-heading mb-8" style="font-size: 2rem;">SafeNeighbor Admin</div>
    
    <nav class="flex flex-col gap-2">
        <a href="{{ route('admin.dashboard') }}" 
           class="p-3 block text-cream {{ request()->routeIs('admin.dashboard') ? 'bg-charcoal' : 'hover:bg-charcoal' }}" 
           style="text-decoration:none; border-radius: 6px; {{ request()->routeIs('admin.dashboard') ? 'border-left: 4px solid var(--color-terracotta);' : '' }}">
           Dashboard
        </a>
        <a href="{{ route('admin.incidents.index') }}" 
           class="p-3 block text-cream {{ request()->routeIs('admin.incidents.*') ? 'bg-charcoal' : 'hover:bg-charcoal' }}" 
           style="text-decoration:none; border-radius: 6px; {{ request()->routeIs('admin.incidents.*') ? 'border-left: 4px solid var(--color-terracotta);' : '' }}">
           Incidents
        </a>
        <a href="{{ route('admin.users.index') }}" 
           class="p-3 block text-cream {{ request()->routeIs('admin.users.*') ? 'bg-charcoal' : 'hover:bg-charcoal' }}" 
           style="text-decoration:none; border-radius: 6px; {{ request()->routeIs('admin.users.*') ? 'border-left: 4px solid var(--color-terracotta);' : '' }}">
           Users
        </a>
        <a href="{{ route('admin.zones.index') }}" 
           class="p-3 block text-cream {{ request()->routeIs('admin.zones.*') ? 'bg-charcoal' : 'hover:bg-charcoal' }}" 
           style="text-decoration:none; border-radius: 6px; {{ request()->routeIs('admin.zones.*') ? 'border-left: 4px solid var(--color-terracotta);' : '' }}">
           Zones
        </a>
    </nav>
</div>
