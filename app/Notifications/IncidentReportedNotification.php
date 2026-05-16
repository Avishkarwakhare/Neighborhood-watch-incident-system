<?php

namespace App\Notifications;

use App\Models\Incident;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IncidentReportedNotification extends Notification
{
    use Queueable;

    public Incident $incident;

    public function __construct(Incident $incident)
    {
        $this->incident = $incident;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Incident Reported — ' . $this->incident->title)
            ->greeting('Hello!')
            ->line('A new ' . $this->incident->severity . ' severity incident was reported in ' . $this->incident->zone->name . ': ' . $this->incident->title)
            ->action('View Incident', route('incidents.show', $this->incident))
            ->line('Thank you for using SafeNeighbor.');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'A new ' . $this->incident->severity . ' incident was reported in ' . $this->incident->zone->name . ': ' . $this->incident->title,
            'incident_id' => $this->incident->id,
            'type' => 'incident_reported',
            'url' => route('incidents.show', $this->incident)
        ];
    }
}
