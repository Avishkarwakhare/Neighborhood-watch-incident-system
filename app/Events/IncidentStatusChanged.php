<?php

namespace App\Events;

use App\Models\Incident;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IncidentStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Incident $incident;
    public string $oldStatus;

    public function __construct(Incident $incident, string $oldStatus)
    {
        $this->incident = $incident;
        $this->oldStatus = $oldStatus;
    }
}
