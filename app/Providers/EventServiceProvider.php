<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\IncidentReported;
use App\Events\IncidentStatusChanged;
use App\Events\EmergencyAnnouncementPosted;
use App\Listeners\SendIncidentReportedNotification;
use App\Listeners\SendStatusUpdateNotification;
use App\Listeners\SendEmergencyAlertNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        IncidentReported::class => [
            SendIncidentReportedNotification::class,
        ],
        IncidentStatusChanged::class => [
            SendStatusUpdateNotification::class,
        ],
        EmergencyAnnouncementPosted::class => [
            SendEmergencyAlertNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
