<x-app-layout>
    <div class="bg-sand bg-opacity-20 py-8 border-b border-sand">
        <div class="container">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <h1 class="font-heading text-navy m-0" style="font-size: 2.5rem;">Incident Feed</h1>
                <a href="{{ route('incidents.create') }}" class="btn-primary">Report an Incident</a>
            </div>
            
            <style>
              .filter-bar {
                background: var(--bg-card, var(--color-background-primary));
                border: 0.5px solid var(--color-border-tertiary);
                border-radius: var(--border-radius-lg);
                padding: 16px 20px;
                margin-top: 24px;
                margin-bottom: 16px;
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
                align-items: flex-end;
              }
              .filter-bar select,
              .filter-bar input[type="text"],
              .filter-bar input[type="date"] {
                border: 0.5px solid var(--color-border-secondary);
                border-radius: var(--border-radius-md);
                padding: 7px 10px;
                font-size: 13px;
                background: var(--color-background-primary);
                color: var(--color-text-primary);
              }
              .search-input { min-width: 220px; }
              .btn-search {
                background: #C4622D;
                color: #fff;
                border: none;
                padding: 8px 16px;
                border-radius: var(--border-radius-md);
                font-size: 13px;
                cursor: pointer;
              }
              .btn-clear {
                color: var(--color-text-secondary);
                font-size: 13px;
                text-decoration: none;
                padding: 8px 12px;
                border: 0.5px solid var(--color-border-secondary);
                border-radius: var(--border-radius-md);
              }
              .results-count {
                font-size: 12px;
                color: var(--color-text-secondary);
                margin-bottom: 10px;
              }
              .filter-field-label {
                display: block;
                font-size: 11px;
                margin-bottom: 4px;
                color: var(--color-text-secondary);
              }
            </style>

            <form action="{{ route('incidents.index') }}" method="GET" class="filter-bar">
                <div>
                    <label class="filter-field-label">Search</label>
                    <div style="position: relative;">
                        <i class="ti ti-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-text-secondary);"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, description or location..." class="search-input" style="padding-left: 30px;">
                    </div>
                </div>

                <div>
                    <label class="filter-field-label">Category</label>
                    <select name="category">
                        <option value="">All categories</option>
                        <option value="theft" {{ request('category')=='theft' ? 'selected' : '' }}>Theft</option>
                        <option value="fire" {{ request('category')=='fire' ? 'selected' : '' }}>Fire</option>
                        <option value="accident" {{ request('category')=='accident' ? 'selected' : '' }}>Accident</option>
                        <option value="suspicious_activity" {{ request('category')=='suspicious_activity' ? 'selected' : '' }}>Suspicious Activity</option>
                        <option value="vandalism" {{ request('category')=='vandalism' ? 'selected' : '' }}>Vandalism</option>
                        <option value="medical" {{ request('category')=='medical' ? 'selected' : '' }}>Medical</option>
                        <option value="natural_disaster" {{ request('category')=='natural_disaster' ? 'selected' : '' }}>Natural Disaster</option>
                        <option value="other" {{ request('category')=='other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div>
                    <label class="filter-field-label">Status</label>
                    <select name="status">
                        <option value="">All statuses</option>
                        @foreach(\App\Models\Incident::STATUSES as $val => $label)
                            <option value="{{ $val }}" {{ request('status')==$val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="filter-field-label">From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}">
                </div>

                <div>
                    <label class="filter-field-label">To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}">
                </div>

                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn-search">
                        <i class="ti ti-search"></i> Search
                    </button>

                    @if(request()->hasAny(['search', 'category', 'status', 'date_from', 'date_to']))
                        <a href="{{ route('incidents.index') }}" class="btn-clear">
                            <i class="ti ti-x"></i> Clear
                        </a>
                    @endif
                </div>
            </form>
            
            <div class="results-count">
                Showing {{ $incidents->total() }} incident(s)
                @if(request('search'))
                    for "{{ request('search') }}"
                @endif
            </div>
        </div>
    </div>

    <div class="container py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($incidents as $incident)
                <x-incident-card :incident="$incident" />
            @empty
                <div class="col-span-full text-center py-16 opacity-70">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="mx-auto mb-4 text-olive"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    <p class="text-xl">No incidents match your criteria.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-8">
            {{ $incidents->links() }}
        </div>
    </div>
</x-app-layout>
