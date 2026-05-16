<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\IncidentMedia;
use App\Http\Requests\StoreIncidentRequest;
use App\Http\Requests\UpdateIncidentStatusRequest;
use App\Events\IncidentReported;
use App\Events\IncidentStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IncidentController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user  = auth()->user();
        $query = Incident::with([
            'user', 'zone', 'locality',
            'society', 'comments'
        ]);

        // Location filter
        if ($user->hasRole('resident')) {
            $query->where(function($q) use ($user) {
                $q->where('society_id', $user->society_id)
                  ->orWhere('locality_id', $user->locality_id);
            });
        } elseif ($user->hasRole('warden')) {
            $query->where('locality_id', $user->locality_id);
        } elseif ($user->hasRole('law_enforcement')) {
            $query->where('zone_id', $user->zone_id);
        }

        // Search by keyword
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location_address', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $incidents = $query->latest()->paginate(10)->withQueryString();

        return view('incidents.index', compact('incidents'));
    }

    public function create()
    {
        return view('incidents.create');
    }

    public function store(StoreIncidentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['zone_id'] = $request->user()->zone_id;
        $data['state_id'] = $request->user()->state_id;
        $data['city_id'] = $request->user()->city_id;
        $data['locality_id'] = $request->user()->locality_id;
        $data['society_id'] = $request->user()->society_id;
        // is_anonymous checkbox might come as "on" or true
        $data['is_anonymous'] = $request->has('is_anonymous') ? true : false;

        $incident = Incident::create($data);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('incidents', 'public');
                $type = 'document';
                if (str_starts_with($file->getMimeType(), 'image/')) $type = 'image';
                if (str_starts_with($file->getMimeType(), 'video/')) $type = 'video';

                IncidentMedia::create([
                    'incident_id' => $incident->id,
                    'file_path' => $path,
                    'media_type' => $type
                ]);
            }
        }

        event(new IncidentReported($incident));

        return redirect()->route('incidents.show', $incident)->with('success', 'Incident reported successfully.');
    }

    public function show(Incident $incident)
    {
        $this->authorize('view', $incident);

        $incident->load(['user', 'zone', 'incidentMedia', 'comments.user']);

        return view('incidents.show', compact('incident'));
    }

    public function edit(Incident $incident)
    {
        $this->authorize('update', $incident);
        return view('incidents.edit', compact('incident'));
    }

    public function update(StoreIncidentRequest $request, Incident $incident)
    {
        $this->authorize('update', $incident);
        $incident->update($request->validated());

        return redirect()->route('incidents.show', $incident)->with('success', 'Incident updated successfully.');
    }

    public function destroy(Incident $incident)
    {
        $this->authorize('delete', $incident);
        $incident->delete();

        return redirect()->route('incidents.index')->with('success', 'Incident deleted.');
    }

    public function updateStatus(UpdateIncidentStatusRequest $request, Incident $incident)
    {
        $this->authorize('updateStatus', $incident);

        $oldStatus = $incident->status;
        $incident->status = $request->status;
        if ($request->filled('official_note')) {
            $incident->official_note = $request->official_note;
        }

        if ($request->status === 'resolved' && $oldStatus !== 'resolved') {
            $incident->resolved_at = now();
        }

        $incident->save();

        if ($oldStatus !== $incident->status) {
            event(new IncidentStatusChanged($incident, $oldStatus));
        }

        return back()->with('success', 'Status updated.');
    }

    public function myIncidents()
    {
        $incidents = Incident::with([
            'zone', 'locality', 'society',
            'incidentMedia', 'comments'
        ])
        ->where('user_id', auth()->id())
        ->latest()
        ->paginate(10);

        $stats = [
            'total'    => Incident::where('user_id', auth()->id())->count(),
            'pending'  => Incident::where('user_id', auth()->id())
                            ->where('status', 'pending')
                            ->count(),
            'resolved' => Incident::where('user_id', auth()->id())
                            ->where('status', 'resolved')
                            ->count(),
            'rejected' => Incident::where('user_id', auth()->id())
                            ->where('status', 'rejected')
                            ->count(),
        ];

        return view('incidents.my-history', compact('incidents', 'stats'));
    }

    public function verify(Incident $incident)
    {
        $this->authorize('updateStatus', $incident);
        
        $incident->update([
            'status' => 'verified',
        ]);

        if (class_exists(\App\Notifications\StatusUpdateNotification::class)) {
            $incident->user->notify(new \App\Notifications\StatusUpdateNotification($incident, 'pending'));
        }

        return back()->with('success', 'Incident verified successfully.');
    }

    public function reject(Request $request, Incident $incident)
    {
        $this->authorize('updateStatus', $incident);
        
        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $incident->update([
            'status'       => 'rejected',
            'official_note'=> $request->rejection_reason ?? 'Incident rejected by administrator.',
        ]);

        if (class_exists(\App\Notifications\StatusUpdateNotification::class)) {
            $incident->user->notify(new \App\Notifications\StatusUpdateNotification($incident, 'processing'));
        }

        return back()->with('success', 'Incident has been rejected.');
    }
}
