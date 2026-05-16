<?php

namespace App\Notifications;

use App\Models\Incident;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusUpdateNotification extends Notification
{
    use Queueable;

    public Incident $incident;
    public string $oldStatus;

    public function __construct(Incident $incident, string $oldStatus)
    {
        $this->incident = $incident;
        $this->oldStatus = $oldStatus;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Incident Update — ' . $this->incident->title)
            ->line('The status of your incident "' . $this->incident->title . '" changed from ' . str_replace('_', ' ', $this->oldStatus) . ' to ' . str_replace('_', ' ', $this->incident->status) . '.')
            ->action('View Incident', route('incidents.show', $this->incident));
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Your incident "' . $this->incident->title . '" status changed to ' . str_replace('_', ' ', $this->incident->status),
            'incident_id' => $this->incident->id,
            'type' => 'status_update',
            'url' => route('incidents.show', $this->incident)
        ];
    }
}
