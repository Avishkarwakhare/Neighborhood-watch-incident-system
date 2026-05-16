<nav class="p-4 shadow-md" style="background-color: var(--color-background-secondary, #1E2A4A); color: var(--color-cream, #FDFDFD);">
    <div class="container flex justify-between items-center">
        <a href="{{ route('home') }}" class="font-heading" style="font-size: 1.75rem; text-decoration: none; color: inherit;">
            SafeNeighbor
        </a>
        
        <div class="flex items-center gap-8">
            @auth
                <div class="flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('dashboard') }}" style="color: inherit; text-decoration:none; opacity: 0.9; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">Dashboard</a>
                    <a href="{{ route('incidents.index') }}" style="color: inherit; text-decoration:none; opacity: 0.9; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">Incidents</a>
                    <a href="{{ route('announcements.index') }}" style="color: inherit; text-decoration:none; opacity: 0.9; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">Announcements</a>
                </div>
                
                <div style="display: flex; align-items: center; gap: 1.5rem; border-left: 1px solid rgba(255,255,255,0.2); padding-left: 1.25rem;">
                    @include('components.notification-bell')
                    
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="cursor-pointer flex items-center justify-center p-2" title="Toggle Theme" style="border-radius: 50%; width: 36px; height: 36px; background: rgba(255,255,255,0.1); border: none; color: inherit; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        <i class="ti ti-moon" id="theme-icon" style="font-size: 20px;"></i>
                    </button>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-3 cursor-pointer p-1" style="background: transparent; border: none; color: inherit; border-radius: 30px; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='transparent'">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.2);">
                            @else
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: #F5F0E8; color: #1E2A4A; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: bold; font-family: 'Caveat', cursive; border: 2px solid rgba(255,255,255,0.2);">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div style="text-align: left; line-height: 1.2; padding-right: 0.5rem; display: flex; flex-direction: column;">
                                <span style="font-weight: 600; font-size: 0.85rem;">{{ auth()->user()->name }}</span>
                                @if(auth()->user()->zone)
                                    <span style="font-size: 0.75rem; color: #C4D3B0; font-weight: 500;">{{ auth()->user()->zone->name }}</span>
                                @endif
                            </div>
                            <i class="ti ti-chevron-down" style="font-size: 16px; opacity: 0.7; margin-right: 0.25rem;"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition style="display:none; position: absolute; right: 0; top: 100%; margin-top: 0.5rem; background: var(--bg-card, #ffffff); color: var(--color-text-primary, #2A2E35); border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); padding: 0.5rem; min-width: 200px; z-index: 50; border: 1px solid var(--color-border-tertiary);">
                            <a href="{{ route('incidents.my') }}" class="block p-2 hover:bg-sand" style="text-decoration:none; color:inherit; font-size:14px; border-radius:4px; font-weight: 500;"><i class="ti ti-history" style="margin-right:8px; opacity:0.7;"></i> My Incident History</a>
                            @can('admin-access')
                                <a href="{{ route('admin.dashboard') }}" class="block p-2 hover:bg-sand" style="text-decoration:none; color:inherit; font-size:14px; border-radius:4px; font-weight: 500;"><i class="ti ti-dashboard" style="margin-right:8px; opacity:0.7;"></i> Admin Panel</a>
                            @endcan
                            <div style="border-top:1px solid var(--color-border-tertiary); margin:8px 0;"></div>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="block w-full text-left p-2 border-none cursor-pointer hover:bg-sand" style="background: transparent; color: #C94040; border-radius: 4px; font-size:14px; font-weight: 500;"><i class="ti ti-logout" style="margin-right:8px; opacity:0.7;"></i> Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" style="color: inherit; text-decoration:none; font-weight: 500;">Log in</a>
                <a href="{{ route('register') }}" class="btn-primary" style="padding: 0.5rem 1rem;">Join SafeNeighbor</a>
            @endauth
        </div>
    </div>
</nav>
