<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->paginate(20);
        
        // Group by date logic
        $groupedNotifications = $notifications->groupBy(function($notification) {
            if ($notification->created_at->isToday()) {
                return 'Today';
            } elseif ($notification->created_at->isCurrentWeek()) {
                return 'This week';
            }
            return 'Older';
        });

        return view('notifications.index', compact('notifications', 'groupedNotifications'));
    }

    public function markRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back();
    }

    public function markAllRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }
}
