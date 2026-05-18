<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnnouncementPostedNotification extends Notification
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
        $creatorName = $this->announcement->user->name ?? 'Admin';
        $role = $this->announcement->user && $this->announcement->user->hasRole('admin') ? 'Admin' : 'Warden';
        
        return (new MailMessage)
            ->subject('New Announcement: ' . $this->announcement->title)
            ->line('A new announcement has been posted by ' . $role . ' (' . $creatorName . ').')
            ->line('Title: ' . $this->announcement->title)
            ->line($this->announcement->body)
            ->action('View Announcement', route('announcements.show', $this->announcement));
    }

    public function toArray($notifiable): array
    {
        $creatorName = $this->announcement->user->name ?? 'Admin';
        $role = $this->announcement->user && $this->announcement->user->hasRole('admin') ? 'Admin' : 'Warden';
        
        return [
            'message' => '📢 New announcement by ' . $role . ': ' . $this->announcement->title,
            'announcement_id' => $this->announcement->id,
            'type' => 'announcement_posted',
            'url' => route('announcements.show', $this->announcement),
            'details' => substr($this->announcement->body, 0, 100) . (strlen($this->announcement->body) > 100 ? '...' : '')
        ];
    }
}
