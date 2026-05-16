<?php

namespace App\Listeners;

use App\Events\IncidentReported;
use App\Models\User;
use App\Notifications\IncidentReportedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendIncidentReportedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(IncidentReported $event): void
    {
        $incident = $event->incident;
        $zone = $incident->zone;

        // Get warden
        $warden = $zone->warden;

        // Get law enforcement in the same zone
        $lawEnforcement = User::where('zone_id', $zone->id)
            ->where('role', 'law_enforcement')
            ->where('is_approved', true)
            ->get();

        $notifiables = collect();
        if ($warden) {
            $notifiables->push($warden);
        }
        foreach ($lawEnforcement as $user) {
            $notifiables->push($user);
        }

        if ($notifiables->isNotEmpty()) {
            Notification::send($notifiables->unique('id'), new IncidentReportedNotification($incident));
        }
    }
}
