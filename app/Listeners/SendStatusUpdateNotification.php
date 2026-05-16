<?php

namespace App\Listeners;

use App\Events\IncidentStatusChanged;
use App\Notifications\StatusUpdateNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendStatusUpdateNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(IncidentStatusChanged $event): void
    {
        $incident = $event->incident;
        $user = $incident->user;

        if ($user) {
            $user->notify(new StatusUpdateNotification($incident, $event->oldStatus));
        }
    }
}
