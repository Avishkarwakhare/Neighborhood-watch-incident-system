<x-app-layout>

<style>
/* GLOBAL SPACING & BREATHING ROOM */
.dashboard-wrap {
  max-width: 900px;
  margin: 0 auto;
  padding: 28px 20px 80px 20px;
}
.zone-mb {
  margin-bottom: 48px;
}
.two-col {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  align-items: start;
}
.two-col-55-45 { grid-template-columns: 55% calc(45% - 20px); }
.two-col-60-40 { grid-template-columns: 60% calc(40% - 20px); }
.two-col-45-55 { grid-template-columns: 45% calc(55% - 20px); }

/* MOBILE RESPONSIVENESS */
@media (max-width: 700px) {
  .two-col, .two-col-55-45, .two-col-60-40, .two-col-45-55 { 
    grid-template-columns: 1fr !important; 
  }
  .stats-row { grid-template-columns: 1fr 1fr !important; }
  .contacts-grid { grid-template-columns: 1fr 1fr !important; }
  .section-label { font-size: 20px !important; }
  .dashboard-wrap { padding: 28px 14px 80px 14px; }
}

/* SECTION LABEL */
.section-label {
  font-size: 20px;
  font-weight: 600;
  color: #C4622D;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.section-label::after {
  content: '';
  flex: 1;
  height: 1px;
  background: var(--color-border-tertiary);
}

/* WIDGET CARD SHARED CSS */
.widget-card {
  background: var(--color-background-primary);
  border: 0.5px solid var(--color-border-tertiary);
  border-radius: 16px;
  padding: 22px 24px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.03);
}

/* EMERGENCY BANNER */
.emergency-banner {
  background: #C94040;
  color: #fff;
  padding: 16px 24px;
  border-radius: 16px;
  margin-bottom: 24px;
  display: flex;
  align-items: center;
  gap: 12px;
  border-left: 6px solid #8B0000;
  animation: pulseLeft 2s infinite;
}
@keyframes pulseLeft {
  0%,100% { border-left-color: #8B0000; }
  50%      { border-left-color: #FF6B6B; }
}
.pulse-dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: #fff;
  animation: pulseDot 1.2s infinite;
  flex-shrink: 0;
}
@keyframes pulseDot {
  0%,100% { opacity: 1; transform: scale(1); }
  50%      { opacity: 0.4; transform: scale(1.4); }
}

/* GREETING BANNER */
.greeting-banner {
  background: #1E2A4A;
  border-radius: 16px;
  padding: 28px 32px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
}
.greeting-name {
  font-size: 28px;
  color: #F5F0E8;
  font-weight: 600;
  margin-bottom: 4px;
}
.greeting-location {
  font-size: 14px;
  color: #5C6B3A;
}
.btn-primary-dashboard {
  background: #C4622D;
  color: #fff;
  padding: 12px 24px;
  border-radius: var(--border-radius-md);
  font-size: 15px;
  font-weight: 500;
  text-decoration: none;
  box-shadow: 0 3px 0 #8B3D18;
  transition: all 0.15s;
  display: inline-block;
}
.btn-primary-dashboard:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 0 #8B3D18;
}
.btn-ghost-dashboard {
  color: #DDD5C4;
  font-size: 14px;
  text-decoration: none;
  display: block;
  text-align: center;
  margin-top: 8px;
  opacity: 0.8;
}
.btn-ghost-dashboard:hover { opacity: 1; }

/* STATS ROW */
.stats-row {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
}
.stat-card {
  background: var(--color-background-primary);
  border: 0.5px solid var(--color-border-tertiary);
  border-radius: 16px;
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 12px;
  align-items: flex-start;
  box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.stat-icon {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: var(--color-background-secondary);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
}
.stat-num {
  font-size: 32px;
  font-weight: 600;
  line-height: 1;
}

/* TAB BAR */
.tab-bar {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  padding: 12px;
  background: var(--color-background-primary);
  border: 0.5px solid var(--color-border-tertiary);
  border-radius: 16px;
  margin-bottom: 20px;
  position: sticky;
  top: 64px;
  z-index: 10;
}
.tab-on {
  background: var(--color-background-info);
  color: var(--color-text-info);
  border: 0.5px solid var(--color-border-info);
  padding: 8px 18px;
  border-radius: 24px;
  font-size: 13px;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.2s;
}
.tab-off {
  background: transparent;
  color: var(--color-text-secondary);
  border: 0.5px solid var(--color-border-secondary);
  padding: 8px 18px;
  border-radius: 24px;
  font-size: 13px;
  cursor: pointer;
  transition: all 0.2s;
}
.tab-off:hover {
  background: var(--color-background-secondary);
  color: var(--color-text-primary);
}

/* INCIDENT CARD */
.incident-card {
  background: var(--color-background-primary);
  border: 0.5px solid var(--color-border-tertiary);
  border-radius: 16px;
  padding: 20px 24px;
  margin-bottom: 14px;
  position: relative;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.incident-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.06);
  border-color: var(--color-border-secondary);
}
.incident-card::before {
  content: '';
  position: absolute;
  left: 0; top: 0; bottom: 0;
  width: 5px;
  border-radius: 16px 0 0 16px;
  background: var(--severity-color, gray);
}
@keyframes criticalPulse {
  0%,100% { border-color: transparent; }
  50% { border-color: #C94040; }
}

/* BADGES */
.badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }
.badge-olive { background: #EAF3DE; color: #3B6D11; }

/* LOAD MORE BTN */
.load-more-btn { display: inline-block; padding: 12px 32px; border: 0.5px solid var(--color-border-secondary); border-radius: 24px; font-size: 14px; font-weight: 500; color: var(--color-text-secondary); text-decoration: none; transition: all 0.2s; background: var(--color-background-primary); }
.load-more-btn:hover { background: var(--color-background-secondary); color: var(--color-text-primary); }

/* ANNOUNCEMENTS CARD */
.ann-card {
  background: var(--color-background-primary);
  border: 0.5px solid var(--color-border-tertiary);
  border-radius: 16px;
  padding: 22px 24px;
  margin-bottom: 16px;
  position: relative;
  transition: transform 0.2s, box-shadow 0.2s;
}
.ann-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.04);
}
.ann-card::before {
  content: '';
  position: absolute;
  left: 0; top: 0; bottom: 0;
  width: 5px;
  border-radius: 16px 0 0 16px;
  background: var(--priority-color, gray);
}

