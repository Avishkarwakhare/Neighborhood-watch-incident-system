<?php

namespace App\Listeners;

use App\Events\EmergencyAnnouncementPosted;
use App\Models\User;
use App\Notifications\EmergencyAlertNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendEmergencyAlertNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(EmergencyAnnouncementPosted $event): void
    {
        $announcement = $event->announcement;
        $zone = $announcement->zone;

        // Get ALL approved users in the zone
        $users = User::where('zone_id', $zone->id)
            ->where('is_approved', true)
            ->get();

        if ($users->isNotEmpty()) {
            Notification::send($users, new EmergencyAlertNotification($announcement));
        }
    }
}
