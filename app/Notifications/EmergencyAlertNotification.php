<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmergencyAlertNotification extends Notification
{
    use Queueable;

    public Announcement $announcement;

    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🚨 Emergency Alert — ' . $this->announcement->title)
            ->line('An emergency alert has been posted for ' . $this->announcement->zone->name . '.')
            ->line($this->announcement->body)
            ->action('View Alert', route('announcements.show', $this->announcement));
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => '🚨 Emergency Alert in ' . $this->announcement->zone->name . ': ' . $this->announcement->title,
            'announcement_id' => $this->announcement->id,
            'type' => 'emergency_alert',
            'url' => route('announcements.show', $this->announcement)
        ];
    }
}