/* POLL */
.poll-option { display: block; width: 100%; text-align: left; padding: 12px 16px; margin-bottom: 8px; border: 0.5px solid var(--color-border-secondary); border-radius: var(--border-radius-md); background: transparent; font-size: 14px; cursor: pointer; color: var(--color-text-primary); transition: all 0.2s; }
.poll-option:hover { background: var(--color-background-info); color: var(--color-text-info); border-color: var(--color-border-info); }
.poll-bar-bg { height: 8px; background: var(--color-border-tertiary); border-radius: 4px; overflow: hidden; margin-bottom: 10px; }
.poll-bar-fill { height: 100%; background: #C4622D; border-radius: 4px; }

/* CONTRIBUTORS */
.contrib-row { display: flex; align-items: center; gap: 14px; padding: 12px 0; border-bottom: 0.5px solid var(--color-border-tertiary); }
.contrib-row:last-child { border-bottom: none; }
.contrib-rank { font-size: 20px; font-weight: 600; width: 28px; text-align: center; flex-shrink: 0; }
.contrib-avatar { width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 500; color: #fff; flex-shrink: 0; }

/* ACTIVITY ROW */
.activity-row { display: flex; gap: 14px; align-items: flex-start; padding: 12px 0; border-bottom: 0.5px solid var(--color-border-tertiary); font-size: 14px; }
.activity-row:last-child { border-bottom: none; }
.activity-time { font-size: 12px; color: var(--color-text-secondary); font-family: 'JetBrains Mono', monospace; min-width: 60px; padding-top: 4px; }

/* CONTACTS GRID */
.contacts-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
}
.contact-card {
  background: var(--color-background-primary);
  border: 0.5px solid var(--color-border-tertiary);
  border-radius: 16px;
  padding: 20px 16px;
  text-align: center;
  transition: transform 0.2s, box-shadow 0.2s;
}
.contact-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 16px rgba(0,0,0,0.05);
}

