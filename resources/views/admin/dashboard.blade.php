<x-admin-layout>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl border border-sand shadow-sm text-center">
            <h3 class="text-charcoal opacity-70 text-sm font-bold uppercase tracking-wider mb-2">Incidents This Month</h3>
            <div class="text-4xl font-heading text-navy">{{ $totalIncidentsThisMonth }}</div>
            <div class="text-xs {{ $totalIncidentsThisMonth > $totalIncidentsLastMonth ? 'text-rose' : 'text-olive' }} mt-2 font-bold">
                {{ $totalIncidentsThisMonth > $totalIncidentsLastMonth ? '↑' : '↓' }} vs last month ({{ $totalIncidentsLastMonth }})
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-sand shadow-sm text-center">
            <h3 class="text-charcoal opacity-70 text-sm font-bold uppercase tracking-wider mb-2">Resolution Rate</h3>
            <div class="text-4xl font-heading text-olive">{{ $resolutionRate }}%</div>
            <div class="text-xs opacity-70 mt-2">Overall clear rate</div>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-sand shadow-sm text-center">
            <h3 class="text-charcoal opacity-70 text-sm font-bold uppercase tracking-wider mb-2">Pending Approvals</h3>
            <div class="text-4xl font-heading text-amber">{{ $pendingApprovalsCount }}</div>
            @if($pendingApprovalsCount > 0)
                <a href="{{ route('admin.users.index', ['status' => 'pending']) }}" class="text-xs text-terracotta hover:underline mt-2 inline-block">Review now &rarr;</a>
            @else
                <div class="text-xs opacity-70 mt-2">All caught up</div>
            @endif
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-sand shadow-sm text-center">
            <h3 class="text-charcoal opacity-70 text-sm font-bold uppercase tracking-wider mb-2">Critical Incidents</h3>
            <div class="text-4xl font-heading text-rose">{{ $incidentsBySeverity['critical'] ?? 0 }}</div>
            <div class="text-xs opacity-70 mt-2">This month</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Chart placeholder - Chart.js initialized via Alpine or vanilla -->
        <div class="bg-white p-6 rounded-xl border border-sand shadow-sm">
            <h3 class="font-heading text-navy text-xl mb-4">Incidents by Category</h3>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-sand shadow-sm">
            <h3 class="font-heading text-navy text-xl mb-4">Recent Incidents</h3>
            <div class="divide-y divide-sand">
                @forelse($recentIncidents as $incident)
                    <div class="py-3 flex justify-between items-center">
                        <div>
                            <div class="font-bold text-navy">
                                <a href="{{ route('incidents.show', $incident) }}" class="text-navy hover:underline">{{ $incident->title }}</a>
                            </div>
                            <div class="text-xs opacity-70">
                                {{ $incident->zone->name }} &bull; {{ $incident->category }} &bull; <span data-timestamp="{{ $incident->created_at->toIso8601String() }}">{{ $incident->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <x-status-badge :status="$incident->status" />
                    </div>
                @empty
                    <p class="text-sm opacity-70 text-center py-4">No recent incidents.</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('categoryChart').getContext('2d');
            const data = @json($incidentsByCategory);
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(data).map(k => k.charAt(0).toUpperCase() + k.slice(1).replace('_', ' ')),
                    datasets: [{
                        data: Object.values(data),
                        backgroundColor: [
                            '#1E2A4A', '#C4622D', '#5C6B3A', '#E8A030', '#C94040', '#DDD5C4', '#2D2D2D', '#9e4b20'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
