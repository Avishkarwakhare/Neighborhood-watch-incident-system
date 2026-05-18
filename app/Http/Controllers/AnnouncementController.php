<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Events\EmergencyAnnouncementPosted;
use App\Notifications\AnnouncementPostedNotification;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;

class AnnouncementController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = $request->user();
        
        $query = Announcement::active()->latest();
        
        if (!$user->hasRole('admin') && $user->zone_id) {
            $query->where(function ($q) use ($user) {
                $q->where('zone_id', $user->zone_id)
                  ->orWhereHas('user', function ($qu) {
                      $qu->where('role', 'admin');
                  });
            });
        }

        $announcements = $query->paginate(10);

        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        $this->authorize('create', Announcement::class);
        return view('announcements.create');
    }

    public function store(StoreAnnouncementRequest $request)
    {
        $this->authorize('create', Announcement::class);

        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['zone_id'] = $request->user()->zone_id;

        $announcement = Announcement::create($data);

        // Notify users
        $creator = $request->user();
        if ($creator->hasRole('admin')) {
            // Admin: Notify ALL approved users globally
            $users = User::where('is_approved', true)
                ->where('id', '!=', $creator->id)
                ->get();
        } else {
            // Warden: Notify approved users in the specific zone
            $users = User::where('zone_id', $announcement->zone_id)
                ->where('is_approved', true)
                ->where('id', '!=', $creator->id)
                ->get();
        }

        if ($users->isNotEmpty()) {
            Notification::send($users, new AnnouncementPostedNotification($announcement));
        }

        if ($announcement->priority === 'emergency') {
            event(new EmergencyAnnouncementPosted($announcement));
        }

        return redirect()->route('announcements.index')->with('success', 'Announcement posted.');
    }

    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        $this->authorize('update', $announcement);
        return view('announcements.edit', compact('announcement'));
    }

    public function update(StoreAnnouncementRequest $request, Announcement $announcement)
    {
        $this->authorize('update', $announcement);
        $announcement->update($request->validated());

        return redirect()->route('announcements.index')->with('success', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorize('delete', $announcement);
        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Announcement deleted.');
    }
}