/* FAB */
.fab-btn { position: fixed; bottom: 28px; right: 28px; width: 64px; height: 64px; border-radius: 50%; background: #C4622D; color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 4px 0 #8B3D18; transition: all 0.15s; z-index: 999; }
.fab-btn:hover { transform: translateY(-4px); box-shadow: 0 8px 0 #8B3D18; }
.fab-btn:active { transform: translateY(1px); box-shadow: 0 2px 0 #8B3D18; }

/* SCROLL ANIMATIONS CLASSES */
[animate] {
  opacity: 0;
  transition: opacity 0.6s ease, transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
}
[animate="fade-up"] { transform: translateY(30px); }
[animate="fade-left"] { transform: translateX(-40px); }
[animate="fade-right"] { transform: translateX(40px); }
[animate].animated { opacity: 1; transform: translate(0, 0); }
</style>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="dashboard-wrap">
    
    <!-- EMERGENCY BANNER -->
    @if($emergencyAnnouncement)
    <div class="emergency-banner" x-data="{ show: true }" x-show="show">
        <span class="pulse-dot"></span>
        <strong>EMERGENCY ALERT:</strong>
        <span style="flex:1">{{ $emergencyAnnouncement->title }}</span>
        <a href="{{ route('announcements.show', $emergencyAnnouncement) }}" style="color:#FFD0D0; text-decoration:underline;">View details →</a>
    </div>
    @endif

    <!-- ZONE 1: GREETING -->
    <div class="greeting-banner zone-mb" animate="fade-up">
        <div>
            <h1 class="greeting-name">
                @php
                    $hour = Carbon\Carbon::now()->hour;
                    echo $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
                @endphp, {{ $user->name }}.
            </h1>
            <p class="greeting-location">
                <i class="ti ti-map-pin"></i>
                @if($user->society)
                    {{ $user->society->name }}, {{ $user->locality->name }}, Jalandhar
                @else
                    <a href="{{ route('profile.edit') }}" style="color:#F5F0E8; text-decoration:underline;">Set your location to get local alerts →</a>
                @endif
            </p>
        </div>
        <div style="display:flex; flex-direction:column; align-items:flex-end;">
            <a href="{{ route('incidents.create') }}" class="btn-primary-dashboard">+ Report Incident</a>
            <a href="{{ route('incidents.index') }}" class="btn-ghost-dashboard">View all incidents</a>
        </div>
    </div>

    <!-- ZONE 2: STATS ROW -->
    <div class="stats-row zone-mb" animate="fade-up">
        <!-- Open -->
        <div class="stat-card">
            <div class="stat-icon" style="color:#C94040;"><i class="ti ti-alert-circle"></i></div>
            <div class="stat-num" style="color:#C94040;">{{ $openIncidents }}</div>
            <div>
                <div style="font-size:13px; font-weight:500; color:var(--color-text-primary);">Open incidents</div>
                <div style="font-size:12px; color:var(--color-text-secondary);">in your zone</div>
            </div>
        </div>
        <!-- Resolved -->
        <div class="stat-card">
            <div class="stat-icon" style="color:#639922;"><i class="ti ti-circle-check"></i></div>
            <div class="stat-num" style="color:#639922;">{{ $resolvedThisWeek }}</div>
            <div>
                <div style="font-size:13px; font-weight:500; color:var(--color-text-primary);">Resolved this week</div>
                <div style="font-size:12px; color:var(--color-text-secondary);">@if($resolvedThisWeek > 0) ↑ Great progress! @else Keep reporting @endif</div>
            </div>
        </div>
        <!-- Members -->
        <div class="stat-card">
            <div class="stat-icon" style="color:var(--color-text-primary);"><i class="ti ti-users"></i></div>
            <div class="stat-num" style="color:var(--color-text-primary);">{{ $zoneMembers }}</div>
            <div>
                <div style="font-size:13px; font-weight:500; color:var(--color-text-primary);">Neighbors active</div>
                <div style="font-size:12px; color:var(--color-text-secondary);">in {{ $user->zone->name ?? 'your zone' }}</div>
            </div>
        </div>
        <!-- Critical -->
        <div class="stat-card">
            @php $critColor = $criticalCount > 0 ? '#C94040' : '#639922'; @endphp
            <div class="stat-icon" style="color:{{ $critColor }};"><i class="ti ti-urgent"></i></div>
            <div class="stat-num" style="color:{{ $critColor }};">{{ $criticalCount }}</div>
            <div>
                <div style="font-size:13px; font-weight:500; color:var(--color-text-primary);">Critical alerts</div>
                <div style="font-size:12px; color:var(--color-text-secondary);">@if($criticalCount > 0) Need attention now @else Zone is clear @endif</div>
            </div>
        </div>
    </div>

    <!-- ZONE 3: PROFILE & SCORE -->
    <div class="section-label" animate="fade-up">Your profile</div>
    <div class="two-col two-col-55-45 zone-mb">
        
        <!-- Profile Card -->
        <div class="widget-card" animate="fade-left">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:24px;">
                <div style="width:64px; height:64px; border-radius:50%; background:#1E2A4A; color:#fff; font-size:24px; font-weight: 600; display:flex; align-items:center; justify-content:center;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:18px; font-weight:600; display:flex; align-items:center; gap:8px;">
                        {{ $user->name }}
                        @if($user->role === 'resident') <span class="badge badge-blue">Resident</span>
                        @elseif($user->role === 'warden') <span class="badge badge-olive">Warden</span>
                        @elseif($user->role === 'law_enforcement') <span class="badge badge-amber">Police</span>
                        @elseif($user->role === 'admin') <span class="badge badge-red">Admin</span>
                        @endif
                    </div>
                    <div style="font-size:13px; color:var(--color-text-secondary); margin-top:4px;">
                        <i class="ti ti-map-pin"></i> {{ $user->society->name ?? 'Location not set' }}
                    </div>
                </div>
            </div>

            @php
                $myTotal = auth()->user()->incidents()->count();
                $myResolved = auth()->user()->incidents()->where('status','resolved')->count();
                $resolutionRate = $myTotal > 0 ? round(($myResolved/$myTotal)*100) : 0;
            @endphp
            <div style="display:flex; border-top:0.5px solid var(--color-border-tertiary); border-bottom:0.5px solid var(--color-border-tertiary); padding:16px 0; margin-bottom:20px; text-align:center;">
                <div style="flex:1; border-right:0.5px solid var(--color-border-tertiary);">
                    <div style="font-weight:600; font-size:20px;">{{ $myTotal }}</div>
                    <div style="font-size:12px; color:var(--color-text-secondary);">Reports</div>
                </div>
                <div style="flex:1; border-right:0.5px solid var(--color-border-tertiary);">
                    <div style="font-weight:600; font-size:20px;">{{ $user->kudosReceived()->count() }}</div>
                    <div style="font-size:12px; color:var(--color-text-secondary);">Kudos</div>
                </div>
                <div style="flex:1;">
                    <div style="font-weight:600; font-size:20px;">{{ $resolutionRate }}%</div>
                    <div style="font-size:12px; color:var(--color-text-secondary);">Resolved</div>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" style="display:block; text-align:center; padding:12px; border:1px solid var(--color-border-secondary); border-radius:var(--border-radius-md); font-size:14px; font-weight:500; color:var(--color-text-primary); text-decoration:none; transition:all 0.2s;">
                Edit Profile
            </a>
        </div>

        <!-- Safety Score -->
        <div class="widget-card score-widget" animate="fade-right" style="text-align:center; display:flex; flex-direction:column; justify-content:center; height:100%;">
            <div style="font-size:16px; font-weight:600; margin-bottom:2px;">Zone Safety Score</div>
            <div style="font-size:13px; color:var(--color-text-secondary); margin-bottom:24px;">{{ $user->zone->name ?? 'Your zone' }}</div>
            
            <div style="position:relative; width:160px; height:160px; margin:0 auto 24px;">
                <svg viewBox="0 0 120 120" style="transform: rotate(-90deg); width:100%; height:100%;">
                    <circle cx="60" cy="60" r="50" fill="none" stroke="#f1f5f9" stroke-width="10"></circle>
                    <circle id="score-ring" cx="60" cy="60" r="50" fill="none" stroke="{{ $scoreColor }}" stroke-width="10" stroke-dasharray="314" stroke-dashoffset="314" data-dash="{{ 314 - (314 * $safetyScore / 100) }}" stroke-linecap="round"></circle>
                </svg>
                <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); text-align:center;">
                    <div style="font-size:32px; font-weight:700; color:var(--color-text-primary); line-height:1;">{{ $safetyScore }}</div>
                    <div style="font-size:14px; color:var(--color-text-secondary); font-weight:500; margin-top:4px;">{{ $scoreLabel }}</div>
                </div>
            </div>

            <div style="display:flex; justify-content:center; gap:16px; font-size:12px; color:var(--color-text-secondary); flex-wrap:wrap;">
                <span style="display:flex; align-items:center; gap:6px;"><span style="width:10px; height:10px; border-radius:50%; background:#639922;"></span> Safe (80+)</span>
                <span style="display:flex; align-items:center; gap:6px;"><span style="width:10px; height:10px; border-radius:50%; background:#EF9F27;"></span> Mod (60+)</span>
                <span style="display:flex; align-items:center; gap:6px;"><span style="width:10px; height:10px; border-radius:50%; background:#D85A30;"></span> Conc (40+)</span>
                <span style="display:flex; align-items:center; gap:6px;"><span style="width:10px; height:10px; border-radius:50%; background:#E24B4A;"></span> Alert (<40)</span>
            </div>
        </div>
    </div>

    <!-- ZONE 4: INCIDENT FEED -->
    <div class="section-label" animate="fade-up">Incidents near you</div>
    <div class="zone-mb" x-data="{ activeTab: 'all', setTab(t){ this.activeTab = t } }">
        
        <!-- Filter Tabs -->
        <div class="tab-bar" animate="fade-up">
            <button :class="activeTab==='all' ? 'tab-on' : 'tab-off'" @click="setTab('all')">
                All ({{ $incidents->total() }})
            </button>
            <button :class="activeTab==='critical' ? 'tab-on' : 'tab-off'" @click="setTab('critical')" style="--tab-color:#C94040">
                Critical ({{ $criticalCount }})
            </button>
            <button :class="activeTab==='pending' ? 'tab-on' : 'tab-off'" @click="setTab('pending')">
                Pending ({{ $openIncidents }})
            </button>
            <button :class="activeTab==='resolved' ? 'tab-on' : 'tab-off'" @click="setTab('resolved')">
                Resolved ({{ $resolvedThisWeek }})
            </button>
            <button :class="activeTab==='mine' ? 'tab-on' : 'tab-off'" @click="setTab('mine')">
                Mine
            </button>
        </div>

        @if(!auth()->user()->society_id)
        <div class="widget-card" style="border:1px dashed #E8A030; background:var(--color-background-warning); margin-bottom:20px;" animate="fade-up">
            <div style="display:flex; gap:16px; align-items:flex-start">
                <i class="ti ti-map-pin-exclamation" style="font-size:28px; color:var(--color-text-warning); flex-shrink:0;"></i>
                <div>
                    <div style="font-size:15px; font-weight:600; color:var(--color-text-warning); margin-bottom:6px">You are seeing all zone alerts</div>
                    <div style="font-size:13px; color:var(--color-text-secondary); line-height:1.6">Add your society to get hyper-local alerts only from your colony or block. Residents with a society set get faster, more relevant notifications.</div>
                    <a href="{{ route('profile.edit') }}" style="display:inline-block; margin-top:12px; font-size:13px; color:#C4622D; border:1px solid #C4622D; padding:6px 16px; border-radius:24px; text-decoration:none">Set my location →</a>
                </div>
            </div>
        </div>
        @endif

        <!-- Incident Cards -->
        <div animate="stagger">
            @forelse($incidents as $incident)
                @php
                    $catIcon = match($incident->category){
                        'theft'               => 'ti-shield-x',
                        'fire'                => 'ti-flame',
                        'accident'            => 'ti-car-crash',
                        'suspicious_activity' => 'ti-eye',
                        'vandalism'           => 'ti-tools',
                        'medical'             => 'ti-first-aid-kit',
                        'natural_disaster'    => 'ti-cloud-storm',
                        default               => 'ti-alert-circle',
                    };
                    $sevColor = match($incident->severity){
                        'critical' => '#C94040',
                        'high'     => '#C4622D',
                        'medium'   => '#E8A030',
                        'low'      => '#5C6B3A',
                        default    => 'gray',
                    };
                @endphp
                
                <div class="incident-card" 
                    style="--severity-color: {{ $sevColor }}; {{ $incident->severity === 'critical' ? 'animation: criticalPulse 2s infinite;' : '' }}"
                    onclick="window.location.href='{{ route('incidents.show', $incident) }}'"
                    x-show="
                        activeTab === 'all' ||
                        (activeTab === 'critical' && '{{ $incident->severity }}' === 'critical') ||
                        (activeTab === 'pending' && ['pending','processing','verified'].includes('{{ $incident->status }}')) ||
                        (activeTab === 'resolved' && '{{ $incident->status }}' === 'resolved') ||
                        (activeTab === 'mine' && {{ $incident->user_id === auth()->id() ? 'true' : 'false' }})
                    " x-transition>
                    
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:36px; height:36px; border-radius:50%; background:var(--color-background-secondary); display:flex; align-items:center; justify-content:center; color:{{ $sevColor }}; font-size:18px;">
                                <i class="ti {{ $catIcon }}"></i>
                            </div>
                            <div style="font-size:16px; font-weight:600; color:var(--color-text-primary);">{{ $incident->title }}</div>
                        </div>
                        <div style="display:flex; gap:8px;">
                            <span class="badge" style="background:var(--color-background-secondary); color:{{ $sevColor }}; border:0.5px solid {{ $sevColor }}; text-transform:capitalize;">{{ $incident->severity }}</span>
                            <span class="badge badge-{{ $incident->status_color }}">{{ ucfirst($incident->status) }}</span>
                        </div>
                    </div>

                    <div style="font-size:13px; color:var(--color-text-secondary); margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                        <i class="ti ti-map-pin"></i> 
                        {{ $incident->society->name ?? $incident->location_address }}
                        <span style="color:var(--color-border-secondary);">·</span>
                        <span data-timestamp="{{ $incident->created_at->toISOString() }}">{{ $incident->created_at->diffForHumans() }}</span>
                        
                        @if($incident->society_id && $incident->society_id === auth()->user()->society_id)
                            <span class="badge badge-green" style="margin-left:8px;">Your society</span>
                        @elseif($incident->locality_id && $incident->locality_id === auth()->user()->locality_id)
                            <span class="badge badge-blue" style="margin-left:8px;">Your area</span>
                        @else
                            <span class="badge badge-gray" style="margin-left:8px;">Zone wide</span>
                        @endif
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center; border-top:0.5px solid var(--color-border-tertiary); padding-top:14px; font-size:13px; color:var(--color-text-secondary);">
                        <div style="display:flex; align-items:center; gap:16px;">
                            <span><i class="ti ti-message" style="margin-right:4px;"></i> {{ $incident->comments_count }} comments</span>
                            
                            <span style="display:flex; align-items:center; gap:6px;">
                                @if($incident->is_anonymous)
                                    <i class="ti ti-user-off"></i> Anonymous
                                @else
                                    <span style="width:20px; height:20px; border-radius:50%; background:#1E2A4A; color:#fff; display:inline-flex; align-items:center; justify-content:center; font-size:10px;">
                                        {{ strtoupper(substr($incident->user->name, 0, 1)) }}
                                    </span>
                                    {{ $incident->user->name }}
                                @endif
                            </span>
                        </div>
                        <a href="{{ route('incidents.show', $incident) }}" style="color:#C4622D; text-decoration:none; font-weight:600;">View details →</a>
                    </div>
                </div>
            @empty
                <div style="text-align:center; padding:60px; color:var(--color-text-secondary); border:1px dashed var(--color-border-secondary); border-radius:16px;">
                    No incidents to display.
                </div>
            @endforelse
        </div>

        @if($incidents->hasMorePages())
        <div style="text-align:center; margin-top:24px;">
            <a href="{{ $incidents->nextPageUrl() }}" class="load-more-btn">Load more incidents ↓</a>
        </div>
        @endif
    </div>

    <!-- ZONE 5: ANNOUNCEMENTS -->
    <div class="section-label" animate="fade-up">Zone announcements</div>
    <div class="zone-mb" animate="stagger">
        @forelse($announcements as $ann)
            @php
                $annColor = match($ann->priority) {
                    'emergency' => '#C94040',
                    'urgent' => '#E8A030',
                    default => '#5C6B3A'
                };
            @endphp
            <div class="ann-card" style="--priority-color: {{ $annColor }};">
                <div style="display:flex; justify-content:space-between; margin-bottom:12px; align-items:center;">
                    @if($ann->priority === 'emergency') <span class="badge badge-red">Emergency</span>
                    @elseif($ann->priority === 'urgent') <span class="badge badge-amber">Urgent</span>
                    @else <span class="badge badge-blue">Notice</span>
                    @endif
                    
                    <span style="font-size:12px; color:var(--color-text-secondary); font-family:'JetBrains Mono', monospace;" data-timestamp="{{ $ann->created_at->toISOString() }}">
                        {{ $ann->created_at->diffForHumans() }}
                    </span>
                </div>
                <div style="font-size:16px; font-weight:600; color:var(--color-text-primary); margin-bottom:6px;">{{ $ann->title }}</div>
                <div style="font-size:14px; color:var(--color-text-secondary); line-height:1.6; margin-bottom:16px;">{{ \Illuminate\Support\Str::limit($ann->body, 120) }}</div>
                <div style="text-align:right;">
                    <a href="{{ route('announcements.show', $ann) }}" style="font-size:13px; font-weight:600; color:#C4622D; text-decoration:none;">Read more →</a>
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:40px; color:var(--color-text-secondary);">No announcements yet.</div>
        @endforelse
    </div>

    <!-- ZONE 6: POLL & TIP -->
    <div class="section-label" animate="fade-up">Community voice</div>
    <div class="two-col two-col-60-40 zone-mb">
        
        <!-- Poll Card -->
        <div class="widget-card poll-widget" animate="fade-left" x-data="{
            voted: {{ $userVoted ? 'true' : 'false' }},
            vote(optionId){
                fetch('/polls/{{ $activePoll?->id }}/vote',{
                    method:'POST',
                    headers:{
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Content-Type':'application/json'
                    },
                    body: JSON.stringify({ poll_option_id: optionId })
                })
                .then(r => r.json())
                .then(data => {
                    this.voted = true;
                    window.location.reload();
                })
            }
        }">
            <div style="font-size:18px; font-weight:600; margin-bottom:6px; display:flex; align-items:center; gap:8px;">
                <i class="ti ti-chart-bar" style="color:#C4622D;"></i> Community Poll
            </div>
            
            @if($activePoll)
                <div style="font-size:15px; font-weight:500; margin-bottom:6px; line-height:1.5;">{{ $activePoll->question }}</div>
                <div style="font-size:12px; color:var(--color-text-secondary); margin-bottom:20px;">
                    {{ $activePoll->votes()->count() }} votes · expires {{ $activePoll->expires_at ? $activePoll->expires_at->diffForHumans() : 'no expiry' }}
                </div>

                @if(!$userVoted)
                    <div x-show="!voted">
                        @foreach($activePoll->options as $option)
                            <button class="poll-option" @click="vote({{ $option->id }})">{{ $option->option_text }}</button>
                        @endforeach
                    </div>
                @endif

                <div x-show="voted" {!! $userVoted ? '' : 'style="display:none;"' !!}>
                    @foreach($activePoll->options as $option)
                        @php
                            $totalVotes = $activePoll->votes()->count();
                            $optVotes   = $option->votes()->count();
                            $pct = $totalVotes > 0 ? round(($optVotes/$totalVotes)*100) : 0;
                        @endphp
                        <div style="margin-bottom:12px;">
                            <div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:4px;">
                                <span>{{ $option->option_text }}</span>
                                <span style="font-weight:600">{{ $pct }}%</span>
                            </div>
                            <div class="poll-bar-bg">
                                <div class="poll-bar-fill" data-width="{{ $pct }}"></div>
                            </div>
                        </div>
                    @endforeach
                    <div style="font-size:13px; font-weight:500; color:var(--color-text-secondary); margin-top:20px; text-align:center;">
                        <i class="ti ti-check" style="color:#639922; font-size:16px; vertical-align:middle;"></i> You voted. Thanks for your input.
                    </div>
                </div>
            @else
                <div style="text-align:center; padding:40px 0; color:var(--color-text-secondary); font-size:14px;">No active polls right now.<br>Check back soon.</div>
            @endif
        </div>

        <!-- Tip Card -->
        <div class="widget-card" animate="fade-right" style="text-align:center; display:flex; flex-direction:column; justify-content:center; height:100%;">
            <i class="ti ti-bulb" style="color:#E8A030; font-size:32px; margin-bottom:12px;"></i>
            <div style="font-size:16px; font-weight:600; margin-bottom:4px;">Safety tip of the day</div>
            <div style="font-size:12px; color:var(--color-text-secondary); margin-bottom:16px;">{{ date('j M Y') }}</div>
            <div style="font-size:14px; line-height:1.8; color:var(--color-text-primary);">{{ $todayTip }}</div>
        </div>
    </div>

    <!-- ZONE 7: LEADERBOARD & TIMELINE -->
    <div class="section-label" animate="fade-up">Community activity</div>
    <div class="two-col two-col-45-55 zone-mb">
        
        <!-- Leaderboard -->
        <div class="widget-card" animate="fade-left">
            <div style="font-size:18px; font-weight:600; margin-bottom:4px;">Top contributors</div>
            <div style="font-size:13px; color:var(--color-text-secondary); margin-bottom:20px;">This month in {{ $user->zone->name ?? 'your zone' }}</div>

            <div animate="stagger">
                @php $colors = ['#1E2A4A', '#C4622D', '#5C6B3A']; @endphp
                @forelse($topContributors as $index => $contrib)
                    <div class="contrib-row">
                        <div class="contrib-rank" style="color: {{ $index === 0 ? '#E8A030' : ($index === 1 ? '#94a3b8' : '#8A9A5B') }};">
                            {{ $index + 1 }}
                        </div>
                        <div class="contrib-avatar" style="background: {{ $colors[$index % 3] }};">
                            {{ strtoupper(substr($contrib->name, 0, 1)) }}
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:14px; font-weight:600;">{{ $contrib->name }}</div>
                            <div style="font-size:12px; color:var(--color-text-secondary);">{{ $contrib->society->name ?? 'No society set' }}</div>
                        </div>
                        <div class="badge badge-amber" style="font-size:12px; padding:4px 12px;">
                            ★ {{ $contrib->kudos_received_count }}
                        </div>
                    </div>
                @empty
                    <div style="font-size:14px; color:var(--color-text-secondary); text-align:center; padding:20px 0;">
                        Be the first contributor! Report an incident to get kudos.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Timeline -->
        <div class="widget-card" animate="fade-right">
            <div style="font-size:18px; font-weight:600; margin-bottom:20px;">Today's timeline</div>
            
            @forelse($recentActivity as $activity)
                <div class="activity-row">
                    <div class="activity-time">
                        {{ \Carbon\Carbon::parse($activity['time'])->format('g:i A') }}
                    </div>
                    
                    <div style="flex-shrink:0; min-width:80px;">
                        @if($activity['type'] === 'incident')
                            <span class="badge badge-{{ $activity['status_color'] ?? 'gray' }}">{{ ucfirst($activity['status']) }}</span>
                        @else
                            @if($activity['priority'] === 'emergency') <span class="badge badge-red">Emergency</span>
                            @elseif($activity['priority'] === 'urgent') <span class="badge badge-amber">Urgent</span>
                            @else <span class="badge badge-blue">Notice</span>
                            @endif
                        @endif
                    </div>
                    
                    <div style="flex:1;">
                        <a href="{{ $activity['url'] }}" style="color:var(--color-text-primary); text-decoration:none; font-weight:500; font-size:13px; line-height:1.5; display:block;">{{ $activity['title'] }}</a>
                    </div>
                </div>
            @empty
                <div style="text-align:center; padding:20px; color:var(--color-text-secondary);">No activity yet today.</div>
            @endforelse
        </div>
    </div>

    <!-- ZONE 8: MINI MAP -->
    <div class="section-label" animate="fade-up">Incidents on the map</div>
    <div class="widget-card zone-mb" animate="fade-up" style="padding:16px;">
        <div id="mini-map" style="height:320px; border-radius:var(--border-radius-lg); overflow:hidden; border:0.5px solid var(--color-border-tertiary); z-index:1;"></div>

        <div style="display:flex; justify-content:center; gap:20px; font-size:13px; margin-top:20px;">
            <span style="display:flex;align-items:center;gap:6px;"><span style="width:12px;height:12px;border-radius:50%;background:#E24B4A;"></span> Critical</span>
            <span style="display:flex;align-items:center;gap:6px;"><span style="width:12px;height:12px;border-radius:50%;background:#EF9F27;"></span> High/Med</span>
            <span style="display:flex;align-items:center;gap:6px;"><span style="width:12px;height:12px;border-radius:50%;background:#639922;"></span> Resolved</span>
        </div>
        <div style="text-align:center; margin-top:16px;">
            <a href="{{ route('incidents.index') }}" class="btn-ghost-dashboard" style="display:inline-block; font-weight:500; color:#C4622D;">View full map →</a>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function(){
            const map = L.map('mini-map', {
                zoomControl: false,
                attributionControl: false,
                dragging: false,
                scrollWheelZoom: false,
                doubleClickZoom: false,
                touchZoom: false
            }).setView([
                {{ $user->locality->lat ?? 31.3260 }},
                {{ $user->locality->lng ?? 75.5762 }}
            ], 14);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png').addTo(map);

            const incidents = @json($mapIncidents);

            incidents.forEach(inc => {
                if(inc.lat && inc.lng) {
                    const color = 
                        inc.status === 'resolved'   ? '#639922' :
                        inc.severity === 'critical' ? '#E24B4A' :
                        inc.severity === 'high'     ? '#EF9F27' :
                        inc.severity === 'medium'   ? '#EF9F27' :
                        '#EF9F27';

                    L.circleMarker([inc.lat, inc.lng], {
                        radius: 8,
                        fillColor: color,
                        color: '#fff',
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.9
                    }).bindPopup('<strong>' + inc.title + '</strong><br><small>' + inc.status + '</small>').addTo(map);
                }
            });
        });
        </script>
    </div>

    <!-- ZONE 9: EMERGENCY CONTACTS -->
    <div class="section-label" animate="fade-up">Emergency contacts</div>
    <div class="contacts-grid" animate="fade-up" style="margin-bottom:60px;">
        <div class="contact-card">
            <i class="ti ti-phone-call" style="color:#C94040; font-size:36px; margin-bottom:12px; display:block;"></i>
            <div style="font-size:14px; font-weight:600; margin-bottom:4px;">Police Control</div>
            <div style="font-family:'JetBrains Mono', monospace; font-size:15px; font-weight:600; color:var(--color-text-secondary); margin-bottom:16px;">100</div>
            <a href="tel:100" style="display:block; width:100%; padding:10px; background:rgba(201,64,64,0.1); color:#C94040; border-radius:8px; font-weight:600; text-decoration:none;">Call</a>
        </div>
        <div class="contact-card">
            <i class="ti ti-flame" style="color:#E8A030; font-size:36px; margin-bottom:12px; display:block;"></i>
            <div style="font-size:14px; font-weight:600; margin-bottom:4px;">Fire Station</div>
            <div style="font-family:'JetBrains Mono', monospace; font-size:15px; font-weight:600; color:var(--color-text-secondary); margin-bottom:16px;">101</div>
            <a href="tel:101" style="display:block; width:100%; padding:10px; background:rgba(232,160,48,0.1); color:#E8A030; border-radius:8px; font-weight:600; text-decoration:none;">Call</a>
        </div>
        <div class="contact-card">
            <i class="ti ti-ambulance" style="color:#639922; font-size:36px; margin-bottom:12px; display:block;"></i>
            <div style="font-size:14px; font-weight:600; margin-bottom:4px;">Ambulance</div>
            <div style="font-family:'JetBrains Mono', monospace; font-size:15px; font-weight:600; color:var(--color-text-secondary); margin-bottom:16px;">108</div>
            <a href="tel:108" style="display:block; width:100%; padding:10px; background:rgba(99,153,34,0.1); color:#639922; border-radius:8px; font-weight:600; text-decoration:none;">Call</a>
        </div>
        <div class="contact-card">
            <i class="ti ti-bolt" style="color:#3B82F6; font-size:36px; margin-bottom:12px; display:block;"></i>
            <div style="font-size:14px; font-weight:600; margin-bottom:4px;">PSPCL Fault</div>
            <div style="font-family:'JetBrains Mono', monospace; font-size:15px; font-weight:600; color:var(--color-text-secondary); margin-bottom:16px;">1912</div>
            <a href="tel:1912" style="display:block; width:100%; padding:10px; background:rgba(59,130,246,0.1); color:#3B82F6; border-radius:8px; font-weight:600; text-decoration:none;">Call</a>
        </div>
    </div>

