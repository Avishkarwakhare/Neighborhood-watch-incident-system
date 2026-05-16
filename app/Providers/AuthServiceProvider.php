<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Incident;
use App\Models\Comment;
use App\Models\Announcement;
use App\Policies\IncidentPolicy;
use App\Policies\CommentPolicy;
use App\Policies\AnnouncementPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Incident::class => IncidentPolicy::class,
        Comment::class => CommentPolicy::class,
        Announcement::class => AnnouncementPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('admin-access', fn($user) => $user->hasRole('admin'));
        Gate::define('warden-or-admin', fn($user) => $user->hasRole(['warden', 'admin']));
    }
}
