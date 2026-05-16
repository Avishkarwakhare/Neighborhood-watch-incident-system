@extends('layouts.app')
@section('content')

<style>
.history-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
  background: var(--bg-card, var(--color-background-primary));
  border-radius: var(--border-radius-lg);
  overflow: hidden;
  border: 0.5px solid var(--color-border-tertiary);
}
.history-table th {
  background: var(--color-background-secondary);
  padding: 12px 14px;
  text-align: left;
  font-weight: 500;
  font-size: 12px;
  color: var(--color-text-secondary);
  border-bottom: 0.5px solid var(--color-border-tertiary);
}
.history-table td {
  padding: 12px 14px;
  border-bottom: 0.5px solid var(--color-border-tertiary);
  vertical-align: top;
}
.history-table tr:last-child td {
  border-bottom: none;
}
.history-table tr:hover td {
  background: var(--color-background-secondary);
}
</style>

<div class="container py-8" style="max-width: 1000px; margin: 0 auto;">
    <div style="margin-bottom: 24px;">
        <h1 style="font-family:'Caveat',cursive; font-size:28px; color:#C4622D; margin: 0;">My Incident History</h1>
        <p style="color:var(--color-text-secondary); font-size:13px; margin: 0;">All incidents you have reported</p>
    </div>

    <!-- STATS ROW -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 32px;">
        <div style="background: var(--bg-card, var(--color-background-primary)); border: 0.5px solid var(--color-border-tertiary); border-radius: 16px; padding: 20px;">
            <div style="font-size: 28px; font-weight: 600;">{{ $stats['total'] }}</div>
            <div style="font-size: 13px; color: var(--color-text-secondary);">Total reported</div>
        </div>
        <div style="background: var(--bg-card, var(--color-background-primary)); border: 0.5px solid var(--color-border-tertiary); border-radius: 16px; padding: 20px;">
            <div style="font-size: 28px; font-weight: 600; color: #E8A030;">{{ $stats['pending'] }}</div>
            <div style="font-size: 13px; color: var(--color-text-secondary);">Pending</div>
        </div>
        <div style="background: var(--bg-card, var(--color-background-primary)); border: 0.5px solid var(--color-border-tertiary); border-radius: 16px; padding: 20px;">
            <div style="font-size: 28px; font-weight: 600; color: #5C6B3A;">{{ $stats['resolved'] }}</div>
            <div style="font-size: 13px; color: var(--color-text-secondary);">Resolved</div>
        </div>
        <div style="background: var(--bg-card, var(--color-background-primary)); border: 0.5px solid var(--color-border-tertiary); border-radius: 16px; padding: 20px;">
            <div style="font-size: 28px; font-weight: 600; color: #C94040;">{{ $stats['rejected'] }}</div>
            <div style="font-size: 13px; color: var(--color-text-secondary);">Rejected</div>
        </div>
    </div>

    <!-- INCIDENTS TABLE -->
    <table class="history-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Category</th>
                <th>Location</th>
                <th>Status</th>
                <th>Evidence</th>
                <th>Reported on</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($incidents as $inc)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <div style="font-weight:500; font-size:13px;">{{ $inc->title }}</div>
                    <div style="font-size:11px; color:var(--color-text-secondary);">{{ Str::limit($inc->description, 60) }}</div>
                </td>
                <td>
                    <span class="badge badge-gray">{{ ucfirst(str_replace('_',' ', $inc->category)) }}</span>
                </td>
                <td style="font-size:12px">
                    {{ $inc->society->name ?? $inc->location_address }}
                </td>
                <td>
                    <span class="badge badge-{{ $inc->status_color }}">{{ ucfirst($inc->status) }}</span>
                </td>
                <td>
                    @if($inc->incidentMedia->count() > 0)
                        <span class="badge badge-blue"><i class="ti ti-photo"></i> {{ $inc->incidentMedia->count() }}</span>
                    @else
                        <span style="color:var(--color-text-secondary); font-size:12px">None</span>
                    @endif
                </td>
                <td style="font-size:12px; font-family:'JetBrains Mono', monospace;">
                    {{ $inc->created_at->format('d M Y') }}<br>
                    <span style="color:var(--color-text-secondary)">{{ $inc->created_at->format('g:i A') }}</span>
                </td>
                <td>
                    <a href="{{ route('incidents.show', $inc) }}" style="font-size:12px; color:#C4622D; text-decoration:none;">View →</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:40px; color:var(--color-text-secondary)">
                    <i class="ti ti-clipboard-off" style="font-size:32px; display:block; margin-bottom:8px"></i>
                    You have not reported any incidents yet.<br>
                    <a href="{{ route('incidents.create') }}" style="color:#C4622D; font-size:13px; margin-top:8px; display:inline-block">Report your first incident →</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 24px;">
        {{ $incidents->links() }}
    </div>
</div>

@endsection