</div>

<!-- FAB BUTTON -->
<a href="{{ route('incidents.create') }}" class="fab-btn" title="Report an incident">
    <i class="ti ti-speakerphone" style="font-size:28px"></i>
</a>

<!-- SCROLL ANIMATIONS JS -->
<script>
document.addEventListener('DOMContentLoaded', function(){

  // Main animation observer
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(entry.isIntersecting){
        entry.target.classList.add('animated');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });

  document.querySelectorAll('[animate]').forEach(el => observer.observe(el));

  // Stagger animation observer
  const staggerObs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(entry.isIntersecting){
        const children = entry.target.querySelectorAll('.incident-card, .ann-card, .contrib-row');
        children.forEach((child, i) => {
          setTimeout(() => {
            child.style.opacity = '1';
            child.style.transform = 'translateY(0)';
          }, i * 80);
        });
        staggerObs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('[animate="stagger"]').forEach(el => {
      const children = el.querySelectorAll('.incident-card, .ann-card, .contrib-row');
      children.forEach(child => {
        child.style.opacity = '0';
        child.style.transform = 'translateY(20px)';
        child.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
      });
      staggerObs.observe(el);
  });

  // Poll bar animation
  const pollObs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(entry.isIntersecting){
        entry.target.querySelectorAll('.poll-bar-fill').forEach(bar => {
            const target = bar.dataset.width;
            bar.style.width = target + '%';
        });
        pollObs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.3 });

  document.querySelectorAll('.poll-widget').forEach(el => {
      el.querySelectorAll('.poll-bar-fill').forEach(bar => {
          bar.style.width = '0%';
          bar.style.transition = 'width 1s ease-out';
      });
      pollObs.observe(el);
  });

  // Safety score ring animation
  const scoreObs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(entry.isIntersecting){
        const ring = document.getElementById('score-ring');
        if(ring){
          const finalDash = ring.dataset.dash;
          ring.style.strokeDashoffset = finalDash;
        }
        scoreObs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.3 });

  const scoreWidget = document.querySelector('.score-widget');
  if(scoreWidget){
    const ring = document.getElementById('score-ring');
    if(ring){
      ring.style.strokeDashoffset = '314';
      ring.style.transition = 'stroke-dashoffset 1.5s cubic-bezier(0.2, 0.8, 0.2, 1)';
      scoreObs.observe(scoreWidget);
    }
  }

  // Relative timestamps
  function timeAgo(dateStr){
    const now = new Date();
    const date = new Date(dateStr);
    const diff = Math.floor((now - date) / 1000);
    if(diff < 60) return 'just now';
    if(diff < 3600) return Math.floor(diff/60) + ' min ago';
    if(diff < 86400) return Math.floor(diff/3600) + ' hrs ago';
    if(diff < 172800) return 'yesterday';
    return Math.floor(diff/86400) + ' days ago';
  }
  document.querySelectorAll('[data-timestamp]').forEach(el => {
      el.textContent = timeAgo(el.getAttribute('data-timestamp'));
  });
});
</script>

</x-app-layout>