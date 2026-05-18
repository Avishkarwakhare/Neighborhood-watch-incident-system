<x-app-layout>
    <style>
        .verify-btn {
            background: #5C6B3A;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius-md);
            font-size: 13px;
            cursor: pointer;
            margin-right: 10px;
            transition: all 0.15s;
        }
        .verify-btn:hover {
            background: #3B6D11;
            transform: translateY(-1px);
        }
        .reject-btn {
            background: #C94040;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius-md);
            font-size: 13px;
            cursor: pointer;
            transition: all 0.15s;
        }
        .reject-btn:hover {
            background: #A32D2D;
            transform: translateY(-1px);
        }
        .avatar-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .avatar-initials {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #1E2A4A;
            color: #F5F0E8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 500;
            font-family: 'Caveat', cursive;
            flex-shrink: 0;
        }
        .timeline-track {
            display: flex;
            align-items: flex-start;
            gap: 0;
            overflow-x: auto;
            padding: 8px 0;
        }
        .timeline-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
            min-width: 80px;
        }
        .step-dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 500;
            border: 2px solid var(--color-border-secondary);
            background: var(--color-background-secondary);
            color: var(--color-text-secondary);
        }
        .step-done .step-dot {
            background: #5C6B3A;
            border-color: #5C6B3A;
            color: #fff;
        }
        .step-current .step-dot {
            background: #C4622D;
            border-color: #C4622D;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(196,98,45,0.2);
        }
        .step-label {
            font-size: 11px;
            font-weight: 500;
            color: var(--color-text-secondary);
            text-align: center;
        }
        .step-done .step-label,
        .step-current .step-label {
            color: var(--color-text-primary);
        }
        .step-time {
            font-size: 10px;
            color: var(--color-text-secondary);
            font-family: 'JetBrains Mono', monospace;
            text-align: center;
            white-space: nowrap;
        }
        .timeline-connector {
            flex: 1;
            height: 2px;
            background: var(--color-border-tertiary);
            margin-top: 13px;
            min-width: 20px;
        }
        .connector-done {
            background: #5C6B3A;
        }
        .widget-card {
            background: var(--bg-card, var(--color-background-primary));
            border: 0.5px solid var(--color-border-tertiary);
            border-radius: 16px;
            padding: 22px 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
        .widget-header {
            margin-bottom: 16px;
        }
        .widget-title {
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>

    <div class="container py-8 max-w-4xl">
        <a href="{{ route('incidents.index') }}" class="text-terracotta text-sm hover:underline flex items-center gap-1 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Incidents
        </a>

        <!-- TIMELINE -->
        <div class="status-timeline widget-card" style="margin-bottom:20px">
            <div class="widget-header">
                <div class="widget-title">
                    <i class="ti ti-timeline" aria-hidden="true"></i>
                    Incident Progress
                </div>
            </div>

            @php
            $steps = [
                'pending'    => 'Pending',
                'processing' => 'Processing',
                'verified'   => 'Verified',
                'resolved'   => 'Resolved',
                'rejected'   => 'Rejected',
                'closed'     => 'Closed',
            ];
            $statusOrder = array_keys($steps);
            $currentIndex = array_search($incident->status, $statusOrder);
            $isTerminal = in_array($incident->status, ['rejected','closed']);
            @endphp

            <div class="timeline-track">
                @foreach($steps as $key => $label)
                @php
                    $stepIndex = array_search($key, $statusOrder);
                    if($isTerminal){
                        $isDone   = ($key === $incident->status);
                        $isCurrent= ($key === $incident->status);
                    } else {
                        $isDone   = ($stepIndex <= $currentIndex);
                        $isCurrent= ($stepIndex === $currentIndex);
                    }
                @endphp
                <div class="timeline-step {{ $isDone ? 'step-done' : 'step-pending' }} {{ $isCurrent ? 'step-current' : '' }}">
                    <div class="step-dot">
                        @if($isDone)
                            <i class="ti ti-check" style="font-size:10px" aria-hidden="true"></i>
                        @else
                            <span style="font-size:10px">{{ $stepIndex + 1 }}</span>
                        @endif
                    </div>
                    <div class="step-label">{{ $label }}</div>
                    @if($isCurrent && $incident->updated_at)
                    <div class="step-time">
                        {{ $incident->updated_at->format('d M, g:i A') }}
                    </div>
                    @endif
                </div>
                @if(!$loop->last)
                <div class="timeline-connector {{ $isDone && !$isCurrent ? 'connector-done' : 'connector-pending' }}"></div>
                @endif
                @endforeach
            </div>
        </div>

        @can('updateStatus', $incident)
        @if(!in_array($incident->status, ['verified','resolved','rejected','closed']))
        <div class="verification-panel widget-card" style="border-left: 4px solid #C4622D; margin-bottom: 20px">
            <div class="widget-header">
                <div class="widget-title">
                    <i class="ti ti-shield-check" aria-hidden="true"></i>
                    Verification Actions
                </div>
            </div>

            <div style="background: var(--color-background-secondary); border-radius:var(--border-radius-md); padding:12px; margin-bottom:14px; font-size:13px">
                <strong>Reporter:</strong>
                @if($incident->is_anonymous)
                    Anonymous
                @else
                    {{ $incident->user->name }}
                @endif
                <br>
                <strong>Category:</strong>
                {{ ucfirst(str_replace('_',' ', $incident->category)) }}
                <br>
                <strong>Location:</strong>
                {{ $incident->location_address }}
                <br>
                <strong>Evidence files:</strong>
                {{ $incident->incidentMedia->count() }}
            </div>

            <form method="POST" action="{{ route('incidents.verify', $incident) }}" style="display:inline" onsubmit="return confirm('Mark this incident as Verified?')">
                @csrf @method('PATCH')
                <button type="submit" class="verify-btn">
                    <i class="ti ti-circle-check" aria-hidden="true"></i> Verify Incident
                </button>
            </form>

            <button type="button" onclick="document.getElementById('reject-form').style.display='block'" class="reject-btn">
                <i class="ti ti-circle-x" aria-hidden="true"></i> Reject Incident
            </button>

            <div id="reject-form" style="display:none;margin-top:14px">
                <form method="POST" action="{{ route('incidents.reject', $incident) }}">
                    @csrf @method('PATCH')
                    <label style="font-size:13px; font-weight:500; display:block; margin-bottom:6px">Reason for rejection (optional):</label>
                    <textarea name="rejection_reason" rows="3" placeholder="Explain why this incident is being rejected..." style="width:100%; border:0.5px solid var(--color-border-secondary); border-radius:var(--border-radius-md); padding:10px; font-size:13px; margin-bottom:10px; resize:vertical"></textarea>
                    <button type="submit" class="reject-btn" onclick="return confirm('Reject this incident?')">Confirm Rejection</button>
                    <button type="button" onclick="document.getElementById('reject-form').style.display='none'" style="margin-left:8px; font-size:13px; padding:8px 14px; border:0.5px solid var(--color-border-secondary); border-radius:var(--border-radius-md); background:transparent; cursor:pointer">Cancel</button>
                </form>
            </div>
        </div>
        @endif
        @endcan

        <div class="card-handcrafted mb-8 incident-card severity-{{ $incident->severity }} {{ $incident->severity === 'critical' ? 'pulse-border' : '' }}">
            <div class="flex justify-between items-start gap-4 mb-4 flex-wrap">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-charcoal opacity-70 bg-sand px-2 py-1 rounded text-xs font-bold uppercase tracking-wider">{{ str_replace('_', ' ', $incident->category) }}</span>
                        <x-severity-badge :severity="$incident->severity" />
                        <span class="badge badge-{{ $incident->status_color }}">{{ ucfirst($incident->status) }}</span>
                    </div>
                    <h1 class="font-heading text-navy m-0" style="font-size: 2.5rem;">{{ $incident->title }}</h1>
                </div>
                
                @can('updateStatus', $incident)
                    <form action="{{ route('incidents.updateStatus', $incident) }}" method="POST" class="bg-cream p-3 rounded-lg border border-sand flex items-center gap-3">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="block text-xs font-bold uppercase opacity-70 mb-1">Update Status</label>
                            <select name="status" class="py-1 px-2 text-sm">
                                @foreach(\App\Models\Incident::STATUSES as $val => $label)
                                    <option value="{{ $val }}" {{ $incident->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn-primary py-1 px-3 text-sm">Save</button>
                    </form>
                @endcan
            </div>

            <div class="flex items-center gap-4 py-4 mb-4" style="border-top: 1px solid var(--color-sand); border-bottom: 1px solid var(--color-sand);">
                @if($incident->is_anonymous)
                    <div class="avatar-initials" style="background:var(--color-sand); color:var(--color-charcoal);">?</div>
                    <div>
                        <div class="font-bold">Anonymous Neighbor</div>
                        <div class="text-sm opacity-70">Reported <span data-timestamp="{{ $incident->created_at->toIso8601String() }}">{{ $incident->created_at->diffForHumans() }}</span></div>
                    </div>
                @else
                    @if($incident->user->avatar)
                        <img src="{{ Storage::url($incident->user->avatar) }}" alt="Avatar" class="avatar-img">
                    @else
                        <div class="avatar-initials">
                            {{ strtoupper(substr($incident->user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <div class="font-bold">{{ $incident->user->name }}</div>
                        <div class="text-sm opacity-70">Reported <span data-timestamp="{{ $incident->created_at->toIso8601String() }}">{{ $incident->created_at->diffForHumans() }}</span></div>
                    </div>
                @endif
                
                <div class="ml-auto text-right">
                    <div class="flex items-center gap-1 text-olive font-medium justify-end">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        {{ $incident->zone->name }}
                    </div>
                    @if($incident->location_address)
                        <div class="text-sm opacity-70 mt-1">{{ $incident->location_address }}</div>
                    @endif
                </div>
            </div>

            <div class="prose max-w-none text-lg leading-relaxed mb-6" style="color:var(--color-text-primary);">
                {{ nl2br(e($incident->description)) }}
            </div>

            <h3 class="font-heading text-navy text-xl mb-3">Attached Media</h3>
            @if($incident->incidentMedia->count() > 0)
                <div class="mb-6">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($incident->incidentMedia as $media)
                            @if($media->media_type === 'image')
                                <a href="{{ Storage::url($media->file_path) }}" target="_blank" style="display: block; height: 150px; overflow: hidden; border-radius: 8px; max-width: 100%; position: relative;">
                                    <img src="{{ Storage::url($media->file_path) }}" alt="Incident Media" style="width: 100%; height: 100%; object-fit: cover;">
                                </a>
                            @elseif($media->media_type === 'video')
                                <div style="display: block; height: 150px; overflow: hidden; border-radius: 8px; max-width: 100%; position: relative; background: #222;">
                                    <video src="{{ Storage::url($media->file_path) }}" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.5;"></video>
                                    <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="white" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </div>
                                    <a href="{{ Storage::url($media->file_path) }}" target="_blank" style="position: absolute; inset: 0; z-index: 10;"></a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <div style="background:var(--color-background-secondary); border-radius:var(--border-radius-lg); padding:40px; text-align:center; border:1px dashed var(--color-border-secondary)">
                    <i class="ti ti-photo-off" style="font-size:36px; color:var(--color-text-secondary)" aria-hidden="true"></i>
                    <p style="font-size:13px; color:var(--color-text-secondary); margin-top:8px">No evidence uploaded for this incident.</p>
                </div>
            @endif

            @if($incident->official_note)
                <div class="bg-olive bg-opacity-10 border-l-4 border-olive p-4 mb-6 mt-6">
                    <h4 class="font-bold text-olive flex items-center gap-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        Official Update
                    </h4>
                    <p class="m-0" style="color:var(--color-text-primary);">{{ $incident->official_note }}</p>
                </div>
            @endif
        </div>

        <!-- Comments Section -->
        <div class="card-handcrafted widget-card">
            <h2 class="font-heading text-navy text-2xl mb-6">Discussion ({{ $incident->comments->count() }})</h2>

            <div class="mb-8 space-y-6">
                @forelse($incident->comments as $comment)
                    <div class="flex gap-4 {{ $comment->is_official ? 'p-4 rounded-lg shadow-sm border border-amber' : '' }}">
                        <div class="flex-shrink-0">
                            @if($comment->user->avatar)
                                <img src="{{ Storage::url($comment->user->avatar) }}" alt="Avatar" class="avatar-img">
                            @else
                                <div class="avatar-initials" style="background-color: {{ $comment->is_official ? '#E8A030' : 'var(--color-background-secondary)' }}; color: {{ $comment->is_official ? 'white' : 'var(--color-text-primary)' }};">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold {{ $comment->is_official ? 'text-amber' : '' }}">{{ $comment->user->name }}</span>
                                @if($comment->is_official)
                                    <span class="bg-amber text-white text-xs px-2 py-0.5 rounded-full font-bold">Official</span>
                                @endif
                                <span class="text-sm opacity-60 font-mono ml-auto" data-timestamp="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="m-0" style="color:var(--color-text-primary);">{{ $comment->body }}</p>
                            
                            @can('delete', $comment)
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-2 text-right">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose text-xs bg-transparent border-none cursor-pointer hover:underline p-0" onclick="return confirm('Delete this comment?')">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @empty
                    <p class="text-center opacity-70 italic py-4">No comments yet. Be the first to share an update or offer help.</p>
                @endforelse
            </div>

            @can('create', [\App\Models\Comment::class, $incident])
                <form action="{{ route('comments.store', $incident) }}" method="POST" class="mt-4 pt-4" style="border-top: 1px solid var(--color-border-tertiary);">
                    @csrf
                    <div class="flex gap-4 items-start">
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="avatar-img">
                        @else
                            <div class="avatar-initials">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="flex-1">
                            <textarea name="body" rows="3" required placeholder="Add a comment, update, or offer assistance..." class="mb-2" style="background:var(--color-background-primary); border-color:var(--color-border-secondary); color:var(--color-text-primary);"></textarea>
                            @error('body')<span class="text-rose text-sm block mb-2">{{ $message }}</span>@enderror
                            <div class="text-right">
                                <button type="submit" class="btn-primary py-2 px-4 text-sm">Post Comment</button>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <div class="p-4 rounded text-center opacity-80 mt-6" style="background:var(--color-background-secondary);">
                    @if(in_array($incident->status, ['rejected', 'closed', 'dismissed']))
                        This incident has been {{ $incident->status }} and comments are closed.
                    @else
                        You do not have permission to comment on this incident.
                    @endif
                </div>
            @endcan
        </div>
    </div>
</x-app-layout>
